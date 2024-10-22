<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['points_collected'] =  ['type' => self::BOOL, 'default' => false];
        $structure->columns['latest_rating_avg'] =  ['type' => self::FLOAT, 'default' => 0];

        return $structure;
    }

    protected function _postSave()
    {
        $parent = parent::_postSave();

        $exist = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'thread')->where('thread_id', $this->thread_id)->fetchOne();

        if (!$exist) {
            $options = \XF::options();

            $postThreadPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');

            $postThreadPoint->thread_id = $this->thread_id;
            $postThreadPoint->user_id = $this->user_id;
            $postThreadPoint->points_type = 'thread';
            $postThreadPoint->points = intval($options->fs_thread_starter_points);
            $postThreadPoint->percentage = 100;

            $postThreadPoint->save();

            $this->fastUpdate('points_collected', true);
        }

        return $parent;
    }

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

        $totalCounts = array();
        $newRecords = array();

        foreach ($records as  $value) {

            $userId = $value->user_id;

            if (isset($totalCounts[$userId]['totalPoints'])) {

                $totalCounts[$userId]['totalPoints'] += $value['points'];
            } else {
                $newRecords[] = $value;

                $totalCounts[$userId]['totalPoints'] = $value['points'];
            }

            switch ($value['points_type']) {
                case 'reply': {
                        if (isset($totalCounts[$userId]['reply'])) {

                            $totalCounts[$userId]['reply'] += floatval($value['points']);
                        } else {

                            $totalCounts[$userId]['reply'] = floatval($value['points']);
                        }
                    }
                    break;

                case 'words': {
                        if (isset($totalCounts[$userId]['words'])) {

                            $totalCounts[$userId]['words'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['words'] = $value['points'];
                        }
                    }
                    break;

                case 'reactions': {
                        if (isset($totalCounts[$userId]['reactions'])) {

                            $totalCounts[$userId]['reactions'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['reactions'] = $value['points'];
                        }
                    }
                    break;

                case 'thread': {
                        if (isset($totalCounts[$userId]['thread'])) {

                            $totalCounts[$userId]['thread'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['thread'] = $value['points'];
                        }
                    }
                    break;

                case 'solution': {
                        if (isset($totalCounts[$userId]['solution'])) {

                            $totalCounts[$userId]['solution'] += $value['points'];
                        } else {

                            $totalCounts[$userId]['solution'] = $value['points'];
                        }
                    }
                    break;
                    // default:
                    //     $value = 0;
            }
        }

        $sumParams = [
            'totalCounts' => $totalCounts,
            'records' => $newRecords,
        ];

        return $sumParams;
    }
}
