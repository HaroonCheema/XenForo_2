<?php

namespace AddonFlare\ForumStats\Pub\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class ForumStats extends \XF\Pub\Controller\AbstractController
{
    public function actionResults(ParameterBag $params)
    {
        if (!$this->request->isXhr())
        {
            return $this->redirect($this->buildLink('index'));
        }

        if (!$this->getForumStatRepo()->canViewStats())
        {
            return $this->noPermission();
        }

        $forumStat = $this->assertForumStatExists($params->stat_id);

        if (!$forumStat->active)
        {
            return $this->error(\XF::phrase('unexpected_error_occurred'));
        }

        $viewParams = [
            'forumStat' => $forumStat,
        ];

        return $this->view('', 'af_forumstats_results', $viewParams);
    }

    protected function assertForumStatExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('AddonFlare\ForumStats:ForumStat', $id, $with, $phraseKey);
    }

    protected function getForumStatRepo()
    {
        return $this->repository('AddonFlare\ForumStats:ForumStat');
    }
}