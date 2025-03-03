<?php

namespace XC\TebexPayment\Payment;

use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Tebex extends AbstractProvider {

    protected $tbVersion = '2024-04-03';
    protected $username = '';
    protected $password = '';

    public function getTitle() {
        return 'Tebex';
    }

    public function getApiEndpoint() {

        return 'https://checkout.tebex.io/api';
    }

    public function verifyConfig(array &$options, &$errors = []) {


        if (isset($options['wallet_address'])) {

            return true;
        }
        if (empty($options['username'])) {
            $errors[] = \XF::phrase('must_provide_username');
            return false;
        }

        if (empty($options['password'])) {
            $errors[] = \XF::phrase('must_provide_password');
            return false;
        }

        if (empty($options['webhook_secret'])) {
            $errors[] = \XF::phrase('must_provide_webhook_url');
            return false;
        }

        return true;
    }

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase) {

        $paymentProfile = $purchase->paymentProfile;

        return [
            'purchaseRequest' => $purchaseRequest,
            'paymentProfile' => $paymentProfile,
            'purchaser' => $purchase->purchaser,
            'purchase' => $purchase,
            'purchasableTypeId' => $purchase->purchasableTypeId,
            'purchasableId' => $purchase->purchasableId,
            'cost' => $purchase->cost
        ];
    }

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase) {

		

         if ($purchaseRequest->purchasable_type_id == "xfa_rmmp_purchase") {
            $PaymentProfile = \xf::app()->finder('XF:PaymentProfile')->where('provider_id', 'xc_tebex')->where('xfa_rmmp_user_id', 0)->fetchOne();
         
         }
        if(!isset($purchase->paymentProfile->options['username'])){
            
              $PaymentProfile = \xf::app()->finder('XF:PaymentProfile')->where('provider_id', 'xc_tebex')->where('xfa_rmmp_user_id', 0)->fetchOne();
              $this->username = $PaymentProfile->options['username'];
              $this->password = $PaymentProfile->options['password'];
              $callbackUrl = $PaymentProfile->options['webhook_secret'];
            
        }else{
            
             $this->username = $purchase->paymentProfile->options['username'];

             $this->password = $purchase->paymentProfile->options['password'];
             $callbackUrl = $purchase->paymentProfile->options['webhook_secret'];
        }
        

        $paymentRepo = \XF::repository('XF:Payment');

       
        $basketData = $this->addDataBasket($callbackUrl, $purchase, $purchaseRequest);

        $identId = $this->requestBasketData($controller, $basketData);

        $packageData = $this->addPackageData($callbackUrl, $purchase, $purchaseRequest);

        
        if ($purchaseRequest->purchasable_type_id == "xfa_rmmp_purchase") {

            $packageData = $this->addResourceOwnerWalletShareWithAdminCommision($controller, $packageData, $purchaseRequest, $purchase);
        }
		
	
     
        $charge = $this->requestPackageData($controller, $identId, $packageData);

        $chargeData = json_decode($charge);

        $transactionId = $chargeData->rows[0]->id;

        $paymentRepo->logCallback(
                $purchaseRequest->request_key,
                $this->providerId,
                $transactionId,
                'info',
                'Charge created',
                [$chargeData],
                $purchase->purchaser->user_id
        );

        return $controller->redirect($chargeData->links->checkout);
    }

    public function addResourceOwnerWalletShareWithAdminCommision($controller, $requestData, $purchaseRequest, $purchase) {

        $userGroupIds=[];
        
        if($purchaseRequest->User->user_group_id){
            
            $userGroupIds[]=$purchaseRequest->User->user_group_id;
        }
        
        if(count($purchaseRequest->User->secondary_group_ids)){
            
            foreach($purchaseRequest->User->secondary_group_ids as $groupId){
                
                $userGroupIds[]=$groupId;
                
            }
            
            
        }
        
        $userGroupComission=$this->lowestUserGroupComission($userGroupIds);
       

        $amount = 0;

        if ($userGroupComission) {


            $requestData['revenue_share'][0]['wallet_ref'] = $userGroupComission->wallet_address;

            $amount = sprintf("%.2f", $purchase->cost * ($userGroupComission->comission / 100));

            $requestData['revenue_share'][0]['amount'] =  (float)$amount;
        }
        
        
        $resourcePurchase = \xf::app()->finder('XFA\RMMarketplace:Purchase')->where('purchase_id', $purchaseRequest->extra_data['purchase_id'])->fetchOne();

        if (!$resourcePurchase) {

            throw $controller->exception($controller->error("Purchase Resource Request Not Found"));
        }

        $resource = $resourcePurchase->Resource;

        if (!$resource) {

            throw $controller->exception($controller->error("Resource  Not Found"));
        }

        $resourceOwner = $resource->User;

        $tebexPaymentProfile = \xf::app()->finder('XF:PaymentProfile')->where('provider_id', 'xc_tebex')->where('xfa_rmmp_user_id', $resourceOwner->user_id)->fetchOne();

        if (!$tebexPaymentProfile) {

            return $requestData;
            
            throw $controller->exception($controller->error("Owner of resource did not add the Wallet Address"));
        }


        if (!isset($tebexPaymentProfile->options['active'])) {

            return $requestData;
            
            throw $controller->exception($controller->error("Owner of resource wallet address not active"));
        }
        if (!isset($tebexPaymentProfile->options['wallet_address'])) {

            return $requestData;
            
            throw $controller->exception($controller->error("Owner of resource did not add the Wallet Address"));
        }

        $walletAddressResourceOwener = $tebexPaymentProfile->options['wallet_address'];

        if ($walletAddressResourceOwener && $userGroupComission) {

            $requestData['revenue_share'][1]['wallet_ref'] = $walletAddressResourceOwener;

            $amount = $purchase->cost - $amount;

            $requestData['revenue_share'][1]['amount'] = $amount;
        } elseif ($walletAddressResourceOwener && !$userGroupComission) {

            $requestData['revenue_share'][0]['wallet_ref'] = $walletAddressResourceOwener;

            $amount = $purchase->cost - $amount;

            $requestData['revenue_share'][0]['amount'] = (float) $amount;
        }


        return $requestData;
    }
    
    public function lowestUserGroupComission($userGroupIds){
        
        
        return  \xf::app()->finder('XF:UserGroup')->where('user_group_id', $userGroupIds)->where('wallet_address','!=','')->where('comission','!=',0)->order('comission','asc')->fetchOne();
         
         
    }

    public function addPackageData($callbackUrl, $purchase, $purchaseRequest) {

        $requestData = [
            'package' => [
                'name' => substr($purchase->title, 0, 99),
                'price' => (float) $purchase->cost,
                'expiry_period' => 'day',
                'expiry_length' => 30,
                'metaData' => [
                    'custom' => [
                        'user_id' => $purchase->purchaser->user_id,
                        'purchaseableTypeId' => $purchase->purchasableTypeId,
                        'purchaseableId' => $purchase->purchasableId,
                        'request_key' => $purchaseRequest->request_key
                    ]
                ]
            ],
            'qty' => 1,
            'revenue_share' => [],
        ];

        return $requestData;
    }

    public function requestPackageData($controller, $identId, $packageData) {





        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getApiEndpoint() . '/baskets/' . $identId . '/packages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($packageData),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . base64_encode("{$this->username}:{$this->password}")
            ),
        ));

        $response = curl_exec($curl);

        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpStatusCode != 200) {

            $error = json_decode($response, true);

            $title = isset($error['title']) ? $error['title'] : "something went wrong";
            $detail = isset($error['detail']) ? $error['detail'] : "something went wrong";
            throw $controller->exception($controller->error($title . "." . $detail));
        }

        if (!json_decode($response)->links->checkout) {

            throw $controller->exception($controller->error(\XF::phrase('something_went_wrong_please_try_again')));
        }


        return $response;
    }

    public function requestBasketData($controller, $basketData) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->getApiEndpoint() . '/baskets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($basketData),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . base64_encode("{$this->username}:{$this->password}")
            ),
        ));

        $response = curl_exec($curl);

        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpStatusCode != 200) {

            $error = json_decode($response, true);

            $title = isset($error['title']) ? $error['title'] : "something went wrong";
            $detail = isset($error['detail']) ? $error['detail'] : "something went wrong";
            throw $controller->exception($controller->error($title . "." . $detail));
        }



        $ident = json_decode($response)->ident;
        if (!$ident) {

            throw $controller->exception($controller->error(\XF::phrase('something_went_wrong_please_try_again')));
        }


        return $ident;
    }

    public function addDataBasket($callbackUrl, $purchase, $purchaseRequest) {


        $requestData = [
            'return_url' => $purchase->returnUrl,
            'cancel_url' => $purchase->cancelUrl,
            'complete_url' => $callbackUrl,
            'customObject' => null,
            'first_name' => $purchaseRequest->User->username,
            'email' => $purchaseRequest->User->email ? $purchaseRequest->User->email : "",
            'custom' => [
                'user_id' => $purchase->purchaser->user_id,
                'purchaseableTypeId' => $purchase->purchasableTypeId,
                'purchaseableId' => $purchase->purchasableId,
                'request_key' => $purchaseRequest->request_key
            ],
        ];

        return $requestData;
    }

    public function setupCallback(\XF\Http\Request $request) {

        $state = new CallbackState();

        $inputRaw = $request->getInputRaw();
        $state->inputRaw = $inputRaw;

        $input = @json_decode($inputRaw, true);
        $filtered = \XF::app()->inputFilterer()->filterArray($input ?: [], [
            'id' => 'uint',
            'type' => 'str',
            'subject' => 'array'
        ]);

        $event = isset($filtered['subject']) ? $filtered['subject'] : '';

        if ($event) {

            $state->requestKey = isset($event['products'][0]['custom']['request_key']) ? $event['products'][0]['custom']['request_key'] : '';
            $state->transactionId = isset($event['transaction_id']) ? $event['transaction_id'] : '';
        }

        $state->id = isset($filtered['id']) ? $filtered['id'] : '';
        $state->eventType = isset($filtered['type']) ? $filtered['type'] : '';
        $state->event = $event;
        return $state;
    }

    public function validateCallback(CallbackState $state) {



        if (!$state->eventType) {

            $state->logType = 'error';
            $state->logMessage = 'Resource not validate.';
            $state->httpCode = 500;

            return false;
        }


        if (!$state->getPurchaseRequest()) {
            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.';
            return false;
        }

      //  if (!$this->verifyCallbackSignature($state->inputRaw, $state->getPaymentProfile()->options['password'])) {
       //     $state->logType = 'error';
        //    $state->logMessage = 'Webhook received from Tebex could not be verified as being valid. Secret mismatch.';
         //   $state->httpCode = 500;

          //  return false;
       // }

        $skippableEvents = [
            'payment.declined',
            'payment.refunded',
            'payment.dispute.opened',
            'payment.dispute.won',
            'payment.dispute.lost',
            'payment.dispute.closed',
            'recurring-payment.started',
            'recurring-payment.renewed',
            'recurring-payment.ended',
            'recurring-payment.status-changed',
        ];

        if ($state->eventType && in_array($state->eventType, $skippableEvents)) {
            $state->logType = 'info';
            $state->logMessage = 'Tebex: Event "' . htmlspecialchars($state->eventType) . '" processed. No action required.';
            $state->httpCode = 200;
            return false;
        }


        if (!$state->eventType || !$state->requestKey || !$state->event) {
            $state->logType = 'error';
            $state->logMessage = 'Webhook received from Tebex could not be verified as being valid. Invalid payload.';
            $state->httpCode = 500;

            return false;
        }

        return true;
    }

    public function getPaymentResult(CallbackState $state) {
        switch ($state->eventType) {
            case 'payment.completed':
                $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
                break;
        }
    }

    public function prepareLogData(CallbackState $state) {
        $state->logDetails = $state->event;
        $state->logDetails['eventType'] = $state->eventType;
    }

    public function supportsRecurring(\XF\Entity\PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING) {
        return false;
    }

    protected function verifyCallbackSignature($payload, $secret) {
        $computedSignature = \hash_hmac('sha256', $payload, $secret);

        if (!$computedSignature) {
            return false;
        }

        return true;
    }
}