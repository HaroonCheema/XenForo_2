<?php

namespace FS\UserGroupBatch\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Batch extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\UserGroupBatch:Batch')->order('batch_id', 'DESC');

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

        return $this->view('FS\UserGroupBatch:Batch\Index', 'fs_usergroup_batch_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\UserGroupBatch:Batch');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\UserGroupBatch\Entity\Batch $data */
        $data = $this->assertDataExists($params->batch_id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\UserGroupBatch\Entity\Batch $data)
    {

        $viewParams = [
            'data' => $data,
            'userGroups' => $this->getUserGroupRepo()->findUserGroupsForList()->fetch(),
        ];

        return $this->view('FS\UserGroupBatch:Batch\Add', 'fs_usergroup_batch_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->batch_id) {
            $dataEditAdd = $this->assertDataExists($params->batch_id);
        } else {
            $dataEditAdd = $this->em()->create('FS\UserGroupBatch:Batch');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        return $this->redirect($this->buildLink('batch'));
    }

    protected function dataSaveProcess(\FS\UserGroupBatch\Entity\Batch $data)
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
            'desc' => 'str',
            'img_path' => 'str',
            'type_repeat' => 'int',
            'mini_post' => 'int',
            'usergroup_ids' => 'array',
        ]);

        if ($input['title'] == '' || $input['img_path'] == '' || count($input['usergroup_ids']) <= 0) {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->batch_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('batch/delete', $replyExists),
            null,
            $this->buildLink('batch'),
            "{$replyExists->title}"
        );
    }

    /**
     * @return \XF\Repository\UserGroup
     */
    protected function getUserGroupRepo()
    {
        return $this->repository('XF:UserGroup');
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\UpgradeUserGroup\Entity\UpgradeUserGroup
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\UserGroupBatch:Batch', $id, $extraWith, $phraseKey);
    }
}
