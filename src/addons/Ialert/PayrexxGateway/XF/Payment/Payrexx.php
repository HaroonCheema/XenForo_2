<?php

namespace Ialert\PayrexxGateway\XF\Payment;


use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Payment\AbstractProvider;
use XF\Payment\CallbackState;
use XF\Purchasable\Purchase;

class Payrexx extends AbstractProvider
{
    public function getTitle()
    {
        return 'Payrexx';
    }

    public function getApiEndpoint()
    {
        return '';
    }

    public function verifyConfig(array &$options, &$errors = [])
    {
        if (empty($options['instance'])) {
            $errors[] = \XF::phrase('you_must_provide_instance_name');
            return false;
        }

        if (empty($options['secret_key'])) {
            $errors[] = \XF::phrase('you_must_provide_secret_key');
            return false;
        }

        if ($errors) {
            return false;
        }

        return true;
    }

    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {

        $purchaser = $purchase->purchaser;

        $invoice = new \Payrexx\Models\Request\Invoice();

        $invoice->setReferenceId($purchaseRequest->request_key);
        $invoice->setAmount($purchase->cost * 100);
        $invoice->setCurrency($purchase->currency);
        $invoice->setTitle($purchase->title);
        $invoice->setPurpose(sprintf('Order #%s', $purchaseRequest->purchase_request_id));
        $invoice->setFailedRedirectUrl($purchase->cancelUrl);
        $invoice->setSuccessRedirectUrl($purchase->returnUrl);

        $invoice->addField('email', true, $purchaser->email);
        $invoice->addField('forename', true);
        $invoice->addField('surname', true);
        $invoice->addField('country', true);
        $invoice->addField('street', true);
        $invoice->addField('phone', true);
        $invoice->addField('postcode', true);
        $invoice->addField('place', true);

        return $invoice;
    }

    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
    {

        $paymentProfile = $purchase->paymentProfile;
        $invoice = $this->getPaymentParams($purchaseRequest, $purchase);

        $payrexx = new \Payrexx\Payrexx($paymentProfile->options['instance'], $paymentProfile->options['secret_key']);

        try {
            $response = $payrexx->create($invoice);
            return $controller->redirect($response->getLink(), '');

        } catch (\Payrexx\PayrexxException $e) {
            return $controller->error($e->getMessage());
        }
    }

    /**
     * @param \XF\Http\Request $request
     *
     * @return CallbackState
     */
    public function setupCallback(\XF\Http\Request $request)
    {
        $state = new CallbackState();
        $response = $this->getResponse();

        if (isset($response['transaction']) && isset($response['transaction']['invoice']['referenceId'])) {

            $state->transactionId = $response['transaction']['id'];
            $state->paymentStatus = $response['transaction']['status'];
            $state->requestKey = $response['transaction']['invoice']['referenceId'];
            $state->testMode = 1 === $response['transaction']['invoice']['test'];
            $state->transaction = $response['transaction'];
            $state->ip = $request->getIp();
            $state->_POST = $response;
        }

        return $state;
    }

    protected function getResponse()
    {
        $response = file_get_contents('php://input');
        return json_decode($response, true);
    }

    public function validateTransaction(CallbackState $state)
    {
        if (!$state->requestKey) {
            $state->logType = 'info';
            $state->logMessage = 'No purchase request key. Unrelated payment, no action to take.';
            return false;
        }

        if (!$state->transactionId) {
            $state->logType = 'info';
            $state->logMessage = 'No transaction ID. No action to take.';
            return false;
        }

        $paymentRepo = \XF::repository('XF:Payment');
        $matchingLogsFinder = $paymentRepo->findLogsByTransactionId($state->transactionId);
        if ($matchingLogsFinder->total()) {
            $logs = $matchingLogsFinder->fetch();
            foreach ($logs AS $log) {
                if ($log->log_type == 'cancel' && $state->paymentStatus == 'canceled') {
                    // This is a cancelled transaction we've already seen, but has now been reversed.
                    // Let it go through.
                    return true;
                }
            }

            $state->logType = 'info';
            $state->logMessage = 'Transaction already processed. Skipping.';
            return false;
        }

        return true;
    }

    public function validatePurchaseRequest(CallbackState $state)
    {
        // validated in validateTransaction
        return true;
    }

    public function validatePurchasableHandler(CallbackState $state)
    {
        if ($state->legacy) {
            $purchasable = \XF::em()->find('XF:Purchasable', 'user_upgrade');
            $state->purchasableHandler = $purchasable->handler;
        }
        return parent::validatePurchasableHandler($state);
    }

    public function validatePaymentProfile(CallbackState $state)
    {
        if ($state->legacy) {
            $finder = \XF::finder('XF:PaymentProfile')
                ->where('provider_id', 'payrexx');
            foreach ($finder->fetch() AS $profile) {
                $state->paymentProfile = $profile;
                break;
            }
        }
        return parent::validatePaymentProfile($state);
    }

    public function validatePurchaser(CallbackState $state)
    {
        return true;
    }

    public function validatePurchasableData(CallbackState $state)
    {
        return true;
    }

    public function validateCost(CallbackState $state)
    {
        return true;
    }

    public function getPaymentResult(CallbackState $state)
    {
        if ($state->paymentStatus === 'confirmed') {
            $state->paymentResult = CallbackState::PAYMENT_RECEIVED;
        }
    }

    public function prepareLogData(CallbackState $state)
    {
        $state->logDetails = $state->_POST;
    }
}

require_once __DIR__ . '/../../vendor/autoload.php';