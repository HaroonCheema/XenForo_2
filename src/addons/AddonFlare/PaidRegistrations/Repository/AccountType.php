<?php

namespace AddonFlare\PaidRegistrations\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

use XF\Mvc\Entity\AbstractCollection;

class AccountType extends Repository
{
    public function findAccountTypesForList()
    {
        $finder = $this->finder('AddonFlare\PaidRegistrations:AccountType')
            ->with('UserUpgrade')
            ->order('active', 'DESC')
            ->order('display_order', 'ASC');

        return $finder;
    }

    public function findActiveAccountTypesForList()
    {
        $finder = $this->findAccountTypesForList()
            ->where('active', '=', 1)
            ->whereOr(['UserUpgrade.can_purchase', '=', 1], ['user_upgrade_id', '=', -1]);

        return $finder;
    }

    public function fetchAccountTypeForUserUpgrade($userUpgradeId)
    {
        if ($userUpgradeId instanceof \XF\Entity\UserUpgrade)
        {
            $userUpgradeId = $userUpgradeId->user_upgrade_id;
        }

        $finder = $this->finder('AddonFlare\PaidRegistrations:AccountType');
        $finder->whereOr(
            ['user_upgrade_id', '=', $userUpgradeId],
            ['alias_user_upgrades', 'LIKE', $finder->escapeLike('"user_upgrade_id":' . $userUpgradeId, '%?%')]
        );

        return $finder->fetchOne();
    }

    public function filterPurchasedAliases(AbstractCollection $accountTypes, $purchased)
    {
        return $accountTypes->filter(function($accountType) use ($purchased)
        {
            foreach ($accountType->alias_user_upgrades as $userUpgradeId => $arrValue)
            {
                if (isset($purchased['user_upgrade_id'][$userUpgradeId]))
                {
                    return false;
                }
            }

            return true;
        });
    }

    public function filterPurchasable(AbstractCollection $accountTypes, $allowFreeType = false)
    {
        return $accountTypes->filter(function($accountType) use ($allowFreeType)
        {
            return $accountType->canPurchase($allowFreeType);
        });
    }

    public function filterGiftable(AbstractCollection $accountTypes)
    {
        return $accountTypes->filter(function($accountType)
        {
            return $accountType->canGift();
        });
    }

    // our own method so functionality stays consistent accross all versions. don't have to rely on method in XF:Payment
    public function getPaymentProfileTitlePairs($onlySupported = false)
    {
        $paymentRepo = $this->repository('XF:Payment');

        $profiles = $paymentRepo->findPaymentProfilesForList();

        if ($onlySupported)
        {
            $accountTypeClass = \XF::extendClass('AddonFlare\PaidRegistrations\Entity\AccountType');
            $profiles->where(['Provider.provider_id', '=', $accountTypeClass::getSupportedPaymentProviderIds()]);
        }

        return $profiles->pluckFrom(function ($e)
        {
            return ($e->display_title ?: $e->title);
        })
        ->fetch();
    }

    public function rgbToHex($rgb)
    {
        $re = '/\((\d+)[ ,]*(\d+)[ ,]*(\d+)/';
        if (preg_match($re, $rgb, $match))
        {
            $hex = sprintf("#%02x%02x%02x", $match[1], $match[2], $match[3]);
        }
        else
        {
            $hex = '';
        }

        return $hex;
    }

    public function adjustBrightness($hex, $steps) // credit: https://stackoverflow.com/a/11951022
    {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }
}