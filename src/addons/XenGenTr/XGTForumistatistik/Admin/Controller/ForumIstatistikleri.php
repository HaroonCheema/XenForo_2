<?php

namespace XenGenTr\XGTForumistatistik\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;
use \XF\Admin\Controller\AbstractController;

class ForumIstatistikleri extends AbstractController
{

    protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('xgtForumIstatistik_yonet');
	}

    public function actionIndex()
    {
        $forumIstatistikleri = $this->getForumIstatistikRepo()->findForumIstatistikleriForList()->fetch();

        $forumIstatistikPozisyonlar = $forumIstatistikleri->groupBy('pozinyon');

        $forumIstatistikPozisyonlarOrdered = [];

        foreach (array_keys(\XenGenTr\XGTForumistatistik\Entity\ForumIstatistik::pozisyonlar()) as $forumIstatistikPozinyon)
        {
            if (isset($forumIstatistikPozisyonlar[$forumIstatistikPozinyon]))
            {
                $forumIstatistikPozisyonlarOrdered[$forumIstatistikPozinyon] = $forumIstatistikPozisyonlar[$forumIstatistikPozinyon];
            }
        }

        $forumIstatistikPozisyonlar = $forumIstatistikPozisyonlarOrdered;

        $viewParams = [
            'forumIstatistikPozisyonlar' => $forumIstatistikPozisyonlar
        ];

        return $this->view('', 'xgt_istatistik_icerik_listesi', $viewParams);
    }

    protected function forumIstatistikEkleDuzenle(\XenGenTr\XGTForumistatistik\Entity\ForumIstatistik $forumIstatistik)
    {
        $viewParams = [
            'forumIstatistik'       => $forumIstatistik,
            'handler'               => $forumIstatistik->handler,
            'forumIstatistikIcerik' => $forumIstatistik->ForumIstatistikIcerik,
        ];
        return $this->view('', 'xgt_istatistik_icerik_duzenle', $viewParams);
    }

    public function actionDuzenle(ParameterBag $params)
    {
        $forumIstatistik = $this->assertForumIstatistikExists($params->veri_id);
        return $this->forumIstatistikEkleDuzenle($forumIstatistik);
    }

    public function actionEkle()
    {
        $icerikId = $this->filter('type', 'str');

        if (!$icerikId)
        {
            if (!$this->isPost())
            {
                $forumIstatistikIcerikler = $this->finder('XenGenTr\XGTForumistatistik:ForumIstatistikIcerik')->fetch()
                ->pluckNamed('title', 'icerik_id');

                uasort($forumIstatistikIcerikler, function($a, $b)
                {
                    $a = strval($a);
                    $b = strval($b);

                    if ($a == $b)
                    {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });

                $viewParams = [
                    'forumIstatistikIcerikler' => $forumIstatistikIcerikler,
                ];

                return $this->view('', 'xgt_istatistik_icerik_sec', $viewParams);
            }
        }

        if ($this->isPost())
        {
            if ($icerikId)
            {
                return $this->redirect($this->buildLink('forum-istatistik/liste/ekle', [], ['type' => $icerikId]), '');
            }
            else
            {
                return $this->error(\XF::phrase('xgt_forumistatik_icerik_turunu_secmelisiniz'));
            }
        }

        $forumIstatistik = $this->em()->create('XenGenTr\XGTForumistatistik:ForumIstatistik');
        $forumIstatistik->icerik_id = $icerikId;

        return $this->forumIstatistikEkleDuzenle($forumIstatistik);
    }

    protected function forumIstatistikSaveProcess(\XenGenTr\XGTForumistatistik\Entity\ForumIstatistik $forumIstatistik)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'icerik_id' => 'str',
            'pozinyon'      => 'str',
            'display_order' => 'uint',
            'active'        => 'bool',
            'custom_title'  => 'str',
			'veri_ikonu'    => 'str',
        ]);

        $form->validate(function(FormAction $form) use ($forumIstatistik)
        {
            $options = $this->filter('options', 'array');
            $request = new \XF\Http\Request($this->app->inputFilterer(), $options, [], []);
            $handler = $forumIstatistik->getHandler();
            if ($handler && !$handler->verifyOptions($request, $options, $error))
            {
                $form->logError($error);
            }
            $forumIstatistik->options = $options;
        });

        $form->basicEntitySave($forumIstatistik, $input);

        return $form;
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->veri_id)
        {
            $forumIstatistik = $this->assertForumIstatistikExists($params->veri_id);
        }
        else
        {
            $forumIstatistik = $this->em()->create('XenGenTr\XGTForumistatistik:ForumIstatistik');
        }

        $this->forumIstatistikSaveProcess($forumIstatistik)->run();

        return $this->redirect($this->buildLink('forum-istatistik/liste') . $this->buildLinkHash($forumIstatistik->veri_id));
    }

    public function actionSil(ParameterBag $params)
    {
        $forumIstatistik = $this->assertforumIstatistikExists($params->veri_id);

        if ($this->isPost())
        {
            $forumIstatistik->delete();
            return $this->redirect($this->buildLink('forum-istatistik/liste'));
        }
        else
        {
            $viewParams = [
                'forumIstatistik' => $forumIstatistik
            ];
            return $this->view('', 'xgt_istatistik_icerik_sil', $viewParams);
        }
    }

    public function actionToggle()
    {
        $plugin = $this->plugin('XF:Toggle');

        return $plugin->actionToggle('XenGenTr\XGTForumistatistik:ForumIstatistik');
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