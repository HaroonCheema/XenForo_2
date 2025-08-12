<?php

namespace FS\ShowIconInNav\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class NavIcon extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\ShowIconInNav:NavIcon')->order('id', 'DESC');

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

        return $this->view('FS\ShowIconInNav:NavIcon\Index', 'fs_show_nav_icon_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\ShowIconInNav:NavIcon');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\ShowIconInNav\Entity\NavIcon $data */
        $data = $this->assertDataExists($params->id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\ShowIconInNav\Entity\NavIcon $data)
    {

        $viewParams = [
            'data' => $data,
        ];

        return $this->view('FS\ShowIconInNav:NavIcon\Add', 'fs_show_nav_icon_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $dataEditAdd = $this->assertDataExists($params->id);
        } else {
            $dataEditAdd = $this->em()->create('FS\ShowIconInNav:NavIcon');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        $this->saveImage($dataEditAdd);

        return $this->redirect($this->buildLink('nav-icon'));
    }

    protected function dataSaveProcess(\FS\ShowIconInNav\Entity\NavIcon $data)
    {
        $input = $this->filterInputs($data);

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function saveImage($icon)
    {
        $uploads = $this->request->getFile('image', false, false);

        if ($uploads) {
            $uploadService = $this->service('FS\ShowIconInNav:Upload', $icon);

            if (!$uploadService->setImageFromUpload($uploads)) {
                return $this->error($uploadService->getError());
            }

            if (!$uploadService->uploadImage()) {
                return $this->error(\XF::phrase('new_image_could_not_be_processed'));
            }
        }
    }

    public function actionToggle()
    {
        /** @var \XF\ControllerPlugin\Toggle $plugin */
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('FS\ShowIconInNav:NavIcon', 'enabled');
    }

    protected function filterInputs($data)
    {
        $input = $this->filter([
            'fs_icon_url' => 'str',
            'enabled' => 'bool',
        ]);

        if ($input['fs_icon_url'] == '') {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        if (empty($data)) {
            $uploads['image'] = $this->request->getFile('image', false, false);

            if (empty($uploads['image'])) {
                throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
            }
        }

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        if ($this->isPost()) {
            $fs = $this->app()->fs();

            $replyExists->delete();

            $ImgPath = $replyExists->getAbstractedCustomImgPath();

            if ($fs->has($ImgPath)) {
                $fs->delete($ImgPath);
            }

            return $this->redirect($this->buildLink('nav-icon'));
        }

        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('nav-icon/delete', $replyExists),
            null,
            $this->buildLink('nav-icon'),
            "{$replyExists->fs_icon_url}"
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
        return $this->assertRecordExists('FS\ShowIconInNav:NavIcon', $id, $extraWith, $phraseKey);
    }
}
