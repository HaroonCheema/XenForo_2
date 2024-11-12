<?php

namespace FS\ThreadScoringSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class ThreadQuestion extends XFCP_ThreadQuestion
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['points_collected'] =  ['type' => self::BOOL, 'default' => false];

        return $structure;
    }

    protected function _postSave()
    {
        $parent = parent::_postSave();

        if ($this->isUpdate() && $this->isChanged('solution_user_id')) {

            $deleteSolution = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('solution_points', '!=', 0)->where('thread_id', $this->thread_id)->fetchOne();

            if ($deleteSolution) {

                $deleteSolutionUser = $deleteSolution->User;

                if (isset($deleteSolutionUser)) {
                    $solutionPoints = $deleteSolution->solution_points;

                    $deleteSolutionUser->solutions_score -= $solutionPoints;
                    $deleteSolutionUser->total_score -= $solutionPoints;

                    $deleteSolutionUser->save();
                }

                $deleteSolution->total_points -= $deleteSolution->solution_points;
                $deleteSolution->total_percentage -= 100;

                $deleteSolution->solution_points = 0;

                $deleteSolution->save();

                $this->fastUpdate('points_collected', false);
            }
        }

        return $parent;
    }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        $threadQuestion = $this;

        if ($threadQuestion->solution_user_id) {

            $deleteSolution = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('user_id', $threadQuestion->solution_user_id)->where('thread_id', $threadQuestion->thread_id)->fetchOne();

            if ($deleteSolution) {

                $deleteSolutionUser = $deleteSolution->User;

                if (isset($deleteSolutionUser)) {
                    $solutionPoints = $deleteSolution->solution_points;

                    $deleteSolutionUser->solutions_score -= $solutionPoints;
                    $deleteSolutionUser->total_score -= $solutionPoints;

                    $deleteSolutionUser->save();
                }

                $deleteSolution->total_points -= $deleteSolution->solution_points;

                $deleteSolution->solution_points = 0;

                $deleteSolution->save();

                $threadQuestion->fastUpdate('points_collected', false);
            }
        }

        return $parent;
    }
}
