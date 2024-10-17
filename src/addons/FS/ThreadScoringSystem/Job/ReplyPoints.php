<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractRebuildJob;

class ReplyPoints extends AbstractRebuildJob
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
        if (!$thread) {
            return;
        }

        $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
        $postReply->addEditReplyPoints($thread);
    }

    protected function getStatusType()
    {
        return \XF::phrase('threads');
    }
}
