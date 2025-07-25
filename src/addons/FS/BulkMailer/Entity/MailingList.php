<?php

namespace FS\BulkMailer\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MailingList extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_fs_mailing_list';
        $structure->shortName = 'FS\BulkMailer:MailingList';
        $structure->primaryKey = 'mailing_list_id';
        
        $structure->columns = [
            'mailing_list_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR, 'maxLength' => 50],
            'subject' => ['type' => self::STR, 'nullable' => true],
            'description' => ['type' => self::STR, 'nullable' => true],
            'active' => ['type' => self::BOOL, 'default' => true],
            'display_order' => ['type' => self::UINT, 'default' => 10],
            'owner_id' => ['type' => self::UINT, 'default' => 0],
            'from_email' => ['type' => self::STR, 'maxLength' => 120],
            'from_name' => ['type' => self::STR, 'maxLength' => 255],
            'type' => ['type' => self::UINT, 'default' => 0],
            'usergroup_ids' => ['type' => self::SERIALIZED, 'default' => []],
            'file_path' => ['type' => self::STR, 'default' => ''],
            'emails_per_hour' => ['type' => self::UINT, 'default' => 100],
            'total_emails' => ['type' => self::UINT, 'default' => 0],
            'sent_emails' => ['type' => self::UINT, 'default' => 0],
            'failed_emails' => ['type' => self::UINT, 'default' => 0],
            'process_status' => ['type' => self::UINT, 'default' => 0],
            'next_run' => ['type' => self::UINT, 'default' => 0]

        ];

        return $structure;
    }
}