<?php

namespace XenGenTr\XGTForumistatistik\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ForumIstatistik extends Entity
{
    public function getTitle()
    {
        return $this->custom_title ?: $this->ForumIstatistikIcerik->title;
    }

    public static function pozisyonlar()
    {
        return [
            'anaveri' => 'Anaveri',
        ];
    }

    public function getPozisyonlar()
    {
        return self::pozisyonlar();
    }

    public function getHandler()
    {
        $forumIstatistikIcerik = $this->ForumIstatistikIcerik;

        if (!$forumIstatistikIcerik)
        {
            return null;
        }
        $class = \XF::stringToClass($forumIstatistikIcerik->icerik_sinifi, '%s\Widget\%s');
        if (!class_exists($class))
        {
            return null;
        }
        $class = \XF::extendClass($class);

        return new $class($this->app(), $this);
    }

    public function renderOptions()
    {
        return $this->handler ? $this->handler->renderOptions() : '';
    }

    public function render()
    {
        return $this->handler ? $this->handler->render() : '';
    }

    protected function _postSave()
    {
        $this->rebuildForumIstatistikCache();
    }

    protected function _postDelete()
    {
        $this->rebuildForumIstatistikCache();
    }

    protected function rebuildForumIstatistikCache()
    {
        \XF::runOnce('xengentrForumIstatistikCacheRebuild', function()
        {
            $this->getForumIstatistikRepo()->rebuildForumIstatistikCache();
        });
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xgt_forum_istatistik';
        $structure->shortName = 'XenGenTr\XGTForumistatistik:ForumIstatistik';
        $structure->primaryKey = 'veri_id';
        $structure->columns = [
            'veri_id'         => ['type' => self::UINT, 'autoIncrement' => true],
            'icerik_id'       => ['type' => self::STR, 'maxLength' => 25, 'match' => 'alphanumeric', 'required' => true],
            'pozinyon'        => ['type' => self::STR, 'maxLength' => 30, 'required' => true],
            'display_order'   => ['type' => self::UINT, 'default' => 5],
            'options'         => ['type' => self::JSON_ARRAY, 'default' => []],
            'active'          => ['type' => self::BOOL, 'default' => true],
            'custom_title'    => ['type' => self::STR, 'maxLength' => 50, 'nullable' => true],
			'veri_ikonu'      => ['type' => self::STR, 'maxLength' => 50, 'nullable' => true],
        ];
        $structure->getters = [
            'title'     => true,
            'pozisyonlar' => true,
            'handler'   => true
        ];
        $structure->relations = [
            'ForumIstatistikIcerik' => [
                'entity' => 'XenGenTr\XGTForumistatistik:ForumIstatistikIcerik',
                'type' => self::TO_ONE,
                'conditions' => 'icerik_id',
                'primary' => true
            ]
        ];

        return $structure;
    }

    protected function getForumIstatistikRepo()
    {
        return $this->repository('XenGenTr\XGTForumistatistik:ForumIstatistik');
    }
}