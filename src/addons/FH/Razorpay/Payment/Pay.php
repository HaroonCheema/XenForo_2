<?php

namespace FH\Razorpay\Payment;

use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Pay extends AbstractProvider {

    public function getTitle() {

        return \xf::phrase('razor_pay');
    }

    public function verifyConfig(array &$options, &$errors = []) {

        if (empty($options['api_key'])) {
            $errors[] = \XF::phrase('razor_payment_you_must_provide_an_api_key');
            return false;
        }

        if (empty($options['api_secret'])) {
            $errors[] = \XF::phrase('razor_payment_you_must_provide_an_secret_key');
            return false;
        }

        return true;
    }

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase) {

        $paymentProfile = $purchase->paymentProfile;
        $apiKey = $paymentProfile->options['api_key'];

        return [
            'purchaseRequest' => $purchaseRequest,
            'paymentProfile' => $paymentProfile,
            'purchaser' => $purchase->purchaser,
            'purchase' => $purchase,
            'purchasableTypeId' => $purchase->purchasableTypeId,
            'purchasableId' => $purchase->purchasableId,
            'apiKey' => $apiKey,
            'cost' => $purchase->cost
        ];
    }

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase) {



        $purchaser = $purchase->purchaser;
        $paymentRepo = \XF::repository('XF:Payment');

        $apiKey = $purchase->paymentProfile->options['api_key'];
        $apiSecret = $purchase->paymentProfile->options['api_secret'];

        $razorPaySer = \xf::app()->service('FH\Razorpay:Pay');

        $razorPayApi = $razorPaySer->razorPay($apiKey, $apiSecret);

        $orderData = [
            'customer' => [
                'name' => $purchaser->name,
                'email' => $purchaser->email ?: "",
            ],
            'amount' => intval($purchase->cost) * 100,
            'currency' => $purchase->currency,
            'notes' => [
                'request_key' => $purchaseRequest->request_key,
            ]
        ];

        $razorpayOrder = $razorPayApi->paymentLink->create($orderData);

        if (!isset($razorpayOrder['id'])) {

            throw $controller->exception($controller->error(\XF::phrase('something_went_wrong_please_try_again')));
        }

        $orderId = $razorpayOrder->id;
        $short_url = $razorpayOrder->short_url;

        $razorPayOptions = [
            'key' => $apiKey,
            "name" => $purchase->title,
            "description" => $purchase->description ?: '',
            "image" => \XF::app()->options()->boardUrl . "/styles/default/xenforo/xenforo-favicon.png",
            "order_id" => $orderId,
            "callback_url" => $purchase->returnUrl,
            "notes" => [
                'request_key' => $purchaseRequest->request_key,
            ],
            'short_url' => $short_url,
        ];

        $paymentRepo->logCallback(
                $purchaseRequest->request_key,
                $this->providerId,
                $orderId,
                'info',
                'Charge created',
                $razorPayOptions,
                $purchase->purchaser->user_id
        );

        return $controller->redirect($short_url);
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
            'event' => 'str',
            'payload' => 'array',
            'razorpay_signature' => 'str',
        ]);

        $state->signature = isset($filtered['razorpay_signature']) ? $filtered['razorpay_signature'] : '';

        $state->eventType = $filtered['event'];

        $state->requestKey = isset($filtered['payload']['payment']['entity']['notes']['request_key']) ? $filtered['payload']['payment']['entity']['notes']['request_key'] : "";

        $state->razorPaymentId = isset($filtered['payload']['payment']['entity']['id']) ? $filtered['payload']['payment']['entity']['id'] : "";

        $state->orderId = isset($filtered['payload']['payment']['entity']['order_id']) ? $filtered['payload']['payment']['entity']['order_id'] : "";

        $state->transactionId = isset($filtered['payload']['payment']['entity']['id']) ? $filtered['payload']['payment']['entity']['id'] : "";

        $state->event = $filtered;

        return $state;
    }

    public function validateCallback(CallbackState $state) {

        $SkippableEvents = [
            'payment.downtime.resolved',
            'payment.downtime.started',
            'payment.captured',
            'payment.authorized',
            'payment.failed',
            'refund.failed',
            'payment.dispute.lost',
            'payment.dispute.closed',
            'payment.dispute.under_review',
            'payment.dispute.action_required',
        ];

        if ($state->eventType && in_array($state->eventType, $SkippableEvents)) {
            $state->logType = 'info';
            $state->logMessage = 'Razor: Event "' . htmlspecialchars($state->eventType) . '" processed. No action required.';
            $state->httpCode = 200;
            return false;
        }

        if (!$state->orderId) {

            $state->logType = 'error';
            $state->logMessage = 'Razor Payment does not contain a Order Id.';
            $state->httpCode = 500;

            return false;
        }

        if (!$state->getPurchaseRequest()) {
            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.';
            return false;
        }

        if (!$state->eventType) {

            $state->logType = 'error';
            $state->logMessage = 'Razor Payment does not contain a  Event Type.';
            $state->httpCode = 500;

            return false;
        }

        if ($state->signature) {

            $apiKey = $state->getPaymentProfile()->options['api_key'];
            $apiSecret = $state->getPaymentProfile()->options['api_secret'];

            $razorPaySer = \xf::app()->service('FH\Razorpay:Pay');

            $razorPayApi = $razorPaySer->razorPay($apiKey, $apiSecret);

            $razorpayVarify = $razorPayApi->utility->verifyPaymentSignature(array('razorpay_order_id' => $state->orderId, 'razorpay_payment_id' => $state->razorPaymentId, 'razorpay_signature' => $state->signature));

            if ($razorpayVarify) {

                $state->logType = 'error';
                $state->logMessage = 'Razor Payment does not contain a verify Signature.';
                $state->httpCode = 500;

                return false;
            }
        }



        return true;
    }

    public function getPaymentResult(CallbackState $state) {

        switch ($state->eventType) {
            case 'invoice.paid':
            case 'order.paid':
                $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
                break;
            case 'refund.created':
            case 'refund.processed':
                $state->paymentResult = CallbackState::PAYMENT_REVERSED;
                break;
            case 'payment.dispute.created':
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
}
