<?php

namespace FS\CallWhatsApp\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class CallWhatsAppCounter extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_callwhatsapp_counter';
        $structure->shortName = 'FS\CallWhatsApp:CallWhatsAppCounter';
        $structure->primaryKey = 'thread_id';
        $structure->columns = [
            'thread_id'       => ['type' => self::UINT, 'required' => true],
            'call_count'      => ['type' => self::UINT, 'default' => 0],
            'whatsapp_count'  => ['type' => self::UINT, 'default' => 0],
        ];

        $structure->relations = [
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ]
        ];

        return $structure;
    }
}
