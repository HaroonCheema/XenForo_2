<?php

namespace FS\SelectTeam\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Team extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_teams';
        $structure->shortName = 'FS\SelectTeam:Team';
        $structure->contentType = 'fs_teams';
        $structure->primaryKey = 'id';
        $structure->columns = [
            'id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
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
        $path = sprintf('fsTeams/' . '/%d/%d.jpg', floor($id / 1000), $id);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getAbstractedCustomImgPath()
    {
        $id = $this->id;

        return sprintf('data://fsTeams/' . '/%d/%d.jpg', floor($id / 1000), $id);
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
