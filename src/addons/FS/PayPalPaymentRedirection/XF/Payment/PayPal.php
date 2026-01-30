<?php

namespace FS\PayPalPaymentRedirection\XF\Payment;


use XF\Http\Request;
use XF\Entity\PaymentProfile;
use XF\Entity\PurchaseRequest;
use XF\Mvc\Controller;
use XF\Purchasable\Purchase;
use XF\Util\Arr;

class PayPal extends XFCP_PayPal
{
    public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase)
    {
        $payPal_payment_redirect = \xf::options()->fs_payment_site_base_url;

        if (!$payPal_payment_redirect) {

            return parent::initiatePayment($controller, $purchaseRequest, $purchase);
        }

        $params = $this->getPaymentParams($purchaseRequest, $purchase);

        $params['return'] = $payPal_payment_redirect . "/payPal-return.php?return=upgradePurchase";
        $params['cancel_return'] = $payPal_payment_redirect . "/payPal-return.php?return=upgrades";
        $params['notify_url'] = $payPal_payment_redirect . "/payment_callback.php?_xfProvider=paypal";

        $endpointUrl = $this->getApiEndpoint();

        $data = [
            'params' => $params,
            'endpointUrl' => $endpointUrl
        ];

        $plaintext = json_encode($data, JSON_UNESCAPED_SLASHES);

        $encrypt = $this->encryptCompact($plaintext, "fS9eL3pR1sd34qT6wXz8");

        $redirectUrl = $payPal_payment_redirect . "/payPal-checkout.php?code=" . $encrypt;

        return $controller->redirect($redirectUrl, '');
    }

    public function encryptCompact(string $plaintext, string $key): string
    {
        $cipher = 'AES-128-CBC';

        $key = substr(hash('sha256', $key, true), 0, 16);

        $iv = random_bytes(openssl_cipher_iv_length($cipher));

        $encrypted = openssl_encrypt(
            $plaintext,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        $final = $iv . $encrypted;

        return rtrim(strtr(base64_encode($final), '+/', '-_'), '=');
    }
}
