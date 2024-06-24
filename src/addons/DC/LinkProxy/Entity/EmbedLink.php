<?php

namespace DC\LinkProxy\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class EmbedLink extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_link_Proxy_embed_link';
        $structure->shortName = 'DC\LinkProxy:EmbedLink';
        $structure->contentType = 'fs_link_Proxy_embed_link';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'embed_link' => ['type' => self::STR, 'required' => true],
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
