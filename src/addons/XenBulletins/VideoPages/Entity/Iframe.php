<?php

namespace XenBulletins\VideoPages\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class Iframe extends Entity {

    public static function getStructure(Structure $structure) {
        $structure->table = 'xf_iframe';
        $structure->shortName = 'XenBulletins\VideoPages:Iframe';
        $structure->primaryKey = 'iframe_id';
        $structure->columns = [
            'iframe_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'iframe_title' => ['type' => self::STR, 'maxlength' => 255, 'required' => true],
            'iframe_URL' => ['type' => self::STR, 'maxlength' => 1000, 'required' => true],
            'thumbNail' => ['type' => self::STR, 'maxlength' => 1000],
            'video_id'   => ['type' => self::UINT, 'required' => true],
            'video'   => ['type' => self::STR],
            'provider'   => ['type' => self::STR],
            'rons'       => ['type' => self::STR, 'maxlength' => 255, 'required' => true],
           // 'date'       => ['type' => self::timestamp, 'maxlength' => 255, 'required' => true]
            'date' => ['type' => self::UINT, 'required' => true, 'default' => \XF::$time, ],
            'feature' => ['type' => self::UINT, 'required' => true ],
            'rons_featured' => ['type' => self::UINT],
            'feature_embed' => ['type'=>self::STR ],
            'display_day' => ['type' => self::UINT, 'required' => true, 'default' => 7]
        ];
        $structure->getters = [];
        $structure->relations = [
            'Brand' => [
                'entity' => 'XenBulletins\VideoPages:AddVideo',
                'type' => self::TO_ONE,
                'conditions' => 'video_id',
            ],
        ];
        return $structure;
    }

}
