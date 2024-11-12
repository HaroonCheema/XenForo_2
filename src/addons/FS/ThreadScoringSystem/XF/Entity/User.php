<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['threads_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['reply_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['worlds_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['reactions_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['solutions_score'] =  ['type' => self::FLOAT, 'default' => 0];
        $structure->columns['total_score'] =  ['type' => self::FLOAT, 'default' => 0];

        return $structure;
    }

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
