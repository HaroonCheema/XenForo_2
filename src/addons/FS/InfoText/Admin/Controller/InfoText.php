<?php

namespace FS\InfoText\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class InfoText extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\InfoText:InfoText')->order('id', 'DESC');

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

        return $this->view('FS\InfoText:InfoText\Index', 'fs_info_text_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\InfoText:InfoText');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\InfoText\Entity\InfoText $data */
        $data = $this->assertDataExists($params->id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\InfoText\Entity\InfoText $data)
    {

        $viewParams = [
            'data' => $data,
        ];

        return $this->view('FS\InfoText:InfoText\Add', 'fs_info_text_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $dataEditAdd = $this->assertDataExists($params->id);
        } else {
            $dataEditAdd = $this->em()->create('FS\InfoText:InfoText');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        return $this->redirect($this->buildLink('info-text'));
    }

    protected function dataSaveProcess(\FS\InfoText\Entity\InfoText $data)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'word' => 'str',
            'link' => 'str',
            'agency' => 'str',
        ]);

        if ($input['word'] == '' || $input['link'] == '' || $input['agency'] == '') {
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
            $this->buildLink('info-text/delete', $replyExists),
            null,
            $this->buildLink('info-text'),
            "{$replyExists->word}"
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
        return $this->assertRecordExists('FS\InfoText:InfoText', $id, $extraWith, $phraseKey);
    }
}
