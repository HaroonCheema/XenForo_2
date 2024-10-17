<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractRebuildJob;

class ThreadStarter extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 1000,
    ];

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
				SELECT thread_id
				FROM xf_thread
				WHERE thread_id > ?
				ORDER BY thread_id
			",
            $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        /** @var \XF\Entity\Thread $thread */
        $thread = $this->app->em()->find('XF:Thread', $id);
        if ($thread->points_collected || !$thread) {
            return;
        }
        $options = \XF::options();

        $postThreadPoint = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');

        $postThreadPoint->thread_id = $thread->thread_id;
        $postThreadPoint->user_id = $thread->user_id;
        $postThreadPoint->points_type = 'thread';
        $postThreadPoint->points = intval($options->fs_thread_starter_points);
        $postThreadPoint->percentage = 100;

        $postThreadPoint->save();


        $thread->fastUpdate('points_collected', true);
    }

    protected function getStatusType()
    {
        return \XF::phrase('threads');
    }
}
