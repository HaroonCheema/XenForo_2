<?php

namespace NF\GiftUpgrades\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Extends \XF\Entity\UserUpgradeExpired
 *
 * @property int $is_gift
 * @property int $pay_user_id
 * @property bool $nf_was_gifted_for_free
 *
 * @property-read ?User $User
 */
class UserUpgradeExpired extends XFCP_UserUpgradeExpired
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['is_gift'] = ['type' => self::BOOL, 'default' => false];
        $structure->columns['pay_user_id'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['nf_was_gifted_for_free'] = ['type' => self::BOOL, 'default' => false];

	    $structure->relations['PayUser'] = [
		    'entity' => 'XF:User',
		    'type' => self::TO_ONE,
		    'conditions' => [
			    ['user_id', '=', '$pay_user_id']
		    ],
		    'primary' => true,
		    'api' => true
	    ];
    
        return $structure;
    }
}