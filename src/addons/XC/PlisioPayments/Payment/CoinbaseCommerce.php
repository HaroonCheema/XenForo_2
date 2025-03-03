<?php

namespace XC\PlisioPayments\Payment;

use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

/*
 * Provider: plisio Commerce
 * Also referenced as: CbCommerce, plisio, plisio, cc
 */

class CoinbaseCommerce extends AbstractProvider {

    protected $cbVersion = '2018-03-22';

    public function getTitle() {
        return 'Plisio'; 
    }

    public function getApiEndpoint() {
        return 'https://plisio.net/api';
    }

    public function verifyConfig(array &$options, &$errors = []) {
        if (empty($options['api_key'])) {
            $errors[] = \XF::phrase('xc_you_must_provide_an_api_key');
            return false;
        }

        if (empty($options['webhook_secret'])) {
            $errors[] = \XF::phrase('xc_you_must_provide_a_webhook_secret');
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
        $paymentRepo = \XF::repository('XF:Payment');
        $apiKey = $purchase->paymentProfile->options['api_key'];
        $callbackUrl = $purchase->paymentProfile->options['webhook_secret'];

        try {
            $client = $this->getHttpClient();

            $chargeParams = [
                'order_name' => substr($purchase->title, 0, 99),
                'description' => substr($purchase->description, 0, 199),
                'order_number' => $purchaseRequest->purchase_request_id,
                'source_amount' => $purchase->cost,
                'source_currency' => $purchase->currency,
           		'success_callback_url' => $purchase->returnUrl,
                'fail_callback_url' => $purchase->cancelUrl,
                'callback_url' => $callbackUrl,
                'api_key' => $apiKey,
            ];

//            var_dump($this->getApiEndpoint() . '/v1/invoices/new',$chargeParams,$purchase);exit;



            $charge = \GuzzleHttp\json_decode($client->get($this->getApiEndpoint() . '/v1/invoices/new', ["query" => $chargeParams]
                    )->getBody()->getContents(), true);

            $chargeData = $charge['data'];
            $transactionId = $chargeData['txn_id'];
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
                $transactionId,
                'info',
                'Invoice created',
                [$charge],
                $purchase->purchaser->user_id
        );

        return $controller->redirect($chargeData['invoice_url']);
    }

    /**
     * @param \XF\Http\Request $request
     *
     * @return CallbackState
     */
    public function setupCallback(\XF\Http\Request $request) {

        $state = new CallbackState();

        $state->txn_id = $request->filter('txn_id', 'str');
        $state->ipn_type = $request->filter('invoice', 'str');
        $state->merchant = $request->filter('merchant', 'str');
        $state->merchant_id = $request->filter('merchant_id', 'str');
        $state->amount = $request->filter('amount', 'str');
        $state->currency = $request->filter('currency', 'str');
        $state->order_number = $request->filter('order_number', 'str');
        $state->order_name = $request->filter('order_name', 'str');
        $state->confirmations = $request->filter('confirmations', 'str');
        $state->status = $request->filter('status', 'str');
        $state->source_currency = $request->filter('source_currency', 'str');
        $state->verify_hash = $request->filter('verify_hash', 'str');
        $state->expire_utc = $request->filter('expire_utc', 'str');
        $state->invoice_sum = $request->filter('invoice_sum', 'str');
        $state->tx_urls = $request->filter('tx_urls', 'str');
        $state->transactionId = $request->filter('txn_id', 'str');

        $state->ip = $request->getIp();
        $state->_POST = $_POST;

        return $state;
    }

    public function validateCallback(CallbackState $state) {

        if (!$state->txn_id) {

            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.txn_id Id Not Return back Found';
            return false;

            return false;
        }

        if (!$state->order_number) {

            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.Order Id Found';
            return false;
        }
        if ($state->order_number) {

            $purchaseRequest = \xf::app()->finder('XF:PurchaseRequest')->where('purchase_request_id', $state->order_number)->fetchOne();
            if (!$purchaseRequest) {

                $state->logType = 'error';
                $state->logMessage = 'Invalid purchase request.Not Found';
                return false;
            }

            $state->requestKey = $purchaseRequest->request_key;
        }
        if (!$state->status) {
            $state->logType = 'error';
            $state->logMessage = 'Webhook received from plisio does not contain a signature.';
            $state->httpCode = 500;

            return false;
        }


        if (!$state->getPurchaseRequest()) {

            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.';
            return false;
        }

        if (!$state->getPaymentProfile()->options['api_key']) {

            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.Api key Not Set in Payment Profile';
            return false;
        }



        if (!$this->verifyCallbackSignature($state, $state->getPaymentProfile()->options['api_key'])) {

            $state->logType = 'error';
            $state->logMessage = 'Webhook received from plisio could not be verified as being valid. Secret mismatch.';
            $state->httpCode = 500;

            return false;
        }



        if ($state->txn_id) {

            $skippableEvents = ['new', 'pending', 'pending internal', 'expired', 'mismatch', 'error', 'cancelled'];

            list($TransStatus, $responseStatus, $errorMasg) = $this->transcationStatus($state->txn_id, $state->getPaymentProfile()->options['api_key']);

            if ($responseStatus == "error") {

                $state->logType = 'info';
                $state->logMessage = $errorMasg;
                $state->httpCode = 500;
                return false;
            }
            if (in_array($TransStatus, $skippableEvents)) {

                $state->logType = 'info';
                $state->logMessage = 'Event "' . htmlspecialchars($state->status) . '" processed.';
                $state->httpCode = 200;
                return false;
            }

            if ($TransStatus == "completed") {

                $state->status = $TransStatus;

                return true;
            }
        }


        return true;
    }

    public function getPaymentResult(CallbackState $state) {
        switch ($state->status) {
            case 'pending':
            case 'completed':
                $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
                break;
        }
    }

    public function prepareLogData(CallbackState $state) {
        $state->logDetails = $state->_POST;
    }

    public function supportsRecurring(\XF\Entity\PaymentProfile $paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING) {
        return false;
    }

    protected function verifyCallbackSignature($data, $secretKey) {
        if (!isset($_POST['verify_hash'])) {
            return false;
        }
        $post = $_POST;
        $verifyHash = $post['verify_hash'];
        unset($post['verify_hash']);
        ksort($post);
        if (isset($post['expire_utc'])) {
            $post['expire_utc'] = (string) $post['expire_utc'];
        }
        if (isset($post['tx_urls'])) {
            $post['tx_urls'] = html_entity_decode($post['tx_urls']);
        }
        $postString = serialize($post);
        $checkKey = hash_hmac('sha1', $postString, $secretKey);
        if ($checkKey != $verifyHash) {
            return false;
        }
        return true;
    }

    protected function getHttpClient() {
        $client = \XF::app()->http()->client();
        return $client;
    }

    public function transcationStatus($txn_id, $apiKey) {


        try {
            $client = $this->getHttpClient();

            $message = "";
            
            $chargeParams = [
                'api_key' => $apiKey,
            ];

            $charge = \GuzzleHttp\json_decode($client->get($this->getApiEndpoint() . '/v1/operations/' . $txn_id, ["query" => $chargeParams]
                    )->getBody()->getContents(), true);

            $statusTrans = $charge['data']['status'];
            $responseStatus = $charge['status'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents(), true);
            $message = isset($error['error']['message']) ? $error['error']['message'] : '';
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \XF::logException($e, false, "plisio error: ");
        }

        return[$statusTrans, $responseStatus, $message];
    }
}
