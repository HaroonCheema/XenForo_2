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

class ReplyPoints extends AbstractJob
{

    public function run($maxRunTime)
    {

        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        // $conditions = [
        //     ['last_cron_run', 0],
        //     ['last_thread_update', '>', 'last_cron_run'],
        // ];

        // $pendingthreadsCount = \XF::finder('XF:Thread')->where('node_id', '!=', $excludeForumIds)->whereOr($conditions)->total();

        $limit = 500;

        $db = \XF::db();

        $threadsCount = $db->fetchAll('
        SELECT COUNT(*) AS total_count
        FROM xf_thread
        WHERE last_cron_run = 0 OR last_thread_update > last_cron_run          
        ');

        $pendingthreadsCount = $threadsCount['0']['total_count'];

        if ($pendingthreadsCount) {

            $endLimit = round($pendingthreadsCount / $limit) ?: 1;

            for ($i = 0; $i < $endLimit; $i++) {

                $threadIds = $db->fetchAllColumn('
                SELECT * FROM xf_thread 
                WHERE last_cron_run = ? 
                OR last_thread_update > last_cron_run 
                LIMIT ?          
                ', [
                    0,
                    $limit,
                ]);

                // $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->fetch();
                $threads = \XF::finder('XF:Thread')->where('thread_id', $threadIds)->where('node_id', '!=', $excludeForumIds)->fetch();

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
                    }
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
