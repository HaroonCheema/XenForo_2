<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class SolutionPoints extends AbstractJob
{
    protected $defaultData = [
        'limit' => 1000,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $options = \XF::options();

        $limit = $this->data['limit'];

        $threadSolutions = \XF::finder('XF:ThreadQuestion')->where('solution_user_id', '!=', 0)->where('points_collected', false)->limitByPage(1, $limit)->fetch();

        if (!$threadSolutions->count()) {

            return $this->complete();
        }

        foreach ($threadSolutions as $key => $solution) {

            $threadSolutionPoints = intval($options->fs_total_solution_points);

            $userId = $solution->solution_user_id;
            $threadId = $solution->thread_id;

            $threadSolutionUser = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $userId)->where('thread_id', $threadId)->fetchOne();

            if (!$threadSolutionUser) {
                $threadSolutionUser = \XF::em()->create('FS\ThreadScoringSystem:ScoringSystem');
                $threadSolutionUser->total_points = $threadSolutionPoints;
                $threadSolutionUser->total_percentage = 100;
            } else {
                $threadSolutionUser->total_points += $threadSolutionPoints;
                $threadSolutionUser->total_percentage += 100;
            }

            $threadSolutionUser->thread_id = $threadId;
            $threadSolutionUser->user_id = $userId;
            $threadSolutionUser->solution_points = $threadSolutionPoints;

            $threadSolutionUser->save();

            $solutionUser = $solution->User;

            if (isset($solutionUser)) {
                $solutionUser->solutions_score += $threadSolutionPoints;
                $solutionUser->total_score += $threadSolutionPoints;

                $solutionUser->save();
            }

            $solution->fastUpdate('points_collected', true);

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
