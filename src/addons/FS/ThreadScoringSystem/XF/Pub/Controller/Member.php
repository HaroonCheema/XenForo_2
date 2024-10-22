<?php

namespace FS\ThreadScoringSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

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
