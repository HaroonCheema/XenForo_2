<?php

namespace FS\BulkMailer\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MailQueue extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_fs_mail_queue';
        $structure->shortName = 'FS\BulkMailer:MailQueue';
        $structure->primaryKey = 'queue_id';
        
        $structure->columns = [
            'queue_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'mailing_list_id' => ['type' => self::UINT],
            'user_id' => ['type' => self::UINT, 'default' => 0],
            'email' => ['type' => self::STR],
            'status' => ['type' => self::STR, 'default' => 'pending'],
            'send_date' => ['type' => self::UINT, 'nullable' => true],
            'error_message' => ['type' => self::STR, 'nullable' => true],
            'attempts' => ['type' => self::UINT, 'default' => 0]
        ];
        
         $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'MailList' => [
                'entity' => 'FS\BulkMailer:MailingList',
                'type' => self::TO_ONE,
                'conditions' => 'mailing_list_id',
                'primary' => true
            ],
           
        ];

        return $structure;
    }
}