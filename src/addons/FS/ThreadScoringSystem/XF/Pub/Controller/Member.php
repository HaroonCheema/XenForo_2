<?php

namespace FS\ThreadScoringSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionIndex(ParameterBag $params)
    {
        $parent =  parent::actionIndex($params);

        $username = $this->filter('username', 'str');

        if (!($params->user_id || $username)) {

            // $options = \XF::options();

            $records = $this->finder('FS\ThreadScoringSystem:TotalScoringSystem')->fetch();

            if (!count($records)) {
                return $parent;
            }

            // if ($options->fs_thread_scoring_list_format == 'points') {

            // } else {
            //     $data = $allTypePoints->getPercentageSums($records);
            // }

            $parent->setParam('data', $records);
        }

        return $parent;
    }

    public function actionAllUsersPoints()
    {

        $records = $this->finder('FS\ThreadScoringSystem:TotalScoringSystem')->fetch();

        // if ($options->fs_thread_scoring_list_format == 'points') {

        // } else {
        //     $data = $allTypePoints->getPercentageSums($records);
        // }

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->view('FS\ThreadScoringSystem:Member\AllUsersPoints', 'fs_thread_scoring_all_score_notable', $viewParams);
    }

    public function actionMyPointsScore(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        if (!\xf::visitor()->hasPermission('fs_thread_scoring_system', 'can_view')) {
            return $this->noPermission();
        }

        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $user->user_id)->fetch();

        if (count($records)) {
            $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

            $viewParams = $allTypePoints->getAllTypePointsScores($records);
        } else {
            $viewParams = array();
        }

        return $this->view('FS\ThreadScoringSystem\XF:Member\MyPointsScore', 'fs_thread_scoring_my_score', $viewParams);
    }
}
