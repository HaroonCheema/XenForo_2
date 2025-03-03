<?php

namespace FS\BitCart\AddonFlare\PaidRegistrations\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\Mvc\Entity\AbstractCollection;

class AccountType extends \AddonFlare\PaidRegistrations\Repository\AccountType {

    public function getPaymentProfileTitlePairs($onlySupported = false) {


        $app = \xf::app();
        $bitcartPaymentProfileId = $app->options()->bit_cart_profile_id;

        $bitcartPaymentProfile = $this->finder('XF:PaymentProfile')->where('payment_profile_id', $bitcartPaymentProfileId)->fetchOne();
        $accountTypeId = $app->request()->filter('accountType', 'uint');

        if (!$accountTypeId) {

            return parent::getPaymentProfileTitlePairs($onlySupported);
        }

        $accountType = $this->getAccountType($accountTypeId);

        if (!$accountType || !$accountType->canPurchase()) {
            return parent::getPaymentProfileTitlePairs($onlySupported);
        }


        if ($bitcartPaymentProfile && in_array($bitcartPaymentProfileId, $accountType->UserUpgrade->payment_profile_ids)) {


            $paymentRepo = $this->repository('XF:Payment');

            $profiles = $paymentRepo->findPaymentProfilesForList();

            if ($onlySupported) {
                $accountTypeClass = \XF::extendClass('AddonFlare\PaidRegistrations\Entity\AccountType');
                $paymentProfileIds = $accountTypeClass::getSupportedPaymentProviderIds();

                array_push($paymentProfileIds, "bit_cart");

                $profiles->where(['Provider.provider_id', '=', $paymentProfileIds]);
            }


            return $profiles->pluckFrom(function ($e) {

                                return ($e->display_title ?: $e->title);
                            })
                            ->fetch();
        }

        return parent::getPaymentProfileTitlePairs($onlySupported);
    }

    protected function getAccountType($accountTypeId) {
        $accountType = $this->getAccountTypeRepo()->findActiveAccountTypesForList()
                ->where('account_type_id', '=', $accountTypeId)
                ->fetchOne();

        return $accountType;
    }

    protected function getAccountTypeRepo() {
        return $this->repository('AddonFlare\PaidRegistrations:AccountType');
    }
}
