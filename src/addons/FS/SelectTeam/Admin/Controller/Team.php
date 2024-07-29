<?php

namespace FS\SelectTeam\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Team extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\SelectTeam:Team')->order('id', 'DESC');

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

        return $this->view('FS\SelectTeam:Team\Index', 'fs_team_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\SelectTeam:Team');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\SelectTeam\Entity\Team $data */
        $data = $this->assertDataExists($params->id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\SelectTeam\Entity\Team $data)
    {

        $viewParams = [
            'data' => $data,
        ];

        return $this->view('FS\SelectTeam:Team\Add', 'fs_team_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $dataEditAdd = $this->assertDataExists($params->id);
        } else {
            $dataEditAdd = $this->em()->create('FS\SelectTeam:Team');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        $this->saveImage($dataEditAdd);

        return $this->redirect($this->buildLink('team'));
    }

    protected function dataSaveProcess(\FS\SelectTeam\Entity\Team $data)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function saveImage($team)
    {
        $uploads['image'] = $this->request->getFile('image', false, false);

        if ($uploads['image']) {
            $uploadService = $this->service('FS\SelectTeam:Upload', $team);

            if (!$uploadService->setImageFromUpload($uploads['image'])) {
                return $this->error($uploadService->getError());
            }

            if (!$uploadService->uploadImage()) {
                return $this->error(\XF::phrase('new_image_could_not_be_processed'));
            }
        }
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'title' => 'str',
        ]);

        if ($input['title'] == '') {
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
            $this->buildLink('team/delete', $replyExists),
            null,
            $this->buildLink('team'),
            "{$replyExists->title}"
        );
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
        return $this->assertRecordExists('FS\SelectTeam:Team', $id, $extraWith, $phraseKey);
    }
}
