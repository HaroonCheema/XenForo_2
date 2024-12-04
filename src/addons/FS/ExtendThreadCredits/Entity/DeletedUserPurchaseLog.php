<?php
namespace FS\ExtendThreadCredits\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int $id
 * @property string $package_name
 * @property int $visitor_id
 * @property string $reason_of_deletion
 * @property int $time
 * @property int $user_credit_package_id
 * @property int $credit_package_id
 * @property int $user_id
 * @property string $purchase_request_key
 * @property mixed $extra
 * @property int $total_credits
 * @property int $used_credits
 * @property int $remaining_credits
 * @property int $purchased_at
 * @property int $expires_at
 */
class DeletedUserPurchaseLog extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_deleted_user_purchase_log';
        $structure->primaryKey = 'id';
        $structure->shortName = 'FS\ExtendThreadCredits:DeletedUserPurchaseLog';

        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'package_name' => ['type' => self::STR, 'maxLength' => 50],
            'visitor_id' => ['type' => self::UINT],
            'reason_of_deletion' => ['type' => self::STR, 'maxLength' => 255],
            'time' => ['type' => self::UINT],
            'user_credit_package_id' => ['type' => self::UINT],
            'credit_package_id' => ['type' => self::UINT, 'nullable' => true],
            'user_id' => ['type' => self::UINT],
            'purchase_request_key' => ['type' => self::STR, 'maxLength' => 32, 'nullable' => true],
            'extra' => ['type' => self::JSON_ARRAY, 'default' => []],
            'total_credits' => ['type' => self::UINT],
            'used_credits' => ['type' => self::UINT, 'default' => 0],
            'remaining_credits' => ['type' => self::UINT],
            'purchased_at' => ['type' => self::UINT, 'default' => 0],
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
