<?php

namespace FS\LogoSlider\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Logo extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_logo_slider';
        $structure->shortName = 'FS\LogoSlider:Logo';
        $structure->contentType = 'fs_logo_slider';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'logo_url' => ['type' => self::STR, 'required' => true],
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
        $path = sprintf('LogoSlider/' . '/%d/%d.jpg', floor($id / 1000), $id);
        return \XF::app()->applyExternalDataUrl($path, $canonical) . "?" . time();
    }

    public function getAbstractedCustomImgPath()
    {
        $id = $this->id;

        return sprintf('data://LogoSlider/' . '/%d/%d.jpg', floor($id / 1000), $id);
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
