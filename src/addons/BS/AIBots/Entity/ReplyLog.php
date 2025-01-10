<?php

namespace BS\AIBots\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $log_id
 * @property int $to_user_id
 * @property int $reply_date
 * @property string $content_type
 * @property int $content_id
 * @property int $bot_id
 */
class ReplyLog extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_bs_ai_bot_reply_log';
        $structure->shortName = 'BS\AIBots:ReplyLog';
        $structure->primaryKey = 'log_id';
        $structure->columns = [
            'log_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'to_user_id' => ['type' => self::UINT, 'required' => true],
            'reply_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'content_type' => ['type' => self::STR, 'maxLength' => 25, 'required' => true],
            'content_id' => ['type' => self::UINT, 'required' => true],
            'bot_id' => ['type' => self::UINT, 'required' => true],
        ];

        return $structure;
    }
}