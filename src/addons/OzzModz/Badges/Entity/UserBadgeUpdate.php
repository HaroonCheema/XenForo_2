<?php

namespace OzzModz\Badges\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $user_id
 * @property int $queue_date
 *
 * RELATIONS
 * @property \OzzModz\Badges\XF\Entity\User $User
 */
class UserBadgeUpdate extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_ozzmodz_badges_user_badge_update';
        $structure->shortName = 'OzzModz\Badges:UserBadgeUpdate';
        $structure->primaryKey = 'user_id';
        $structure->columns = [
            'user_id' => ['type' => static::UINT, 'required' => true],
            'queue_date' => ['type' => static::UINT, 'required' => true],
        ];

		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			]
		];

        return $structure;
    }
}