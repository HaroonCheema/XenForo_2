<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractJob;

class NotableMemberTotalPoints extends AbstractJob
{
    protected $defaultData = [
        'limit' => 25000,
        'offset' => 1,
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        if ($this->data['offset'] == 1) {
            $db = \XF::db();

            $allUsers = \XF::finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('is_counted', 1)->total();

            if ($allUsers) {

                // $limit = $this->data['limit'];
                $limit = 50000;

                $endIndex = round($allUsers / $limit) ?: 1;

                for ($i = 0; $i < $endIndex; $i++) {
                    $db->update('fs_thread_total_scoring_system', ['is_counted' => 0], 'is_counted = 1', [], '', '', $limit);
                }
            }
        }

        $records = $this->app->finder('FS\ThreadScoringSystem:ScoringSystem')->limitByPage($this->data['offset'], $this->data['limit'])->fetch();

        if (!$records->count()) {

            $db = \XF::db();

            // $limit = $this->data['limit'];
            $limit = 50000;

            $allUsers = \XF::finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('is_counted', 0)->total();

            if ($allUsers) {

                $endIndex = round($allUsers / $limit) ?: 1;

                for ($i = 0; $i < $endIndex; $i++) {

                    $db->delete('fs_thread_total_scoring_system', 'is_counted = 0', [], '', '', $limit);
                }
            }

            // $db->delete('fs_thread_total_scoring_system', 'is_counted = ?', 0);

            return $this->complete();
        }

        $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

        $data = $allTypePoints->getPointsSums($records);

        if (count($data)) {

            if (microtime(true) - $startTime >= $maxRunTime) {
                return $this->resume();
            }

            if (count($data['totalCounts'])) {
                foreach ($data['totalCounts'] as $key => $value) {

                    if (isset($value['thread']) || isset($value['reply']) || isset($value['words']) || isset($value['reactions']) || isset($value['solution']) || isset($value['totalPoints'])) {

                        $threadPoints = isset($value['thread']) ? $value['thread'] : 0;
                        $replyPoints = isset($value['reply']) ? $value['reply'] : 0;
                        $wordPoints = isset($value['words']) ? $value['words'] : 0;
                        $reactionPoints = isset($value['reactions']) ? $value['reactions'] : 0;
                        $solutionPoints = isset($value['solution']) ? $value['solution'] : 0;
                        $totalPoints = isset($value['totalPoints']) ? $value['totalPoints'] : 0;

                        $userExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('user_id', $key)->fetchOne();

                        if ($userExist) {
                            if ($userExist['is_counted'] == 0) {

                                $this->addEditRecord($userExist, $key, $threadPoints, $replyPoints, $wordPoints, $reactionPoints, $solutionPoints, $totalPoints, 1);
                            } else {

                                $this->addEditRecord($userExist, $key, $userExist['threads_score'] + $threadPoints, $userExist['reply_score'] + $replyPoints, $userExist['worlds_score'] + $wordPoints, $userExist['reactions_score'] + $reactionPoints, $userExist['solutions_score'] + $solutionPoints, $userExist['total_score'] + $totalPoints, 1);
                            }
                        } else {
                            $userExist = \XF::em()->create('FS\ThreadScoringSystem:TotalScoringSystem');

                            $this->addEditRecord($userExist, $key, $threadPoints, $replyPoints, $wordPoints, $reactionPoints, $solutionPoints, $totalPoints, 1);
                        }
                    }

                    // if (microtime(true) - $startTime >= $maxRunTime) {
                    //     break;
                    // }
                }
            }
        }

        $this->data['offset']++;

        return $this->resume();
    }

    protected function addEditRecord($user, $key, $threadPoints, $replyPoints, $wordPoints, $reactionPoints, $solutionPoints, $totalPoints, $counted)
    {

        $user->bulkSet([
            'user_id' => $key,
            'threads_score' => $threadPoints,
            'reply_score' => $replyPoints,
            'worlds_score' => $wordPoints,
            'reactions_score' => $reactionPoints,
            'solutions_score' => $solutionPoints,
            'total_score' => $totalPoints,
            'is_counted' => $counted,
        ]);

        $user->save();

        return true;
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
