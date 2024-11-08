<?php

namespace FS\LogoSlider\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Logo extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\LogoSlider:Logo')->order('id', 'DESC');

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

        return $this->view('FS\LogoSlider:Logo\Index', 'fs_logo_slider_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\LogoSlider:Logo');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\LogoSlider\Entity\Logo $data */
        $data = $this->assertDataExists($params->id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\LogoSlider\Entity\Logo $data)
    {

        $viewParams = [
            'data' => $data,
        ];

        return $this->view('FS\LogoSlider:Logo\Add', 'fs_logo_slider_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->id) {
            $dataEditAdd = $this->assertDataExists($params->id);
        } else {
            $dataEditAdd = $this->em()->create('FS\LogoSlider:Logo');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        $this->saveImage($dataEditAdd);

        return $this->redirect($this->buildLink('logo-slider'));
    }

    protected function dataSaveProcess(\FS\LogoSlider\Entity\Logo $data)
    {
        $input = $this->filterInputs($data);

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function saveImage($logo)
    {
        $uploads['image'] = $this->request->getFile('image', false, false);

        if ($uploads['image']) {
            $uploadService = $this->service('FS\LogoSlider:Upload', $logo);

            if (!$uploadService->setImageFromUpload($uploads['image'])) {
                return $this->error($uploadService->getError());
            }

            if (!$uploadService->uploadImage()) {
                return $this->error(\XF::phrase('new_image_could_not_be_processed'));
            }
        }
    }

    protected function filterInputs($data)
    {
        $input = $this->filter([
            'logo_url' => 'str',
        ]);

        if ($input['logo_url'] == '') {
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

            return $this->redirect($this->buildLink('logo-slider'));
        }

        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('logo-slider/delete', $replyExists),
            null,
            $this->buildLink('logo-slider'),
            "{$replyExists->logo_url}"
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
        return $this->assertRecordExists('FS\LogoSlider:Logo', $id, $extraWith, $phraseKey);
    }
}
