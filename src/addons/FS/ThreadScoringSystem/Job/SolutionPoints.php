<?php

namespace FS\ThreadScoringSystem\Job;

use XF\Job\AbstractRebuildJob;

class SolutionPoints extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
        'steps' => 0,
        'start' => 0,
        'batch' => 500,
    ];

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn($db->limit(
            "
				SELECT thread_id
				FROM xf_thread_question
				WHERE thread_id > ?
				ORDER BY thread_id
			",
            $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        /** @var \XF\Entity\ThreadQuestion $threadQuestions */
        $threadQuestion = $this->app->em()->find('XF:ThreadQuestion', $id);
        if (!$threadQuestion  || !$threadQuestion->solution_post_id) {
            return;
        }

        $threadQuestionServ = \XF::service('FS\ThreadScoringSystem:ReplyPoints');
        $threadQuestionServ->addEditSolutionPoints($threadQuestion);
    }

    protected function getStatusType()
    {
        return \XF::phrase('threadsSolution');
    }
}
