<?php

namespace FS\BitCart\Payment;

use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Cart extends AbstractProvider {

    use \AddonFlare\PaidRegistrations\Payment\PaidRegistrationsTrait;

    public function getTitle() {

        return 'BitCart';
    }

    public function getApiEndpoint() {

        return 'https://api.bitcart.ai';
    }

    public function verifyConfig(array &$options, &$errors = []) {

        if (empty($options['store_id'])) {
            $errors[] = \XF::phrase('store_id_must_require');
            return false;
        }

        if (empty($options['basic_url'])) {
            $errors[] = \XF::phrase('basic_url_must_required');
            return false;
        }

        return true;
    }

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase) {


        $paymentProfile = $purchase->paymentProfile;
        $store_id = $paymentProfile->options['store_id'];

        return [
            'purchaseRequest' => $purchaseRequest,
            'paymentProfile' => $paymentProfile,
            'purchaser' => $purchase->purchaser,
            'purchase' => $purchase,
            'purchasableTypeId' => $purchase->purchasableTypeId,
            'purchasableId' => $purchase->purchasableId,
            'store_id' => $store_id,
            'cost' => $purchase->cost
        ];
    }

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase) {


        $isGuest = ($this->isGuestPurchaseUserUpgrade($purchaseRequest) && $this->isFromRegistration());

        if ($isGuest) {
            $purchase->returnUrl = $this->getReturnUrl($purchaseRequest, $purchase);
        }



        $paymentRepo = \XF::repository('XF:Payment');
        $storeId = $purchase->paymentProfile->options['store_id'];
        $basicUrl = $purchase->paymentProfile->options['basic_url'];

        $purchaser = $purchase->purchaser;
        try {

            $client = $this->getHttpClient();

            $chargeParams = [
                'json' => [
                    'metadata' => [
                        "request_key" => $purchaseRequest->request_key
                    ],
                    'order_id' => $purchaseRequest->request_key,
                    'price' => $purchase->cost,
                    'currency' => $purchase->currency,
                    'redirect_url' => $purchase->returnUrl,
                    'notification_url' => $this->notificationUrl(),
                    'store_id' => $storeId,
                    'admin_url' => $basicUrl,
                    "buyer_email" => $purchaser->email ?: "",
                    "expiration" => 0,
                    "promocode" => "",
                    "shipping_address" => "",
                    "notes" => "",
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            ];

            $charge = \GuzzleHttp\json_decode($client->post($this->getApiEndpoint() . '/invoices', $chargeParams
                    )->getBody()->getContents(), true);

            $chargeData = $charge;
            $invoiceId = $chargeData['id'];
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
                'Bitcart Invoice created',
                [$charge],
                $purchase->purchaser->user_id
        );

        return $controller->redirect($this->paymentRedirectUrl($basicUrl, $invoiceId));
    }

    public function notificationUrl() {

        return \xf::options()->boardUrl . "/payment_callback.php?_xfProvider=bit_cart";
    }

    public function paymentRedirectUrl($basicRoute, $invoiceId) {


        return $basicRoute . "/i/" . $invoiceId;
    }

    public function validatePurchaser(CallbackState $state) {
        if ($this->isGuestPurchaseUserUpgrade($state->getPurchaseRequest())) {
            $state->isGuestPurchaseUserUpgrade = true;

            return true;
        }

        return parent::validatePurchaser($state);
    }

    public function completeTransaction(CallbackState $state) {
        if ($state->isGuestPurchaseUserUpgrade) {
            $this->logAsGuestPaidUserUpgrade($state);
        } else {
            parent::completeTransaction($state);
        }
    }

    /**
     * @param \XF\Http\Request $request
     *
     * @return CallbackState
     */
    public function setupCallback(\XF\Http\Request $request) {

        $state = new CallbackState();
        $inputRaw = $request->getInputRaw();
        $state->inputRaw = $inputRaw;

        $input = @json_decode($inputRaw, true);
        $filtered = \XF::app()->inputFilterer()->filterArray($input ?: [], [
            'id' => 'str',
            'status' => 'str',
        ]);

        $state->eventType = isset($filtered['status']) ? $filtered['status'] : "";
        $state->transactionId = isset($filtered['id']) ? $filtered['id'] : "";

        $state->event = $filtered;

        if ($state->transactionId) {

            list($reqeustkey, $invoiceData) = $this->invoiceStatus($state->transactionId);

            $state->requestKey = $reqeustkey;

            if ($invoiceData) {

                $state->event = $invoiceData;
            }
        }

        return $state;
    }

    public function validateCallback(CallbackState $state) {


        if (!$state->eventType) {

            $state->logType = 'error';
            $state->logMessage = 'BitCard:Invalid Valid Event Type';

            return false;
        }

        if (!$state->transactionId) {

            $state->logType = 'error';
            $state->logMessage = 'BitCart: Invalid purchase request.Transaction Id Found';
            return false;
        }


        if (!$state->getPurchaseRequest()) {

            $state->logType = 'error';
            $state->logMessage = 'BitCart: purchase request Not Found.';
            return false;
        }

        if (!$state->getPaymentProfile()->options['store_id']) {

            $state->logType = 'error';
            $state->logMessage = 'BitCart: Invalid purchase request.Store Id Not Set in Payment Profile';
            return false;
        }



        $paymentStatus = ["complete", "completed"];

        if (!in_array($state->eventType, $paymentStatus)) {

            $state->logType = 'info';
            $state->logMessage = 'BitCart: Event "' . htmlspecialchars($state->eventType) . '" processed.';
            $state->httpCode = 200;
            return false;
        }

        return true;
    }

    public function getPaymentResult(CallbackState $state) {
        switch ($state->eventType) {
            case 'complete':
            case 'completed':
                $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
                break;
            case 'invalid':
                $state->paymentResult = CallbackState::PAYMENT_REINSTATED;
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

    protected function getHttpClient() {
        $client = \XF::app()->http()->client();
        return $client;
    }

    public function invoiceStatus($invoiceId) {


        $client = $this->getHttpClient();

        try {

            $invoiceData = \GuzzleHttp\json_decode($client->get($this->getApiEndpoint() . '/invoices/' . $invoiceId)->getBody()->getContents(), true);

            $requestKey = $invoiceData['order_id'];
        } catch (\Exception $e) {

            return [null, null];
        }

        return[$requestKey, $invoiceData];
    }
}
