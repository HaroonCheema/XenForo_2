<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['points_collected'] =  ['type' => self::BOOL, 'default' => false];

        return $structure;
    }

    // protected function _postSave()
    // {
    //     $parent = parent::_postSave();

    //     $exist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'thread')->where('thread_id', $this->thread_id)->fetchOne();

    //     if (!$exist) {
    //         $options = \XF::options();

    //         $postThreadPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');

    //         $postThreadPoint->thread_id = $this->thread_id;
    //         $postThreadPoint->user_id = $this->user_id;
    //         $postThreadPoint->points_type = 'thread';
    //         $postThreadPoint->points = intval($options->fs_thread_starter_points);
    //         $postThreadPoint->percentage = 100;

    //         $postThreadPoint->save();

    //         $this->fastUpdate('points_collected', true);
    //     }

    //     return $parent;
    // }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        $exist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', $this->thread_id)->fetch();

        if (count($exist)) {

            foreach ($exist as  $value) {
                $value->delete();
            }
        }
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
