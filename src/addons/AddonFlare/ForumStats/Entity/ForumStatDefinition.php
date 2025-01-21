<?php

namespace AddonFlare\ForumStats\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ForumStatDefinition extends Entity
{
    public function getTitlePhraseName()
    {
        return 'af_forumstats_def.' . $this->definition_id;
    }

    public function getTitle()
    {
        return \XF::phrase($this->getTitlePhraseName());
    }

    protected function _postSave()
    {
        $this->rebuildForumStatDefinitionCache();
    }

    protected function _postDelete()
    {
        $this->rebuildForumStatDefinitionCache();
    }

    protected function rebuildForumStatDefinitionCache()
    {
        \XF::runOnce('forumStatDefinitionCacheRebuild', function()
        {
            $this->getForumStatRepo()->rebuildForumStatDefinitionCache();
        });
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_af_forumstats_stat_definition';
        $structure->shortName = 'AddonFlare\ForumStats:ForumStatDefinition';
        $structure->primaryKey = 'definition_id';
        $structure->columns = [
            'definition_id' => ['type' => self::STR, 'maxLength' => 25, 'match' => 'alphanumeric', 'required' => true],
            'definition_class' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
        ];
        $structure->getters = [
            'title' => true,
        ];
        $structure->relations = [

        ];

        return $structure;
    }

    protected function getForumStatRepo()
    {
        return $this->repository('AddonFlare\ForumStats:ForumStat');
    }
}