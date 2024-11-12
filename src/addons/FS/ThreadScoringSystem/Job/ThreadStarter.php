<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class ThreadStarter extends AbstractJob
{
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $options = \XF::options();

        $limit = $this->data['limit'];

        $threadStartPoints = intval($options->fs_thread_starter_points);

        $excludeForumIds = $options->fs_thread_scoring_system_exc_forms;

        $threads = \XF::finder('XF:Thread')->where('points_collected', false)->where('node_id', '!=', $excludeForumIds)->limitByPage(1, $limit)->fetch();

        if (!$threads->count()) {

            return $this->complete();
        }

        foreach ($threads as $key => $thread) {

            $threadStarterPoint = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $thread->user_id)->where('thread_id', $thread->thread_id)->fetchOne();

            if (!$threadStarterPoint) {
                $threadStarterPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
                $threadStarterPoint->total_points = $threadStartPoints;
                $threadStarterPoint->total_percentage = 100;
            } else {
                $threadStarterPoint->total_points += $threadStartPoints;
                $threadStarterPoint->total_percentage += 100;
            }

            $threadStarterPoint->thread_id = $thread->thread_id;
            $threadStarterPoint->user_id = $thread->user_id;
            $threadStarterPoint->thread_points = $threadStartPoints;

            $threadStarterPoint->save();

            $threadUser = $thread->User;

            if (isset($threadUser)) {

                $threadUser->threads_score += $threadStartPoints;
                $threadUser->total_score += $threadStartPoints;

                $threadUser->save();
            }


            $thread->fastUpdate('points_collected', true);

            if (microtime(true) - $startTime >= $maxRunTime) {
                break;
            }
        }

        return $this->resume();
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
