<?php

namespace FS\YtVideoSlider\Entity;

use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $video_id
 * @property string $title
 * @property bool $type
 * @property string $url
 * @property string $thumbnail
 */
class Video extends \XF\Mvc\Entity\Entity
{
    protected function _postDelete()
    {
        $attachment_id = $this->attachment_id;
        if ($attachment_id) {
            /** @var \XF\Entity\Attachment $attachment */
            $attachment = $this->em()->find('XF:Attachment', $attachment_id);
            if ($attachment) {
                $attachment->delete(false);
            }
        }

        $fs = $this->app()->fs();

        $ImgPath = $this->getAbstractedThumbanilPath();

        if ($fs->has($ImgPath)) {
            $fs->delete($ImgPath);
        }
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'fs_yt_video_slider';
        $structure->shortName = 'FS\YtVideoSlider:Video';
        $structure->contentType = 'fs_yt_video_slider';
        $structure->primaryKey = 'video_id';
        $structure->columns = [
            'video_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR, 'maxLength' => 255, 'required' => true],
            'type' => ['type' => self::BOOL, 'default' => 0],
            'url' => ['type' => self::STR, 'maxLength' => 255,  'default' => ''],
            'thumbnail' => ['type' => self::STR, 'maxLength' => 255, 'default' => ''],
            'attachment_id' => ['type' => self::UINT, 'default' => 0],
        ];
        $structure->getters = [];
        $structure->relations = [
            'Attachment' => [
                'entity' => 'XF:Attachment',
                'type' => self::TO_ONE,
                'conditions' => 'attachment_id',
                'primary' => true
            ]
        ];
        $structure->defaultWith = [];
        $structure->behaviors = [];

        return $structure;
    }

    public function getYtWatchUrl()
    {
        $parsedUrl = parse_url($this->url);
        if (isset($parsedUrl['path'])) {
            $videoId = ltrim($parsedUrl['path'], '/');
            return "https://www.youtube.com/watch?v=" . $videoId;
        }
        return '';
    }

    public function getImgUrl($canonical = true)
    {
        $videoId = $this->video_id;
        $path = sprintf('ytVideo/' . '/%d/%d.jpg', floor($videoId / 1000), $videoId);

        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }

    public function getAbstractedThumbanilPath()
    {
        $videoId = $this->video_id;

        return sprintf('data://ytVideo/' . '/%d/%d.jpg', floor($videoId / 1000), $videoId);
    }

    public function isImage()
    {
        $fs = $this->app()->fs();

        $ImgPath = $this->getAbstractedThumbanilPath();

        if ($fs->has($ImgPath)) {
            return 'true';
        }
    }
}
