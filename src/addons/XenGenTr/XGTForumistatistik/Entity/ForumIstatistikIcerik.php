<?php

namespace XenGenTr\XGTForumistatistik\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class ForumIstatistikIcerik extends Entity
{
    public function getTitlePhraseName()
    {
        return 'xgt_forumistatistik.' . $this->icerik_id;
    }

    public function getTitle()
    {
        return \XF::phrase($this->getTitlePhraseName());
    }

    protected function _postSave()
    {
        $this->rebuildForumIstatistikIcerikCache();
    }

    protected function _postDelete()
    {
        $this->rebuildForumIstatistikIcerikCache();
    }

    protected function rebuildForumIstatistikIcerikCache()
    {
        \XF::runOnce('forumIstatistikIcerikCacheRebuild', function()
        {
            $this->getForumIstatistikRepo()->rebuildForumIstatistikIcerikCache();
        });
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xgt_forum_istatistik_icerik';
        $structure->shortName = 'XenGenTr\XGTForumistatistik:ForumIstatistikIcerik';
        $structure->primaryKey = 'icerik_id';
        $structure->columns = [
            'icerik_id' => ['type' => self::STR, 'maxLength' => 25, 'match' => 'alphanumeric', 'required' => true],
            'icerik_sinifi' => ['type' => self::STR, 'maxLength' => 100, 'required' => true],
        ];
        $structure->getters = [
            'title' => true,
        ];
        $structure->relations = [

        ];

        return $structure;
    }

    protected function getForumIstatistikRepo()
    {
        return $this->repository('XenGenTr\XGTForumistatistik:ForumIstatistik');
    }
}