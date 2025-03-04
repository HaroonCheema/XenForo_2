<?php

namespace FS\CoinPal\Payment;

use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Coin extends AbstractProvider
{

    public function getTitle()
    {

        return 'CoinPal';
    }

    public function getApiEndpoint()
    {

        return 'https://pay.coinpal.io';
    }

    public function verifyConfig(array &$options, &$errors = [])
    {

        if (empty($options['merchant_id'])) {
            $errors[] = \XF::phrase('fs_coinpal_merchant_id_must_required');
            return false;
        }

        if (empty($options['secret_key'])) {
            $errors[] = \XF::phrase('fs_coinpal_secret_key_must_required');
            return false;
        }

        return true;
    }

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {

        $paymentProfile = $purchase->paymentProfile;
        $merchant_id = $paymentProfile->options['merchant_id'];

        // echo "<pre>";
        // var_dump($merchant_id);
        // exit;

        return [
            'purchaseRequest' => $purchaseRequest,
            'paymentProfile' => $paymentProfile,
            'purchaser' => $purchase->purchaser,
            'purchase' => $purchase,
            'purchasableTypeId' => $purchase->purchasableTypeId,
            'purchasableId' => $purchase->purchasableId,
            'merchant_id' => $merchant_id,
            'cost' => $purchase->cost
        ];
    }

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
    {

        $paymentRepo = \XF::repository('XF:Payment');

        $merchantId = $purchase->paymentProfile->options['merchant_id'];
        $secretKey = $purchase->paymentProfile->options['secret_key'];

        $requestId = $purchaseRequest->request_key;
        $orderNo = $purchaseRequest->request_key;
        $orderAmount = $purchase->cost;
        $orderCurrency = $purchase->currency;
        $purchaser = $purchase->purchaser;

        // $redirectURL = "http://localhost/xenforo/index.php?account/upgrade-purchase";

        // echo "<pre>";
        // var_dump($purchase->returnUrl);
        // exit;

        $chargeData = array();

        try {

            $signData = $secretKey . $requestId . $merchantId . $orderNo . $orderAmount . $orderCurrency;

            $signature = hash('sha256', $signData);

            $client = $this->getHttpClient();

            $chargeParams = [
                'json' => [

                    'version' => "2.1",
                    'requestId' => $requestId,
                    'merchantNo' => $merchantId,
                    'orderNo' => $orderNo,
                    'orderCurrencyType' => 'fiat',
                    'orderCurrency' => $purchase->currency,
                    'orderAmount' => $orderAmount,
                    'notifyURL' => $this->notificationUrl(),
                    'redirectURL' => $purchase->returnUrl,
                    'payerEmail' => $purchaser->email ?: "",
                    'sign' => $signature,
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            ];

            $charge = \GuzzleHttp\json_decode($client->post(
                $this->getApiEndpoint() . '/gateway/pay/checkout',
                $chargeParams
            )->getBody()->getContents(), true);

            $chargeData = $charge;

            $invoiceId = 0;
            $redirectUrl = '';

            if ($chargeData['respCode'] == 200) {
                $invoiceId = $chargeData['reference'];
                $redirectUrl = $chargeData['nextStepContent'];
            } else {

                throw $controller->exception($controller->error($chargeData['respMessage']));
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {


            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? $error['error']['message'] : '';

            throw $controller->exception($controller->noPermission($message));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \XF::logException($e, false, "plisio error: ");

            throw $controller->exception($controller->error(\XF::phrase('something_went_wrong_please_try_again')));
        }


        $paymentRepo->logCallback(
            $purchaseRequest->request_key,
            $this->providerId,
            $invoiceId,
            'info',
            'CoinPal Invoice created',
            [$chargeData],
            $purchase->purchaser->user_id
        );

        return $controller->redirect($redirectUrl);
    }

    public function notificationUrl()
    {

        return \xf::options()->boardUrl . "/payment_callback.php?_xfProvider=coin_pal";
        // return \xf::options()->boardUrl . "/payment_callback.php?_xfProvider=bit_cart";
    }

    // public function paymentRedirectUrl($basicRoute, $invoiceId)
    // {


    //     return $basicRoute . "/i/" . $invoiceId;
    // }

    // public function validatePurchaser(CallbackState $state)
    // {
    //     if ($this->isGuestPurchaseUserUpgrade($state->getPurchaseRequest())) {
    //         $state->isGuestPurchaseUserUpgrade = true;

    //         return true;
    //     }

    //     return parent::validatePurchaser($state);
    // }

    // public function completeTransaction(CallbackState $state)
    // {
    //     if ($state->isGuestPurchaseUserUpgrade) {
    //         $this->logAsGuestPaidUserUpgrade($state);
    //     } else {
    //         parent::completeTransaction($state);
    //     }
    // }

    /**
     * @param \XF\Http\Request $request
     *
     * @return CallbackState
     */
    public function setupCallback(\XF\Http\Request $request)
    {

        $state = new CallbackState();

        $state->notifyURL = $request->filter('notifyURL', 'str');
        $state->version = $request->filter('version', 'str');
        $state->merchantNo = $request->filter('merchantNo', 'str');
        $state->reference = $request->filter('reference', 'str');
        $state->orderAmount = $request->filter('orderAmount', 'str');
        $state->selectedWallet = $request->filter('selectedWallet', 'str');
        $state->dueAmount = $request->filter('dueAmount', 'str');
        $state->paidAmount = $request->filter('paidAmount', 'str');
        $state->status = $request->filter('status', 'str');
        $state->secretKey = $request->filter('secretKey', 'str');
        $state->requestId = $request->filter('requestId', 'str');
        $state->orderNo = $request->filter('orderNo', 'str');
        $state->orderCurrency = $request->filter('orderCurrency', 'str');
        $state->paidOrderAmount = $request->filter('paidOrderAmount', 'str');
        $state->dueCurrency = $request->filter('dueCurrency', 'str');
        $state->paidCurrency = $request->filter('paidCurrency', 'str');
        $state->paidUsdt = $request->filter('paidUsdt', 'str');
        $state->confirmedTime = $request->filter('confirmedTime', 'str');
        $state->remark = $request->filter('remark', 'str');
        $state->unresolvedLabel = $request->filter('unresolvedLabel', 'str');

        return $state;

        $state = new CallbackState();
        $inputRaw = $request->getInputRaw();
        $state->inputRaw = $inputRaw;

        $input = @json_decode($inputRaw, true);
        $filtered = \XF::app()->inputFilterer()->filterArray($input ?: [], [
            'notifyURL' => 'str',
            'version' => 'str',
            'merchantNo' => 'str',
            'reference' => 'str',
            'orderAmount' => 'str',
            'selectedWallet' => 'str',
            'dueAmount' => 'str',
            'paidAmount' => 'str',
            'paidAddress' => 'str',
            'status' => 'str',
            'secretKey' => 'str',
            'requestId' => 'str',
            'orderNo' => 'str',
            'orderCurrency' => 'str',
            'paidOrderAmount' => 'str',
            'dueCurrency' => 'str',
            'paidCurrency' => 'str',
            'paidUsdt' => 'str',
            'confirmedTime' => 'str',
            'remark' => 'str',
            'unresolvedLabel' => 'str'
        ]);

        $state->notifyURL = isset($filtered['notifyURL']) ? $filtered['notifyURL'] : "";
        $state->version = isset($filtered['version']) ? $filtered['version'] : "";
        $state->merchantNo = isset($filtered['merchantNo']) ? $filtered['merchantNo'] : "";
        $state->reference = isset($filtered['reference']) ? $filtered['reference'] : "";
        $state->orderAmount = isset($filtered['orderAmount']) ? $filtered['orderAmount'] : "";
        $state->selectedWallet = isset($filtered['selectedWallet']) ? $filtered['selectedWallet'] : "";
        $state->dueAmount = isset($filtered['dueAmount']) ? $filtered['dueAmount'] : "";
        $state->paidAmount = isset($filtered['paidAmount']) ? $filtered['paidAmount'] : "";
        $state->status = isset($filtered['status']) ? $filtered['status'] : "";
        $state->secretKey = isset($filtered['secretKey']) ? $filtered['secretKey'] : "";
        $state->requestId = isset($filtered['requestId']) ? $filtered['requestId'] : "";
        $state->orderNo = isset($filtered['orderNo']) ? $filtered['orderNo'] : "";
        $state->orderCurrency = isset($filtered['orderCurrency']) ? $filtered['orderCurrency'] : "";
        $state->paidOrderAmount = isset($filtered['paidOrderAmount']) ? $filtered['paidOrderAmount'] : "";
        $state->dueCurrency = isset($filtered['dueCurrency']) ? $filtered['dueCurrency'] : "";
        $state->paidCurrency = isset($filtered['paidCurrency']) ? $filtered['paidCurrency'] : "";
        $state->paidUsdt = isset($filtered['paidUsdt']) ? $filtered['paidUsdt'] : "";
        $state->confirmedTime = isset($filtered['confirmedTime']) ? $filtered['confirmedTime'] : "";
        $state->remark = isset($filtered['remark']) ? $filtered['remark'] : "";
        $state->unresolvedLabel = isset($filtered['unresolvedLabel']) ? $filtered['unresolvedLabel'] : "";


        // $state->eventType = isset($filtered['status']) ? $filtered['status'] : "";
        // $state->transactionId = isset($filtered['id']) ? $filtered['id'] : "";

        $state->event = $filtered;

        // if ($state->transactionId) {

        //     list($reqeustkey, $invoiceData) = $this->invoiceStatus($state->transactionId);

        //     $state->requestKey = $reqeustkey;

        //     if ($invoiceData) {

        //         $state->event = $invoiceData;
        //     }
        // }

        return $state;
    }

    public function validateCallback(CallbackState $state)
    {

        if (!$state->status) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal:Invalid Valid Event Type.';
            $state->httpCode = 404;

            return false;
        }

        if (!$state->orderNo) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: Invalid purchase request.Order not found.';
            $state->httpCode = 404;

            return false;
        }

        if (!$state->getPurchaseRequest()) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: purchase request Not Found.';
            $state->httpCode = 404;

            return false;
        }

        // ['merchant_id'];
        // ['secret_key'];

        if (!$state->getPaymentProfile()->options['secret_key']) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: Invalid purchase request.Secret Key Not Set in Payment Profile';
            $state->httpCode = 401;

            return false;
        }

        if (!$state->getPaymentProfile()->options['merchant_id']) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: Invalid purchase request.Merchant Id Not Set in Payment Profile';
            $state->httpCode = 401;

            return false;
        }

        $paymentStatus = ["paid", "partial_paid", "paid_confirming", "partial_paid_confirming"];

        if (!in_array($state->status, $paymentStatus)) {

            $state->logType = 'info';
            $state->logMessage = 'CoinPal: Event "' . htmlspecialchars($state->status) . '" processed.';
            $state->httpCode = 200;

            return false;
        }

        return true;
    }

    public function getPaymentResult(CallbackState $state)
    {
        switch ($state->status) {
            case 'paid':
                // case 'partial_paid':
                // case 'partial_paid_confirming':
                // case 'paid_confirming':
                $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
                break;
            case 'invalid':
                $state->paymentResult = CallbackState::PAYMENT_REINSTATED;
                break;
        }
    }

    public function prepareLogData(CallbackState $state)
    {

        $state->logDetails = $state->_POST;

        // $state->logDetails = $state->orderNo;
        // $state->logDetails['eventType'] = $state->status;
        // $state->logDetails['eventType'] = $state->eventType;
    }

    public function supportsRecurring(\XF\Entity\PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING)
    {
        return false;
    }

    protected function getHttpClient()
    {
        $client = \XF::app()->http()->client();
        return $client;
    }

    // public function invoiceStatus($invoiceId)
    // {


    //     $client = $this->getHttpClient();

    //     try {

    //         $invoiceData = \GuzzleHttp\json_decode($client->get($this->getApiEndpoint() . '/invoices/' . $invoiceId)->getBody()->getContents(), true);

    //         $requestKey = $invoiceData['order_id'];
    //     } catch (\Exception $e) {

    //         return [null, null];
    //     }

    //     return [$requestKey, $invoiceData];
    // }
}
