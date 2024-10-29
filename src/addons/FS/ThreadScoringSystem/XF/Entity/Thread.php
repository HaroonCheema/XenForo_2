<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['points_collected'] =  ['type' => self::BOOL, 'default' => false];
        $structure->columns['last_cron_run'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['last_thread_update'] =  ['type' => self::UINT, 'default' => 0];
        // $structure->columns['latest_rating_avg'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }

    protected function _postSave()
    {
        $parent = parent::_postSave();

        $this->fastUpdate('last_thread_update', \XF::$time);

        return $parent;
    }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        $app = \XF::app();
        $jobID = "delete_that_thread_points" . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ThreadDelete', ['thread_id' => $this->thread_id], false);

        return $parent;
    }

    public function getPointsSums()
    {
        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', $this->thread_id)->fetch();

        $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

        $sumOredByParams = $allTypePoints->getPointsSums($records);

        return $sumOredByParams;
    }

    public function getPercentageSums()
    {
        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', $this->thread_id)->fetch();

        $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

        $sumOredByParams = $allTypePoints->getPercentageSums($records);

        return $sumOredByParams;
    }
}
