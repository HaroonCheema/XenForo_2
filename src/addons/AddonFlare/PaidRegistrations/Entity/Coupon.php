<?php

namespace AddonFlare\PaidRegistrations\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Coupon extends Entity
{
    public function calculateDiscountAmount($originalCost)
    {
        $discountValue = $this->discount_value;

        if ($this->discount_type == 'percent')
        {
            $discountPercent = $discountValue;
            $discountAmount =  $originalCost * ($discountPercent / 100);
            $discountAmount = round($discountAmount, 2);
        }
        else if ($this->discount_type == 'flat')
        {
            $discountAmount = $discountValue;
        }
        else
        {
            $discountAmount = 0;
        }

        return $discountAmount;
    }

    public function getTimestampPickerData($timestamp)
    {
        if (!$timestamp)
        {
            return [];
        }

        $language = \XF::language();

        $tz = $language->getTimeZone();

        $dateObj = new \DateTime('@' . $timestamp);
        $dateObj->setTimezone($tz);

        $data = [
            'm'  => $dateObj->format('n'),
            'd'  => $dateObj->format('j'),
            'y'  => $dateObj->format('Y'),
            'picker' => $dateObj->format('Y-m-d'),
            'hh' => $dateObj->format('G'),
            'mm' => $dateObj->format('i'),
            'timezone' => $tz->getName(),
        ];

        return $data;
    }

    public function getStartDateData()
    {
        return $this->getTimestampPickerData($this->start_date);
    }

    public function getEndDateData()
    {
        return $this->getTimestampPickerData($this->end_date);
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_af_paidregistrations_coupon';
        $structure->shortName = 'AddonFlare\PaidRegistrations:Coupon';
        $structure->primaryKey = 'coupon_id';
        $structure->columns = [
            'coupon_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'title'    => ['type' => self::STR, 'required' => true, 'maxLength' => 255],
            'coupon_code' => ['type' => self::STR, 'default' => '', 'maxLength' => 100],
            'start_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'end_date' => ['type' => self::UINT, 'default' => 0],
            'discount_type' => ['type' => self::STR, 'required' => true,
                'allowedValues' => ['percent', 'flat']
            ],
            'discount_value' => ['type' => self::FLOAT, 'required' => true],
            'uses_remaining'   => ['type' => self::UINT, 'default' => 0],
            'unlimited_uses'   => ['type' => self::BOOL, 'default' => true],
            'user_group_ids' => ['type' => self::LIST_COMMA, 'default' => [],
                'list' => ['type' => 'int', 'unique' => true, 'sort' => SORT_NUMERIC]
            ],
            'account_type_ids' => ['type' => self::LIST_COMMA, 'default' => [],
                'list' => ['type' => 'int', 'unique' => true, 'sort' => SORT_NUMERIC]
            ],
            'active' => ['type' => self::BOOL, 'default' => true],
        ];

        $structure->getters = [
            'start_date_data' => true,
            'end_date_data' => true,
        ];

        $structure->relations = [

        ];

        return $structure;
    }
}