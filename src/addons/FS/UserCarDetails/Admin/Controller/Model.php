<?php

namespace FS\UserCarDetails\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Model extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\UserCarDetails:Model')->order('model_id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'models' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
        ];

        return $this->view('FS\UserCarDetails:Model\Index', 'fs_user_car_model_index', $viewParams);
    }

    public function actionAdd()
    {
        $newModel = $this->em()->create('FS\UserCarDetails:Model');
        return $this->modelAddEdit($newModel);
    }

    public function actionEdit(ParameterBag $params)
    {
        /**
     
         * @var \FS\UserCarDetails\Entity\Model $carModel
         */
        $carModel = $this->assertDataExists($params->model_id);
        return $this->modelAddEdit($carModel);
    }

    protected function modelAddEdit(\FS\UserCarDetails\Entity\Model $carModel)
    {
        $viewParams = [
            'model' => $carModel
        ];

        return $this->view('FS\UserCarDetails:Model\Add', 'fs_user_car_model_add', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->model_id) {
            $modelEditAdd = $this->assertDataExists($params->model_id);
        } else {
            $modelEditAdd = $this->em()->create('FS\UserCarDetails:Model');
        }

        $this->modelSaveProcess($modelEditAdd)->run();

        return $this->redirect($this->buildLink('car-model'));
    }

    protected function modelSaveProcess(\FS\UserCarDetails\Entity\Model $carModel)
    {
        $input = $this->filter([
            'model' => 'str',
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($carModel, $input);

        return $form;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->model_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('car-model/delete', $replyExists),
            null,
            $this->buildLink('car-model'),
            "{$replyExists->model}"
        );
    }

    // plugin for check model_id exists or not 

    /**
     * @param string $model_id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\UserCarDetails\Entity\Model
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\UserCarDetails:Model', $id, $extraWith, $phraseKey);
    }
}
