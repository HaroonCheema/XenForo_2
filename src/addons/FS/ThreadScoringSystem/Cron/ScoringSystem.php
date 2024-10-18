<?php

namespace FS\ThreadScoringSystem\Cron;

class ScoringSystem
{
    public static function threadStarterPoints()
    {
        $app = \XF::app();
        $jobID = "thread_starter_points";

        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ThreadStarter', [], false);
        // $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ThreadStarter', [], true);
        // $app->jobManager()->runUnique($jobID, 120);
    }

    public static function postReplyPoints()
    {
        $app = \XF::app();
        $jobID = "thread_reply_points";

        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:ReplyPoints', [], false);
    }

    public static function threadSolutionPoints()
    {
        $app = \XF::app();
        $jobID = "thread_solution_points";

        $app->jobManager()->enqueueUnique($jobID, 'FS\ThreadScoringSystem:SolutionPoints', [], false);
    }
}
