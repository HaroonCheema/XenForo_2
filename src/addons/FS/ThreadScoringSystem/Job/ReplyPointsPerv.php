<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractRebuildJob;

class ReplyPoints extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 250,
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
        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        if (count($excludeForumIds)) {
            /** @var \XF\Entity\Thread $thread */
            $thread = \XF::finder('XF:Thread')->where('thread_id', $id)->where('node_id', '!=', $excludeForumIds)->fetchOne();
        } else {
            /** @var \XF\Entity\Thread $thread */
            $thread = $this->app->em()->find('XF:Thread', $id);
        }

        if (!$thread) {
            return;
        }

        if ($thread->last_cron_run == 0 || ($thread->last_thread_update > $thread->last_cron_run)) {
            $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
            $postReply->addEditReplyPoints($thread);

            $currentTime = \XF::$time;

            $thread->bulkSet([
                'last_thread_update' => $currentTime,
                'last_cron_run' => $currentTime,
            ]);

            $thread->save();
        } else {
            return;
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('threads');
    }
}
