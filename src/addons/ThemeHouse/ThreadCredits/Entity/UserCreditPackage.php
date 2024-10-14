<?php

namespace ThemeHouse\ThreadCredits\Entity;

use XF\Entity\PurchaseRequest;
use ThemeHouse\ThreadCredits\XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int $user_credit_package_id
 * @property int $credit_package_id
 * @property int $user_id
 * @property string $purchase_request_key
 * @property array $extra
 * @property int $total_credits
 * @property int $used_credits
 * @property int $remaining_credits
 * @property int $expires_at
 *
 * @property CreditPackage $CreditPackage
 * @property User $User
 * @property PurchaseRequest $PurchaseRequest
 */
class UserCreditPackage extends Entity
{
    public function expire(bool $force = false): void
    {
        if (!$force && $this->expires_at > \XF::$time) {
            // Not time to expire yet
            return;
        }

        $this->remaining_credits = 0;
        $this->save();
    }
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_thtc_user_credit_package';
        $structure->contentType = 'thtc_user_credit_package';
        $structure->primaryKey = 'user_credit_package_id';
        $structure->shortName = 'ThemeHouse\ThreadCredits:UserCreditPackage';

        $structure->columns = [
            'user_credit_package_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'credit_package_id' => ['type' => self::UINT],
            'user_id' => ['type' => self::UINT],
            'purchase_request_key' => ['type' => self::STR, 'maxLength' => 32, 'nullable' => true],
            'extra' => ['type' => self::JSON_ARRAY, 'default' => []],

            'total_credits' => ['type' => self::UINT],
            'used_credits' => ['type' => self::UINT, 'default' => 0],
            'remaining_credits' => ['type' => self::UINT],

            'purchased_at' => ['type' => self::UINT, 'default' => \XF::$time],
            'expires_at' => ['type' => self::UINT, 'default' => 0],
        ];

        $structure->relations = [
            'CreditPackage' => [
                'entity' => 'ThemeHouse\ThreadCredits:CreditPackage',
                'type' => self::TO_ONE,
                'conditions' => 'credit_package_id',
                'primary' => true
            ],
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'PurchaseRequest' => [
                'entity' => 'XF:PurchaseRequest',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['request_key', '=', '$purchase_request_key']
                ]
            ]
        ];

        return $structure;
    }
}