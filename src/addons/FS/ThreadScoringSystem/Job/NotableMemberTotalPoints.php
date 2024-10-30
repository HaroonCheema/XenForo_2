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

class NotableMemberTotalPoints extends AbstractJob
{

    public function run($maxRunTime)
    {

        $records = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->fetch();

        if (count($records)) {

            $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

            $data = $allTypePoints->getPointsSums($records);

            if (count($data)) {
                if (count($data['totalCounts'])) {
                    foreach ($data['totalCounts'] as $key => $value) {
                        $userExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('user_id', $key)->fetchOne();

                        if (!$userExist) {
                            $userExist = \XF::em()->create('FS\ThreadScoringSystem:TotalScoringSystem');
                        }

                        $userExist->bulkSet([
                            'user_id' => $key,
                            'threads_score' => isset($value['thread']) ? $value['thread'] : 0,
                            'reply_score' => isset($value['reply']) ? $value['reply'] : 0,
                            'worlds_score' => isset($value['words']) ? $value['words'] : 0,
                            'reactions_score' => isset($value['reactions']) ? $value['reactions'] : 0,
                            'solutions_score' => isset($value['solution']) ? $value['solution'] : 0,
                            'total_score' => isset($value['totalPoints']) ? $value['totalPoints'] : 0,
                        ]);

                        $userExist->save();
                    }

                    $userIds = array_keys($data['totalCounts']);

                    $anotherUsersExist = \XF::finder('FS\ThreadScoringSystem:TotalScoringSystem')->where('user_id', '!=', $userIds)->fetch();

                    if (count($anotherUsersExist)) {

                        foreach ($anotherUsersExist as  $value) {

                            $value->delete();
                        }
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
