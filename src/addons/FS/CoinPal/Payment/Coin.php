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


        $data = [
            "requestId" => $requestId,
            "merchantNo" => $merchantId,
            "orderNo" => $orderNo,
            "orderAmount" => $orderAmount,
            "orderCurrency" => $orderCurrency,
        ];

        // $redirectURL = "http://localhost/xenforo/index.php?account/upgrade-purchase";

        $chargeData = array();

        try {

            $signature = $this->makeSign($data, $secretKey);

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
    }

    /**
     * @param \XF\Http\Request $request
     *
     * @return CallbackState
     */
    public function setupCallback(\XF\Http\Request $request)
    {
        $state = new CallbackState();

        $postParams = $_POST;

        $state->version = $postParams['version'] ?? "";
        $state->merchantNo = $postParams['merchantNo'] ?? "";
        $state->reference = $postParams['reference'] ?? "";
        $state->orderAmount = $postParams['orderAmount'] ?? "";
        $state->selectedWallet = $postParams['selectedWallet'] ?? "";
        $state->dueAmount = $postParams['dueAmount'] ?? "";
        $state->paidAmount = $postParams['paidAmount'] ?? "";
        $state->paidAddress = $postParams['paidAddress'] ?? "";
        $state->status = $postParams['status'] ?? "";
        $state->requestId = $postParams['requestId'] ?? "";
        $state->orderNo = $postParams['orderNo'] ?? "";
        $state->orderCurrency = $postParams['orderCurrency'] ?? "";
        $state->paidOrderAmount = $postParams['paidOrderAmount'] ?? "";
        $state->dueCurrency = $postParams['dueCurrency'] ?? "";
        $state->paidCurrency = $postParams['paidCurrency'] ?? "";
        $state->paidUsdt = $postParams['paidUsdt'] ?? "";
        $state->confirmedTime = $postParams['confirmedTime'] ?? "";
        $state->remark = $postParams['remark'] ?? "";
        $state->unresolvedLabel = $postParams['unresolvedLabel'] ?? "";
        $state->sign = $postParams['sign'] ?? "";
        $state->requestKey = $postParams['requestId'] ?? "";
        $state->transactionId = $postParams['reference'] ?? "";

        // $this->logIntoFile('----------------setupCallback--------------------------');
        // $this->logIntoFile('notify: ' . json_encode($state));

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

        if (!$state->requestKey) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: Invalid purchase request.Request Key not found.';
            $state->httpCode = 404;

            return false;
        }

        if (!$state->getPurchaseRequest()) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: purchase request Not Found.';
            $state->httpCode = 404;

            return false;
        }

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

        if (!$this->verifySign($state, $state->getPaymentProfile()->options['secret_key'])) {

            $state->logType = 'error';
            $state->logMessage = 'CoinPal: Invalid purchase request.Signature not matched';
            $state->httpCode = 401;

            return false;
        }

        // $paymentStatus = ["paid", "partial_paid", "paid_confirming", "partial_paid_confirming"];

        if ($state->status != "paid") {

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
        $data = (array) $state;

        $state->logDetails = $data;
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

    public function verifySign($dataParams, $secretKey)
    {
        $data = (array) $dataParams;

        if (empty($data['sign'])) {
            return false;
        }

        $sign = $this->makeSign($data, $secretKey);

        if ($sign != $data['sign']) {
            return false;
        }

        return true;
    }

    protected function makeSign($data, $secretKey)
    {
        // // this signature format is only user for get payment information
        // $signString = $apiKey . $data['reference'] . $data['requestId'] . $data['merchantNo'] . $data['timestamp'];

        $signString = $secretKey . $data['requestId'] . $data['merchantNo'] . $data['orderNo'] . $data['orderAmount'] . $data['orderCurrency'];
        return hash('sha256', $signString);
    }

    // public function logIntoFile($data)
    // {
    //     // if (!self::isDebug()) {
    //     //     return true;
    //     // }
    //     $data = is_array($data) ? var_export($data, true) : $data;
    //     file_put_contents('./coinpal.log', $data . PHP_EOL, FILE_APPEND);
    // }
}
