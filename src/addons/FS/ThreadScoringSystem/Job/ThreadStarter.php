<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;
use XF\Mvc\Entity\Finder;
use XF\Mvc\ParameterBag;
use XF\Http\Response;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use XF\Mvc\FormAction;
use XF\Mvc\View;

class ThreadStarter extends AbstractJob
{

    public function run($maxRunTime)
    {
        $options = \XF::options();

        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        $pendingthreadsCount = \XF::finder('XF:Thread')->where('points_collected', false)->where('node_id', '!=', $excludeForumIds)->total();

        if ($pendingthreadsCount) {

            $limit = 1000;

            $endLimit = round($pendingthreadsCount / $limit) ?: 1;

            for ($i = 0; $i < $endLimit; $i++) {
                $threads = \XF::finder('XF:Thread')->where('points_collected', false)->where('node_id', '!=', $excludeForumIds)->limitByPage(1, $limit)->fetch();

                if (count($threads)) {
                    foreach ($threads as $key => $thread) {

                        $postThreadPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');

                        $postThreadPoint->thread_id = $thread->thread_id;
                        $postThreadPoint->user_id = $thread->user_id;
                        $postThreadPoint->points_type = 'thread';
                        $postThreadPoint->points = intval($options->fs_thread_starter_points);
                        $postThreadPoint->percentage = 100;

                        $postThreadPoint->save();


                        $thread->fastUpdate('points_collected', true);
                    }
                } else {
                    return $this->complete();
                }
            }
        }

        return $this->complete();
    }

    public function writelevel() {}

    public function getStatusMessage()
    {
        return \XF::phrase('processing_successfully...');
    }

    public function canCancel()
    {
        return false;
    }

    public function canTriggerByChoice()
    {
        return false;
    }
}
