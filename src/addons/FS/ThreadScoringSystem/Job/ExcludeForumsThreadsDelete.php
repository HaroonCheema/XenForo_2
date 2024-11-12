<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class ExcludeForumsThreadsDelete extends AbstractJob
{
    public function run($maxRunTime)
    {
        $excludeForumIds = \XF::options()->fs_thread_scoring_system_exc_forms;

        $app = \xf::app();

        if (count($excludeForumIds)) {
            $threadFinder = $app->finder('XF:Thread')->where('node_id', $excludeForumIds);

            $threadIds = $threadFinder->pluckfrom('thread_id')->fetch()->toArray();

            if (count($threadIds)) {
                $records = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('thread_id', $threadIds)->fetch();

                if (count($records)) {

                    foreach ($records as $value) {

                        $thread = $value->Thread;

                        if (isset($thread)) {
                            $thread->bulkSet([
                                'last_cron_run' => 0,
                                'points_collected' => false,
                            ]);

                            $thread->save();
                        }

                        $excludeForumUser = $value->User;

                        if (isset($excludeForumUser)) {

                            $excludeForumUser->threads_score -= floatval($value->thread_points);
                            $excludeForumUser->reply_score -= floatval($value->reply_points);
                            $excludeForumUser->worlds_score -= floatval($value->word_points);
                            $excludeForumUser->reactions_score -= floatval($value->reaction_points);
                            $excludeForumUser->solutions_score -= floatval($value->solution_points);
                            $excludeForumUser->total_score -= floatval($value->total_points);

                            $excludeForumUser->save();
                        }

                        $value->delete();
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
