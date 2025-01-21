<?php

namespace AddonFlare\ForumStats\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ForumStat extends Entity
{
    protected static $hasExtendedGet = null;

    public function getTitle()
    {
        return $this->custom_title ?: $this->ForumStatDefinition->title;
    }

    public static function positions()
    {
        return [
            'left' => 'Left',
            'main' => 'Main',
        ];
    }

    public function getPositions()
    {
        return self::positions();
    }

    public function getHandler()
    {
        $forumStatDefinition = $this->ForumStatDefinition;

        if (!$forumStatDefinition)
        {
            return null;
        }
        $class = \XF::stringToClass($forumStatDefinition->definition_class, '%s\ForumStat\%s');
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
        $this->rebuildForumStatCache();
    }

    protected function _postDelete()
    {
        $this->rebuildForumStatCache();
    }

    protected function rebuildForumStatCache()
    {
        \XF::runOnce('addonFlareForumStatCacheRebuild', function()
        {
            $this->getForumStatRepo()->rebuildForumStatCache();
        });
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_af_forumstats_stat';
        $structure->shortName = 'AddonFlare\ForumStats:ForumStat';
        $structure->primaryKey = 'stat_id';
        $structure->columns = [
            'stat_id'         => ['type' => self::UINT, 'autoIncrement' => true],
            'definition_id'   => ['type' => self::STR, 'maxLength' => 25, 'match' => 'alphanumeric', '                     required' => true],
            'position'        => ['type' => self::STR, 'maxLength' => 30, 'required' => true],
            'display_order'   => ['type' => self::UINT, 'default' => 5],
            'options'         => ['type' => self::JSON_ARRAY, 'default' => []],
            'active'          => ['type' => self::BOOL, 'default' => true],
            'custom_title'    => ['type' => self::STR, 'maxLength' => 50, 'nullable' => true],
        ];
        $structure->getters = [
            'title'     => true,
            'positions' => true,
            'handler'   => true
        ];
        $structure->relations = [
            'ForumStatDefinition' => [
                'entity' => 'AddonFlare\ForumStats:ForumStatDefinition',
                'type' => self::TO_ONE,
                'conditions' => 'definition_id',
                'primary' => true
            ]
        ];

        return $structure;
    }

    public function get($key)
    {
        if (!self::$hasExtendedGet)
        {
            self::$hasExtendedGet = \XF::extendClass('\XF\Template\Templater');
        }

        $hasExtendedGet = self::$hasExtendedGet;
        return parent::get($hasExtendedGet::getAfForumStats($key));
    }

    protected function getForumStatRepo()
    {
        return $this->repository('AddonFlare\ForumStats:ForumStat');
    }
}