<?php

namespace FS\PackageRating\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class PackageRating extends Entity
{
    public function canReply(&$error = null)
    {

        return true;
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_user_upgrade_rating';
        $structure->shortName = 'FS\PackageRating:PackageRating';
        $structure->contentType = 'fs_user_upgrade_rating';
        $structure->primaryKey = 'rating_id';
        $structure->columns = [
            'rating_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'user_upgrade_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'rating' => ['type' => self::UINT, 'required' => true, 'min' => 1, 'max' => 5],
            'rating_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'message' => ['type' => self::STR, 'default' => ''],
            'author_response' => ['type' => self::STR, 'default' => ''],
            'author_id' => ['type' => self::UINT, 'default' => 0],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],

            'Upgrade' => [
                'entity' => 'XF:UserUpgrade',
                'type' => self::TO_ONE,
                'conditions' => 'user_upgrade_id',
                'primary' => true
            ],

            'Author' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => ['user_id', '=', '$author_id'],
                'primary' => true
            ],
        ];
        $structure->defaultWith = [];
        $structure->getters = [];
        $structure->behaviors = [];

        return $structure;
    }

    public function getImgUrl($canonical = true)
    {
        $ratingId = $this->rating_id;
        $path = sprintf('PkgRatingImage/' . '/%d/%d.jpg', floor($ratingId / 1000), $ratingId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getAbstractedCustomImgPath()
    {
        $ratingId = $this->rating_id;

        return sprintf('data://PkgRatingImage/' . '/%d/%d.jpg', floor($ratingId / 1000), $ratingId);
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
