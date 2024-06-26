<?php

namespace FS\SearchOwnThread\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class SearchOwnThread extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\SearchOwnThread:SearchOwnThread')->order('id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'totalReturn' => count($finder->fetch()),
        ];

        return $this->view('FS\SearchOwnThread:SearchOwnThread\Index', 'fs_search_own_thread_index', $viewParams);
    }

    // public function actionAdd1()
    // {
    //     $input = $this->convertShortSearchInputNames();

    //     $searcher = $this->app->search();
    //     $type = $input['search_type'] ?: $this->filter('type', 'str');

    //     $viewParams = [
    //         'tabs' => $searcher->getSearchTypeTabs(),
    //         'type' => $type,
    //         'isRelevanceSupported' => $searcher->isRelevanceSupported(),
    //         'input' => $input
    //     ];

    //     $typeHandler = null;
    //     if ($type && $searcher->isValidContentType($type)) {
    //         $typeHandler = $searcher->handler($type);
    //         if (!$typeHandler->getSearchFormTab()) {
    //             $typeHandler = null;
    //         }
    //     }

    //     if ($typeHandler) {
    //         if ($sectionContext = $typeHandler->getSectionContext()) {
    //             $this->setSectionContext($sectionContext);
    //         }

    //         $viewParams = array_merge($viewParams, $typeHandler->getSearchFormData());
    //     }

    //     return $this->view('XF:Search\Form', 'fs_search_form_add', $viewParams);
    // }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\SearchOwnThread:SearchOwnThread');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\SearchOwnThread\Entity\SearchOwnThread $data */
        $data = $this->assertDataExists($params->id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\SearchOwnThread\Entity\SearchOwnThread $data)
    {

        $input = $this->convertShortSearchInputNames();

        $searcher = $this->app->search();
        $type = $input['search_type'] ?: $this->filter('type', 'str');

        $viewParams = [
            'tabs' => $searcher->getSearchTypeTabs(),
            'type' => $type,
            'isRelevanceSupported' => $searcher->isRelevanceSupported(),
            'input' => $input,
            'data' => $data,
        ];

        $typeHandler = null;
        if ($type && $searcher->isValidContentType($type)) {
            $typeHandler = $searcher->handler($type);
            if (!$typeHandler->getSearchFormTab()) {
                $typeHandler = null;
            }
        }

        if ($typeHandler) {
            if ($sectionContext = $typeHandler->getSectionContext()) {
                $this->setSectionContext($sectionContext);
            }

            $viewParams = array_merge($viewParams, $typeHandler->getSearchFormData());
        }

        return $this->view('FS\SearchOwnThread:SearchOwnThread\AddEdit', 'fs_search_form_add', $viewParams);
    }

    protected function convertShortSearchInputNames()
    {

        $input = $this->filter([
            't' => 'str',
            'q' => 'str',
            'c' => 'array',
            'g' => 'bool',
            'o' => 'str'
        ]);

        return [
            'search_type' => "post",
            'keywords' => '',
            'c' => $input['c'],
            'grouped' => $input['g'] ? 1 : 0,
            'order' => $input['o'] ?: null
        ];
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $dataEditAdd = $this->assertDataExists($params->id);
        } else {
            $dataEditAdd = $this->em()->create('FS\SearchOwnThread:SearchOwnThread');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        return $this->redirect($this->buildLink('search-own-thread'));
    }

    protected function dataSaveProcess(\FS\SearchOwnThread\Entity\SearchOwnThread $data)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'title' => 'str',
            'description' => 'str',
            'url_portion' => 'str',
            'newer_than' => 'str',
            'older_than' => 'str',
            'min_reply_count' => 'int',
            'prefixes' => 'array',
            'nodes' => 'array',
            'order' => 'str',
            'display_order' => 'int',
        ]);

        if ($input['title'] == '' || empty($input['nodes']) || $input['order'] == '') {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('search-own-thread/delete', $replyExists),
            null,
            $this->buildLink('search-own-thread'),
            "{$replyExists->title}"
        );
    }


    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\SearchOwnThread\Entity\SearchOwnThread
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SearchOwnThread:SearchOwnThread', $id, $extraWith, $phraseKey);
    }
}
