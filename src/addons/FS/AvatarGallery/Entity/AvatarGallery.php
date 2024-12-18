<?php

namespace FS\AvatarGallery\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class AvatarGallery extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_avatar_gallery';
        $structure->shortName = 'FS\AvatarGallery:XsAvatarGallery';
        $structure->primaryKey = 'img_id';
        $structure->columns = [
            'img_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'img_path' => ['type' => self::STR, 'maxLength' => 255, 'default' => ''],
        ];

        return $structure;
    }

    public function getAbstractedCustomAvatartImgPath()
    {
        $imgId = $this->img_id;
        return sprintf('data://gallery_avatars/%d.jpg', $imgId);
    }

    public function getAvatarImgUrl($canonical = true)
    {
        $imgId = $this->img_id;
        $path = sprintf('gallery_avatars/%d.jpg', $imgId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }
}
