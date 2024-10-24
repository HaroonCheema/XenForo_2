<?php

namespace FS\ThreadScoringSystem\XF\Entity;

class User extends XFCP_User
{
    public function getTotalPoints()
    {
        $records = $this->finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $this->user_id)->fetch();

        if (count($records)) {
            $allTypePoints = \XF::service('FS\ThreadScoringSystem:ReplyPoints');

            $response = $allTypePoints->getAllTypePointsScores($records);

            $totalPoints = 0;

            if (isset($response['totalCounts'][$this->user_id])) {

                $totalPoints = number_format($response['totalCounts'][$this->user_id]['totalPoints'], 2);
            }

            return $totalPoints;
        }

        return 0;
    }
}
