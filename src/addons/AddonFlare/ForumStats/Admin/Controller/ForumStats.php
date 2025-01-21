<?php

namespace AddonFlare\ForumStats\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class ForumStats extends \XF\Admin\Controller\AbstractController
{
    public function actionIndex()
    {
        $forumStats = $this->getForumStatRepo()->findForumStatsForList()->fetch();

        $forumStatPositions = $forumStats->groupBy('position');

        $forumStatPositionsOrdered = [];

        foreach (array_keys(\AddonFlare\ForumStats\Entity\ForumStat::positions()) as $forumStatPosition)
        {
            if (isset($forumStatPositions[$forumStatPosition]))
            {
                $forumStatPositionsOrdered[$forumStatPosition] = $forumStatPositions[$forumStatPosition];
            }
        }

        $forumStatPositions = $forumStatPositionsOrdered;

        $viewParams = [
            'forumStatPositions' => $forumStatPositions
        ];

        return $this->view('', 'af_forumstats_stat_list', $viewParams);
    }

    protected function forumStatAddEdit(\AddonFlare\ForumStats\Entity\ForumStat $forumStat)
    {
        $viewParams = [
            'forumStat'           => $forumStat,
            'handler'             => $forumStat->handler,
            'forumStatDefinition' => $forumStat->ForumStatDefinition,
        ];
        return $this->view('', 'af_forumstats_stat_edit', $viewParams);
    }

    public function actionEdit(ParameterBag $params)
    {
        $forumStat = $this->assertForumStatExists($params->stat_id);
        return $this->forumStatAddEdit($forumStat);
    }

    public function actionAdd()
    {
        $definitionId = $this->filter('type', 'str');

        if (!$definitionId)
        {
            if (!$this->isPost())
            {
                $forumStatDefinitions = $this->finder('AddonFlare\ForumStats:ForumStatDefinition')->fetch()
                ->pluckNamed('title', 'definition_id');

                uasort($forumStatDefinitions, function($a, $b)
                {
                    $a = strval($a);
                    $b = strval($b);

                    if ($a == $b)
                    {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });

                $addOns = \XF::app()->container('addon.cache');

                if (!array_key_exists('XFRM', $addOns))
                {
                    unset($forumStatDefinitions['top_resources']);
                    unset($forumStatDefinitions['new_resources']);
                }

                $viewParams = [
                    'forumStatDefinitions' => $forumStatDefinitions,
                ];

                return $this->view('', 'af_forumstats_definition_chooser', $viewParams);
            }
        }

        if ($this->isPost())
        {
            if ($definitionId)
            {
                return $this->redirect($this->buildLink('forum-stats/add', [], ['type' => $definitionId]), '');
            }
            else
            {
                return $this->error("You must select a valid type to continue");
            }
        }

        $forumStat = $this->em()->create('AddonFlare\ForumStats:ForumStat');
        $forumStat->definition_id = $definitionId;

        return $this->forumStatAddEdit($forumStat);
    }

    protected function forumStatSaveProcess(\AddonFlare\ForumStats\Entity\ForumStat $forumStat)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'definition_id' => 'str',
            'position'      => 'str',
            'display_order' => 'uint',
            'active'        => 'bool',
            'custom_title'  => 'str',
        ]);

        $form->validate(function(FormAction $form) use ($forumStat)
        {
            $options = $this->filter('options', 'array');
            $request = new \XF\Http\Request($this->app->inputFilterer(), $options, [], []);
            $handler = $forumStat->getHandler();
            if ($handler && !$handler->verifyOptions($request, $options, $error))
            {
                $form->logError($error);
            }
            $forumStat->options = $options;
        });

        $form->basicEntitySave($forumStat, $input);

        return $form;
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->stat_id)
        {
            $forumStat = $this->assertForumStatExists($params->stat_id);
        }
        else
        {
            $forumStat = $this->em()->create('AddonFlare\ForumStats:ForumStat');
        }

        $this->forumStatSaveProcess($forumStat)->run();

        return $this->redirect($this->buildLink('forum-stats') . $this->buildLinkHash($forumStat->stat_id));
    }

    public function actionDelete(ParameterBag $params)
    {
        $forumStat = $this->assertforumStatExists($params->stat_id);

        if ($this->isPost())
        {
            $forumStat->delete();
            return $this->redirect($this->buildLink('forum-stats'));
        }
        else
        {
            $viewParams = [
                'forumStat' => $forumStat
            ];
            return $this->view('', 'af_forumstats_stat_delete', $viewParams);
        }
    }

    public function actionToggle()
    {
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('AddonFlare\ForumStats:ForumStat');
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