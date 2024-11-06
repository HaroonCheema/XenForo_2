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
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $options = \XF::options();

        $excludeForumIds = $options->fs_thread_scoring_system_exc_forms;

        $threads = \XF::finder('XF:Thread')->where('points_collected', false)->where('node_id', '!=', $excludeForumIds)->limitByPage(1, $this->data['limit'])->fetch();

        if (!$threads->count()) {

            return $this->complete();
        }

        foreach ($threads as $key => $thread) {

            $postThreadPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');

            $postThreadPoint->thread_id = $thread->thread_id;
            $postThreadPoint->user_id = $thread->user_id;
            $postThreadPoint->points_type = 'thread';
            $postThreadPoint->points = intval($options->fs_thread_starter_points);
            $postThreadPoint->percentage = 100;

            $postThreadPoint->save();


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
