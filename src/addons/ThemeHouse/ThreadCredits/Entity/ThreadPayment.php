<?php

namespace ThemeHouse\ThreadCredits\Entity;

use XF\Entity\Thread;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int $thread_payment_id
 * @property int $user_credit_package_id
 * @property int $thread_id
 * @property int $user_id
 * @property int $page
 *
 * @property UserCreditPackage $UserCreditPackage
 * @property User $User
 * @property Thread $Thread
 */
class ThreadPayment extends Entity
{
    protected function _postSave()
    {
        if($this->isInsert()) {
            $this->UserCreditPackage->remaining_credits = $this->UserCreditPackage->remaining_credits - 1;
            $this->UserCreditPackage->save();
        }
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_thtc_thread_payment';
        $structure->contentType = 'thtc_thread_payment';
        $structure->primaryKey = 'thread_payment_id';
        $structure->shortName = 'ThemeHouse\ThreadCredits:ThreadPayment';

        $structure->columns = [
            'thread_payment_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'user_credit_package_id' => ['type' => self::UINT],
            'thread_id' => ['type' => self::UINT],
            'user_id' => ['type' => self::UINT],
            'page' => ['type' => self::UINT],

            'purchased_at' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [
            'UserCreditPackage' => [
                'entity' => 'ThemeHouse\ThreadCredits:UserCreditPackage',
                'type' => self::TO_ONE,
                'conditions' => 'user_credit_package_id',
                'primary' => true
            ],
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}