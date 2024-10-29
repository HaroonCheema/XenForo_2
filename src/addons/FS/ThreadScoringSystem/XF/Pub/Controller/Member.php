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

            $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->fetch();

            $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

            // if ($options->fs_thread_scoring_list_format == 'points') {

            $data = $allTypePoints->getPointsSums($records);
            // } else {
            //     $data = $allTypePoints->getPercentageSums($records);
            // }

            $parent->setParam('data', $data);
        }

        return $parent;
    }

    public function actionAllUsersPoints()
    {

        // $options = \XF::options();

        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->fetch();

        $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

        // if ($options->fs_thread_scoring_list_format == 'points') {

        $data = $allTypePoints->getPointsSums($records);
        // } else {
        //     $data = $allTypePoints->getPercentageSums($records);
        // }

        $viewParams = [
            'totalCounts' => $data['totalCounts'],
            'records' => $data['records'],
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
