<?php

namespace AddonFlare\PaidRegistrations\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

use AddonFlare\PaidRegistrations\IDs;

class AccountType extends Entity
{
    protected static $hasExtendedGet = null;

    public function canPurchase($allowFreeType = false)
    {
        if (!$this->active)
        {
            return false;
        }

        $visitor = \XF::visitor();

        if ($this->user_upgrade_id == -1)
        {
            return (!$visitor->user_id && $allowFreeType);
        }

        $purchaseUserGroupIds = $this->purchase_user_group_ids;

        if (!in_array(-1, $purchaseUserGroupIds) && !$visitor->isMemberOf($purchaseUserGroupIds))
        {
            return false;
        }

        if ((!$userUpgrade = $this->UserUpgrade) || !$userUpgrade->can_purchase)
        {
            return false;
        }

        if ($visitor->user_id)
        {

        }
        else
        {
            // make sure custom amount is disabled or allowed for guests
            if ($this->allow_custom_amount && $this->disable_custom_amount_guest)
            {
                return false;
            }
        }

        return true;
    }

    public function canGift()
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id)
        {
            return false;
        }

        return $this->is_giftable;
    }

    public function getTitle()
    {
        if ($this->custom_title)
        {
            return $this->custom_title;
        }
        else if ($this->UserUpgrade)
        {
            return $this->UserUpgrade->title;
        }
        else
        {
            return $this->app()->options()->af_paidregistrations_freeTitle;
        }
    }

    public function getCost()
    {
        $userUpgrade = $this->UserUpgrade;

        if (!$userUpgrade) return \XF::phrase('af_paidregistrations_free');

        $cost = $this->app()->data('XF:Currency')->languageFormat($userUpgrade->cost_amount, $userUpgrade->cost_currency);

        return $cost;
    }

    public function getLengthPhrase()
    {
        $userUpgrade = $this->UserUpgrade;

        if (!$userUpgrade) return '';

        if ($userUpgrade->length_unit)
        {
            $phrase = (string)$userUpgrade->cost_phrase;
            $phrase = explode(' ', $phrase, 2);
            $phrase = trim($phrase[1]);
        }
        else
        {
            $phrase = \XF::phrase('af_paidregistrations_permanent');
        }

        return $phrase;
    }

    public function getFeaturesList()
    {
        $list = array_filter(preg_split('/\r?\n/', $this->features));

        return $list;
    }

    public function getForDeletion()
    {
        return ($this->version || $this->user_upgrade_id != -1);
    }

    public function getVersion()
    {
        static $v = null;

        if (!isset($v))
        {
            $v = $this->app()->templater();
        }

        $prefix = IDs::$prefix;
        return IDs::$prefix($v);
    }

    // checked for guest purchases
    public static function getSupportedPaymentProviderIds()
    {
        $minVersionSupport = [
            'paypal' => '*',
        ];

        $providers = [];

        foreach ($minVersionSupport as $providerId => $minVersion)
        {
            if ($minVersion === '*' || (is_int($minVersion) && \XF::$versionId >= $minVersion))
            {
                $providers[] = $providerId;
            }
        }

        return $providers;
    }

    public function get($key)
    {
        if (!self::$hasExtendedGet)
        {
            self::$hasExtendedGet = \XF::extendClass('\XF\Template\Templater');
        }

        $hasExtendedGet = self::$hasExtendedGet;
        return parent::get($hasExtendedGet::getAfPaidRegistrations($key));
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_af_paidregistrations_accounttype';
        $structure->shortName = 'AddonFlare\PaidRegistrations:AccountType';
        $structure->primaryKey = 'account_type_id';
        $structure->columns = [
            'account_type_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'custom_title'    => ['type' => self::STR, 'default' => '', 'maxLength' => 50],
            'row'             => ['type' => self::UINT, 'default' => 1],
            'display_order'   => ['type' => self::UINT, 'default' => 5],
            'user_upgrade_id' => ['type' => self::INT, 'default' => -1],
            'color'           => ['type' => self::STR, 'maxLength' => 50, 'default' => 'rgb(83,207,233)'],
            'color_dark'      => ['type' => self::STR, 'maxLength' => 50, 'nullable' => true, 'default' => '#3cb8d2'],
            'features'        => ['type' => self::STR, 'default' => ''],
            'active'          => ['type' => self::BOOL, 'default' => true],
            'is_featured'     => ['type' => self::BOOL, 'default' => false],
            'alias_user_upgrades' => ['type' => self::JSON_ARRAY, 'default' => []],
            'allow_custom_amount' => ['type' => self::BOOL, 'default' => false],
            'custom_amount_min'   => ['type' => self::FLOAT, 'default' => 0],
            'disable_custom_amount_guest' => ['type' => self::BOOL, 'default' => false],
            'is_giftable'     => ['type' => self::BOOL, 'default' => true],
            'purchase_user_group_ids' => ['type' => self::JSON_ARRAY, 'default' => [-1]],
        ];
        $structure->getters = [
            'title' => true,
            'cost' =>  true,
            'length_phrase' => true,
            'features_list' => true,
            'version'       => true,
            'for_deletion'  => true,
        ];
        $structure->relations = [
            'UserUpgrade' => [
                'entity' => 'XF:UserUpgrade',
                'type' => self::TO_ONE,
                'conditions' => 'user_upgrade_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}