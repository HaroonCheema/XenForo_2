<?php

namespace FS\ThreadScoringSystem\Cron;

class ScoringSystem
{

    public static function postReplyPoints()
    {
        $app = \XF::app();

        $jobID = "thread_reply_points" . time();
        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ReplyPoints', [], false);

        $jobID = "thread_solution_points" . time();
        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:SolutionPoints', [], false);

        $jobID = "exclude_forum_threads_delete" . time();
        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ExcludeForumsThreadsDelete', [], false);
    }

    public static function monthlyTotalUsersPoints()
    {
        $app = \XF::app();
        $jobID = "monthly_total_points" . time();

        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:MonthWiseScore', [], false);
        // $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ThreadStarter', [], true);
        // $app->jobManager()->runUnique($jobID, 120);
    }
}
