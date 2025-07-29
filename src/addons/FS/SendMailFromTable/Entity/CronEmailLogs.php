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

            'from' => ['type' => self::UINT, 'default' => \XF::$time],
            'to' => ['type' => self::UINT, 'default' => \XF::$time],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }
}
