<?php

namespace FS\ThreadScoringSystem\XF\Entity;

class ThreadQuestion extends XFCP_ThreadQuestion
{
    protected function _postSave()
    {
        $parent = parent::_postSave();

        if ($this->isInsert() && $this->solution_post_id && $this->solution_user_id) {
            $threadQuestionServ = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
            $threadQuestionServ->addEditSolutionPoints($this);
        }

        if ($this->isUpdate() && $this->isChanged('solution_post_id')) {

            if ($this->solution_post_id) {
                $threadQuestionServ = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
                $threadQuestionServ->addEditSolutionPoints($this);
            } else {
                $deleteSolution = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'solution')->where('thread_id', $this->thread_id)->fetch();

                if (count($deleteSolution)) {
                    foreach ($deleteSolution as $value) {
                        $value->delete();
                    }
                }
            }
        }

        return $parent;
    }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        $threadQuestion = $this;

        if ($threadQuestion->solution_user_id) {

            $deleteSolution = \XF::finder('FS\ThreadScoringSystem:ScoringSystem')->where('points_type', 'solution')->where('thread_id', $threadQuestion->thread_id)->fetch();

            if (count($deleteSolution)) {
                foreach ($deleteSolution as $value) {
                    $value->delete();
                }
            }
        }

        return $parent;
    }
}
