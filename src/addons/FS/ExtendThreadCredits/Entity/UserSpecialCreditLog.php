<?php
namespace FS\ExtendThreadCredits\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;


/**
 * @property int $user_special_credit_id
 * @property int $user_id
 * @property int $moderator_id
 * @property bool $is_moderator
 * @property int $credit_amount
 * @property int $given_at
 * @property string $reason
 */
class UserSpecialCreditLog extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_user_special_credit_log'; // Table name
        $structure->primaryKey = 'user_special_credit_id'; // Primary key
        $structure->shortName = 'FS\ExtendThreadCredits:UserSpecialCreditLog'; // Short name for entity

        // Define the columns
        $structure->columns = [
            'user_special_credit_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT], // ID of the user whose credits are modified
            'moderator_id' => ['type' => self::UINT], // ID of the moderator who performed the action
            'given_at' => ['type' => self::UINT], // Timestamp of the action
            'reason' => ['type' => self::STR, 'maxLength' => 255], // Reason for the credit operation
        ];

        // Define relations
        $structure->relations = [
            'User' => [
                'entity' => 'XF:User', // Relation to the User entity
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Moderator' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => [['user_id', '=', '$moderator_id']], // Linking to the user with `moderator_id`
                'primary' => true,
            ],
        ];
        

        return $structure;
    }

    // Add a method to check if the user is a moderator
    public function isModerator()
    {
        return $this->is_moderator;
    }
}
