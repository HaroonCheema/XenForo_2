<?php

namespace FS\UserCarDetails\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class UserCarDetail extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\UserCarDetails:UserCarDetail')->order('updated_at', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'cars' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
        ];

        return $this->view('FS\UserCarDetails:UserCarDetail\Index', 'fs_user_car_detail_index', $viewParams);
    }

    public function actionAdd()
    {
        $newCar = $this->em()->create('FS\UserCarDetails:UserCarDetail');
        return $this->carAddEdit($newCar);
    }

    public function actionEdit(ParameterBag $params)
    {
        /**
    
         * @var \FS\UserCarDetails\Entity\UserCarDetail $carDetail
         */
        $carDetail = $this->assertDataExists($params->car_id);
        return $this->carAddEdit($carDetail);
    }

    protected function carAddEdit(\FS\UserCarDetails\Entity\UserCarDetail $carDetail)
    {
        $viewParams = [
            'car' => $carDetail
        ];

        return $this->view('FS\UserCarDetails:UserCarDetail\Add', 'fs_user_car_detail_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        $username = $this->filter('username', 'str');

        if ($params->car_id) {
            $carEditAdd = $this->assertDataExists($params->car_id);
        } else {
            $carEditAdd = $this->em()->create('FS\UserCarDetails:UserCarDetail');
        }

        if ($username) {
            $getUserExist = $this->finder('FS\UserCarDetails:UserCarDetail')->where('username', $username)->fetchOne();

            if ($getUserExist) {
                $carEditAdd = $getUserExist;
            }
        }

        $this->carSaveProcess($carEditAdd)->run();

        return $this->redirect($this->buildLink('car-details'));
    }

    protected function carSaveProcess(\FS\UserCarDetails\Entity\UserCarDetail $carDetail)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();

        $form->basicEntitySave($carDetail, $input);

        return $form;
    }

    protected function filterInputs()
    {

        $input = $this->filter([
            'username' => 'str',
            'model_id' => 'int',
            'car_colour' => 'str',
            'car_trim' => 'str',
            'location_id' => 'int',
            'car_plaque_number' => 'str',
            'car_reg_number' => 'str',
            'car_forum_name' => 'str',
            'car_unique_information' => 'str',
        ]);

        if ($this->filter('car_reg_date', 'str')) {
            $input['car_reg_date'] = strtotime(\xf::app()->request()->filter('car_reg_date', 'str'));
        } else {
            $input['car_reg_date'] = 0;
        }

        $input['updated_at'] = time();

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->car_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('car-details/delete', $replyExists),
            null,
            $this->buildLink('car-details'),
            "Car Detail"
        );
    }

    public function actionUniqueInfo(ParameterBag $params)
    {
        $car_unique_information = $this->filter('car_unique_information', 'str');

        $viewParams = [
            'car_unique_information' => $car_unique_information,
        ];

        return $this->view('FS\UserCarDetails:UserCarDetail\UniqueInfo', 'fs_user_car_detail_unique_information', $viewParams);
    }

    // plugin for check car_id exists or not 

    /**
     * @param string $car_id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\UserCarDetails\Entity\UserCarDetail
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\UserCarDetails:UserCarDetail', $id, $extraWith, $phraseKey);
    }
}
