<?php

namespace FS\BitCart\AddonFlare\PaidRegistrations\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use AddonFlare\PaidRegistrations\IDs;

class AccountType extends XFCP_AccountType {

    public static function getSupportedPaymentProviderIds() {

        $app = \xf::app();
        $isRegister = $app->request()->filter('registration', 'bool');

        if (!$isRegister) {

            return parent::getSupportedPaymentProviderIds();
        }


        $minVersionSupport = [
            'paypal' => '*',
            'stripe' => 2020070,
            'bit_cart' => '*',
        ];

        $providers = [];

        foreach ($minVersionSupport as $providerId => $minVersion) {
            if ($minVersion === '*' || (is_int($minVersion) && \XF::$versionId >= $minVersion)) {
                $providers[] = $providerId;
            }
        }

        return $providers;
    }
}
