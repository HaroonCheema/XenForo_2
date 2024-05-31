<?php

namespace FS\GameReviews\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class GameReviews extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_game_reviews';
        $structure->shortName = 'FS\GameReviews:GameReviews';
        $structure->contentType = 'fs_user_upgrade_rating';
        $structure->primaryKey = 'review_id';
        $structure->columns = [
            'review_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'game_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'rating' => ['type' => self::UINT, 'required' => true, 'min' => 1, 'max' => 5],
            'rating_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'message' => ['type' => self::STR, 'default' => ''],
        ];

        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],

            'Game' => [
                'entity' => 'FS\GameReviews:Game',
                'type' => self::TO_ONE,
                'conditions' => 'game_id',
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
        $reviewId = $this->review_id;
        $path = sprintf('GameReviews/' . '/%d/%d.jpg', floor($reviewId / 1000), $reviewId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getAbstractedCustomImgPath()
    {
        $reviewId = $this->review_id;

        return sprintf('data://GameReviews/' . '/%d/%d.jpg', floor($reviewId / 1000), $reviewId);
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
