<?php

namespace ThemeHouse\Monetize\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Coupon extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_th_monetize_coupon';
        $structure->shortName = 'ThemeHouse\Monetize:Coupon';
        $structure->primaryKey = 'coupon_id';

        $structure->columns = [
            'coupon_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'title' => [
                'type' => self::STR,
                'maxLength' => 150,
                'required' => 'please_enter_valid_title',
                'api' => true,
            ],
            'code' => [
                'type' => self::STR,
                'maxLength' => 150,
                'required' => 'th_monetize_please_enter_valid_coupon_code',
                'unique' => 'th_monetize_coupon_code_must_be_unique',
                'api' => true,
            ],
            'type' => ['type' => self::STR, 'allowedValues' => ['amount', 'percent']],
            'value' => ['type' => self::UINT, 'default' => 0],
            'active' => ['type' => self::BOOL, 'default' => true],
            'user_criteria' => ['type' => self::JSON_ARRAY, 'default' => []],
        ];

        $structure->getters = [
            'stripe_name' => true,
        ];

        return $structure;
    }

    public function canView(&$error = null)
    {
        if (!$this->active) {
            return false;
        }

        $userCriteria = $this->app()->criteria('XF:User', $this->user_criteria);
        if (!$userCriteria->isMatched(\XF::visitor())) {
            return false;
        }

        return true;
    }

    public function getStripeName()
    {
        return sprintf('%s - %s', $this->code, $this->title);
    }
}
