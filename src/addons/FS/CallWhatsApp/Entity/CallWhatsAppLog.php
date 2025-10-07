<?php

namespace FS\CallWhatsApp\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class CallWhatsAppLog extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_callwhatsapp_log';
        $structure->shortName = 'FS\CallWhatsApp:CallWhatsAppLog';
        $structure->primaryKey = 'log_id';

        $structure->columns = [
            'log_id'        => ['type' => self::UINT, 'autoIncrement' => true],
            'thread_id'     => ['type' => self::UINT, 'default' => 0],
            'post_id'       => ['type' => self::UINT, 'default' => 0],
            'phone_number'  => ['type' => self::STR, 'maxLength' => 255, 'nullable' => true, 'default' => null],
            'gender'        => ['type' => self::STR, 'allowedValues' => ['ES', 'TX'], 'default' => 'ES'],
            'city'          => ['type' => self::STR, 'maxLength' => 255, 'nullable' => true, 'default' => null],
            'action_type'   => ['type' => self::STR, 'allowedValues' => ['call', 'whatsapp'], 'default' => 'whatsapp'],
            'user_id'       => ['type' => self::UINT, 'default' => 0],
            'username'      => ['type' => self::STR, 'maxLength' => 100, 'nullable' => true, 'default' => null],
            'ip_address'    => ['type' => self::STR, 'maxLength' => 255, 'nullable' => true, 'default' => null],
            'timestamp'     => ['type' => self::UINT, 'default' => \XF::$time], // stored as INT
        ];

        $structure->relations = [
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
            ],'ThreadCounter' => [
                'entity' => 'FS\CallWhatsApp:CallWhatsAppCounter',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ],
            'Post' => [
                'entity' => 'XF:Post',
                'type' => self::TO_ONE,
                'conditions' => 'post_id',
                'primary' => true
            ]
        ];

        return $structure;
    }
}
