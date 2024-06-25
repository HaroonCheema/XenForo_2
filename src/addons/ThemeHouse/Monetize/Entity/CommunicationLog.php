<?php

namespace ThemeHouse\Monetize\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * Class CommunicationLog
 * @package ThemeHouse\Monetize\Entity
 *
 * COLUMNS
 * @property integer communication_log_id
 * @property integer communication_id
 * @property integer log_date
 * @property integer user_id
 *
 * RELATIONS
 * @property \XF\Entity\User User
 * @property Communication Communication
 */
class CommunicationLog extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_th_monetize_communication_log';
        $structure->shortName = 'ThemeHouse/Monetize:CommunicationLog';
        $structure->primaryKey = 'communication_log_id';

        $structure->columns += [
            'communication_log_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'communication_id' => ['type' => self::UINT, 'required' => true],
            'log_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'user_id' => ['type' => self::UINT, 'required' => true],
        ];

        $structure->relations += [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Communication' => [
                'entity' => 'ThemeHouse\Monetize:Communication',
                'type' => self::TO_ONE,
                'conditions' => 'communication_id',
                'primary' => true
            ]
        ];

        return $structure;
    }
}