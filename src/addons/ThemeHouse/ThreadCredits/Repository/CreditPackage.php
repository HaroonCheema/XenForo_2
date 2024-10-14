<?php

namespace ThemeHouse\ThreadCredits\Repository;

use ThemeHouse\ThreadCredits\Finder\UserCreditPackage;
use XF\Entity\User;
use XF\Mvc\Entity\Repository;

class CreditPackage extends Repository
{
    public function findCreditPackagesForList(): \ThemeHouse\ThreadCredits\Finder\CreditPackage
    {
        /** @var \ThemeHouse\ThreadCredits\Finder\CreditPackage $finder */
        $finder = $this->finder('ThemeHouse\ThreadCredits:CreditPackage');
        $finder->setDefaultOrder('display_order');

        return $finder;
    }

    public function findUserCreditPackagesForUser(User $user): UserCreditPackage
    {
        /** @var UserCreditPackage $finder */
        $finder = $this->finder('ThemeHouse\ThreadCredits:UserCreditPackage');
        $finder->where('user_id', $user->user_id);
        return $finder;
    }

    public function findUserCreditPackagesForCreditPackage(\ThemeHouse\ThreadCredits\Entity\CreditPackage $creditPackage): UserCreditPackage
    {
        /** @var UserCreditPackage $finder */
        $finder = $this->finder('ThemeHouse\ThreadCredits:UserCreditPackage');
        $finder->where('credit_package_id', $creditPackage->credit_package_id);
        $finder->setDefaultOrder('user_credit_package_id', 'desc');
        return $finder;
    }


    public function getCostPhraseForCreditPackage(
        \ThemeHouse\ThreadCredits\Entity\CreditPackage $creditPackage,
        $costAmount = null,
        $costCurrency = null
    ) {
        $costAmount = $costAmount ?? $creditPackage->cost_amount;
        $costCurrency = $costCurrency ?? $creditPackage->cost_currency;

        return $this->app()->data('XF:Currency')->languageFormat($costAmount, $costCurrency);
    }

    public function getCreditPackageOptionsData($includeEmpty = true, $type = null, $checkPerms = false)
    {
        $choices = [];
        if ($includeEmpty) {
            $choices = [
                0 => ['_type' => 'option', 'value' => 0, 'label' => \XF::phrase('(none)')]
            ];
        }

        $creditPackageList = $this->findCreditPackagesForList()->fetch();

        foreach ($creditPackageList as $entry) {
            /** @var \ThemeHouse\ThreadCredits\Entity\CreditPackage $entry */
            $choices[$entry->credit_package_id] = [
                'value' => $entry->credit_package_id,
                'label' => $entry->title,
                'disabled' => false,
            ];

            if ($type !== null) {
                $choices[$entry->credit_package_id]['_type'] = $type;
            }
        }

        return $choices;
    }
}