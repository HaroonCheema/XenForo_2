<?php

namespace FS\SendMailFromTable\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class CronEmailLogs extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_cron_emails_log';
        $structure->shortName = 'FS\SendMailFromTable:CronEmailLogs';
        $structure->contentType = 'fs_cron_emails_log';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],

            'to' => ['type' => self::UINT, 'default' => \XF::$time],

            'email_ids' => ['type' => self::JSON_ARRAY, 'default' => []],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
