<?php

namespace ThemeHouse\Monetize\Admin\Controller;

use XF\Mvc\Entity\Entity;

use XF\Mvc\ParameterBag;

/**
 * Class Keyword
 * @package ThemeHouse\Monetize\Admin\Controller
 */
class Keyword extends AbstractEntityManagement
{
    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($params['keyword_id']) {
            $keyword = $this->assertEntityExits($params['keyword_id']);
            return $this->redirect($this->buildLink('thmonetize-keywords/edit', $keyword));
        }

        /** @var \ThemeHouse\Monetize\Repository\Keyword $keywordRepo */
        $keywordRepo = $this->getEntityRepo();
        $keywordList = $keywordRepo->findKeywordsForList()->fetch();
        $keywords = $keywordList;

        $optionIds = [
            'thmonetize_keywordsLimitPerPage',
            'thmonetize_keywordsLimitPerWord',
            'thmonetize_keywordsExcludedNodes',
            'thmonetize_keywordsExcludedUsergroups',
            'thmonetize_keywordsExcludedContentTypes',
        ];
        $options = $this->em()->findByIds('XF:Option', $optionIds);
        $sortedOptions = [];
        foreach ($optionIds as $optionId) {
            $sortedOptions[$optionId] = $options[$optionId];
        }

        $viewParams = [
            'keywords' => $keywords,
            'totalKeywords' => $keywords->count(),
            'options' => $sortedOptions,
        ];
        return $this->view('ThemeHouse\Monetize:Keyword\Listing', 'thmonetize_keyword_list', $viewParams);
    }

    /**
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionRebuildCache()
    {
        /** @var \ThemeHouse\Monetize\Repository\Keyword $keywordRepo */
        $keywordRepo = $this->getEntityRepo();
        $keywordRepo->rebuildKeywordCache();

        return $this->redirect($this->buildLink('thmonetize-keywords'));
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Keyword|Entity $entity
     * @return \XF\Mvc\Reply\View
     */
    protected function entityAddEdit(Entity $entity)
    {
        $userCriteria = $this->app->criteria('XF:User', $entity->user_criteria);

        $viewParams = [
            'keyword' => $entity,
            'userCriteria' => $userCriteria,
        ];
        return $this->view('ThemeHouse\Monetize:Keyword\Edit', 'thmonetize_keyword_edit', $viewParams);
    }

    /**
     * @param \ThemeHouse\Monetize\Entity\Keyword|Entity $entity
     * @return \XF\Mvc\FormAction
     */
    protected function entitySaveProcess(Entity $entity)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'active' => 'bool',
            'keyword' => 'str',
            'keyword_options' => 'array-bool',
            'replace_type' => 'str',
            'replacement' => 'str',
            'limit' => 'int',
            'user_criteria' => 'array'
        ]);

        $form->basicEntitySave($entity, $input);

        /** @var \ThemeHouse\Monetize\Repository\Keyword $keywordRepo */
        $keywordRepo = $this->getEntityRepo();
        $keywordRepo->rebuildKeywordCache();

        return $form;
    }

    /**
     * @param $action
     * @param ParameterBag $params
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        $this->assertAdminPermission('thMonetize_keywords');
    }

    /**
     * @return string
     */
    protected function getEntityKey()
    {
        return 'ThemeHouse\Monetize:Keyword';
    }

    /**
     * @return string
     */
    protected function getContentIdKey()
    {
        return 'keyword_id';
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return 'thmonetize-keywords';
    }
}
