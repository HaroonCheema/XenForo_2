<?php

namespace FS\BitCart\XF\Pub\Controller;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\ConnectedAccount\ProviderData\AbstractProviderData;
use XF\Mvc\ParameterBag;

class Register extends XFCP_Register {

    public function actionIndex() {


        if (!$this->options()->af_paidregistrations_guest) {
            return parent::actionIndex();
        }

        if (($purchaseRequestKey = $this->filter('custom', 'str')) || ($purchaseRequestKey = $this->filter('cm', 'str')) || ($purchaseRequestKey = $this->filter('prk', 'str'))) {
            $purchaseRequest = $this->em()->findOne('XF:PurchaseRequest', [
                'request_key' => $purchaseRequestKey,
                'user_id' => 0,
                'purchasable_type_id' => 'user_upgrade',
            ]);

            if (!$purchaseRequest) {

                return parent::actionIndex();
            }

            $providerLog = $this->finder('XF:PaymentProviderLog')
                    ->where('purchase_request_key', $purchaseRequestKey)
                    ->fetchOne();

            if ($providerLog->provider_id == "bit_cart") {


                if (!$providerLog->transaction_id) {

                    return $this->view('XF\Register:Index', 'register_without_payment', []);
                }

                $invoiceId = $providerLog->transaction_id;

                $invoiceData = $this->invoiceStatus($invoiceId);

                if (!$invoiceData) {

                    return $this->view('XF\Register:Index', 'register_without_payment', []);
                }

                if (!isset($invoiceData['status'])) {

                    return $this->view('XF\Register:Index', 'register_without_payment', []);
                }

                if (isset($invoiceData['status']) && $invoiceData['status'] != "complete") {

                    return $this->view('XF\Register:Index', 'register_without_payment', []);
                }
            }
        }


        return parent::actionIndex();
    }

    public function getApiEndpoint() {

        return 'https://api.bitcart.ai';
    }

    protected function getHttpClient() {

        $client = \XF::app()->http()->client();
        return $client;
    }

    public function invoiceStatus($invoiceId) {


        $client = $this->getHttpClient();

        try {

            $invoiceData = \GuzzleHttp\json_decode($client->get($this->getApiEndpoint() . '/invoices/' . $invoiceId)->getBody()->getContents(), true);
        } catch (\Exception $e) {

            return null;
        }

        return $invoiceData;
    }
}
