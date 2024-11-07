<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class ReplyPoints extends AbstractJob
{
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        $db = \XF::db();

        $threadIds = $db->fetchAllColumn('
                SELECT * FROM xf_thread 
                WHERE last_cron_run = ? 
                OR last_thread_update > last_cron_run 
                LIMIT ?          
                ', [
            0,
            $this->data['limit'],
        ]);

        $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->fetch();

        if (!$threads->count()) {

            return $this->complete();
        }

        if (count($threads)) {
            foreach ($threads as $key => $thread) {

                $postReply = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
                $postReply->addEditReplyPoints($thread);

                $currentTime = \XF::$time;

                $thread->bulkSet([
                    'last_thread_update' => $currentTime,
                    'last_cron_run' => $currentTime,
                ]);

                $thread->save();

                if (microtime(true) - $startTime >= $maxRunTime) {
                    break;
                }
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
