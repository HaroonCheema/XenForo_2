<?php

namespace FS\ShowIconInNav\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class NavIcon extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_nav_icon';
        $structure->shortName = 'FS\ShowIconInNav:NavIcon';
        $structure->contentType = 'fs_nav_icon';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'fs_icon_url' => ['type' => self::STR, 'required' => true],
            'enabled' => ['type' => self::BOOL, 'default' => true],
        ];

        $structure->relations = [];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }

    public function getImgUrl($canonical = true)
    {
        $id = $this->id;
        $path = sprintf('ShowIconInNav/' . '/%d/%d.jpg', floor($id / 1000), $id);
        return \XF::app()->applyExternalDataUrl($path, $canonical) . "?" . time();
    }

    public function getAbstractedCustomImgPath()
    {
        $id = $this->id;

        return sprintf('data://ShowIconInNav/' . '/%d/%d.jpg', floor($id / 1000), $id);
    }

    public function isImage()
    {
        $fs = $this->app()->fs();

        $ImgPath = $this->getAbstractedCustomImgPath();

        if ($fs->has($ImgPath)) {
            return 'true';
        }
    }
}
