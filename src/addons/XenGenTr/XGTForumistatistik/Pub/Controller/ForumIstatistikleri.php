<?php

namespace XenGenTr\XGTForumistatistik\Pub\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use \XF\Pub\Controller\AbstractController;

class ForumIstatistikleri extends AbstractController
{
    public function actionSonuclar(ParameterBag $params)
    {
        if (!$this->request->isXhr())
        {
            return $this->redirect($this->buildLink('index'));
        }

		if (!\XF::visitor()->canIstatistikleriGor())
		{
			return $this->noPermission();
		}

        $forumIstatistik = $this->assertForumIstatistikExists($params->veri_id);

        if (!$forumIstatistik->active)
        {
            return $this->error(\XF::phrase('unexpected_error_occurred'));
        }

        $viewParams = [
            'forumIstatistik' => $forumIstatistik,
        ];

        return $this->view('', 'xgt_FrmIstatistik_icerikSonuc', $viewParams);
    }

    protected function assertForumIstatistikExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('XenGenTr\XGTForumistatistik:ForumIstatistik', $id, $with, $phraseKey);
    }

    protected function getForumIstatistikRepo()
    {
        return $this->repository('XenGenTr\XGTForumistatistik:ForumIstatistik');
    }
}