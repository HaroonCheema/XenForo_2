<?php

namespace FS\GenerateLink\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Navigation extends XFCP_Navigation
{
    public function actionAddForums()
    {
        $navigation = $this->em()->create('XF:Navigation');
        return $this->navigationForumsAddEdit($navigation);
    }

    public function actionEditForums(ParameterBag $params)
    {
        $navigation = $this->assertNavigationExists($params['navigation_id']);
        return $this->navigationForumsAddEdit($navigation);
    }

    protected function navigationForumsAddEdit(\XF\Entity\Navigation $navigation)
    {
        $navRepo = $this->getNavigationRepo();

        $navigation->setOption('user_edit', true);

        $typeHandlers = $navRepo->getTypeHandlers();
        $selectedType = $navigation->navigation_type_id;
        if (!$selectedType || !isset($typeHandlers[$selectedType])) {
            reset($typeHandlers);
            $selectedType = key($typeHandlers);
        }

        $searcher = $this->searcher('XF:Thread');

        $viewParams = [
            'navigation' => $navigation,
            'navigationTree' => $navRepo->createNavigationTree(),
            'selectedType' => $selectedType,
            'typeHandlers' => $typeHandlers
        ] + $searcher->getFormData();

        return $this->view('XF:Navigation\Edit', 'fs_navigation_add_edit', $viewParams);
    }

    public function actionForumsSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        if ($params['navigation_id']) {
            $navigation = $this->assertNavigationExists($params['navigation_id']);
        } else {
            $navigation = $this->em()->create('XF:Navigation');
        }

        $this->navigationForumsSaveProcess($navigation)->run();

        return $this->redirect($this->buildLink('gen-link') . $this->buildLinkHash($navigation->navigation_id));
    }

    public function actionDeleteNav(ParameterBag $params)
    {
        $navigation = $this->assertNavigationExists($params['navigation_id']);

        if (!$navigation->canDelete()) {
            return $this->error(\XF::phrase('item_cannot_be_deleted_associated_with_addon_explain'));
        }

        if (!$navigation->preDelete()) {
            return $this->error($navigation->getErrors());
        }

        if ($this->isPost()) {
            $navigation->delete();

            return $this->redirect($this->buildLink('gen-link'));
        } else {
            $navRepo = $this->getNavigationRepo();

            $navTree = $navRepo->createNavigationTree();
            $children = $navTree->children($navigation->navigation_id);

            $viewParams = [
                'navigation' => $navigation,
                'hasChildren' => count($children) > 0
            ];
            return $this->view('XF:Navigation\Delete', 'fs_navigation_delete', $viewParams);
        }
    }

    protected function navigationForumsSaveProcess(\XF\Entity\Navigation $navigation)
    {
        $navigation->setOption('user_edit', true);

        $form = $this->formAction();

        $input = $this->filter([
            'navigation_id' => 'str',
            'parent_navigation_id' => 'str',
            'display_order' => 'uint',
            'enabled' => 'bool',
            'addon_id' => 'str',
            'forum_ids' => 'array',

        ]);

        $typeId = $this->filter('navigation_type_id', 'str');

        $config = $this->filter('config', 'array');
        if (isset($config[$typeId]) && is_array($config[$typeId])) {
            $typeConfig = $config[$typeId];
        } else {
            $typeConfig = [];
        }

        $pattern = "/\{\{\s*link\('([^']+)'.*?\)\s*\}\}/";

        if (preg_match($pattern, $config['basic']['link'], $matches)) {
            $input['route'] = $matches[1];
        } else {
            $input['route'] = '';
        }

        $form->basicEntitySave($navigation, $input);

        $form->setup(function (FormAction $form) use ($navigation, $typeId, $typeConfig) {
            $navigation->setTypeFromInput($typeId, $typeConfig);
        });

        $phraseInput = $this->filter([
            'title' => 'str'
        ]);
        $form->validate(function (FormAction $form) use ($phraseInput) {
            if ($phraseInput['title'] === '') {
                $form->logError(\XF::phrase('please_enter_valid_title'), 'title');
            }
        });
        $form->apply(function () use ($phraseInput, $navigation) {
            $title = $navigation->getMasterPhrase();
            $title->phrase_text = $phraseInput['title'];
            $title->save();
        });

        return $form;
    }
}
