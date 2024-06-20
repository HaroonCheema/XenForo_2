<?php

namespace DC\LinkProxy\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class TFAuth extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_link_Proxy_tfa_auth';
        $structure->shortName = 'DC\LinkProxy:TFAuth';
        $structure->contentType = 'fs_link_Proxy_tfa_auth';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'created_at' => ['type' => self::UINT, 'default' => \XF::$time],
            'expired_at' => ['type' => self::UINT, 'default' => \XF::$time],
            'auth_password' => ['type' => self::STR, 'required' => true, 'default' => ''],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }

    public function getUserGroupTime()
    {
        return $this->redirect_time;
    }
}
