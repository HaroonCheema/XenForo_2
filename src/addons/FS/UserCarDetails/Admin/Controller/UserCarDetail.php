<?php

namespace FS\UserCarDetails\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class UserCarDetail extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\UserCarDetails:Location')->order('location_id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'locations' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
        ];

        return $this->view('FS\UserCarDetails:Location\Index', 'fs_user_car_location_index', $viewParams);
    }

    public function actionAdd()
    {
        $newLocation = $this->em()->create('FS\UserCarDetails:Location');
        return $this->locationAddEdit($newLocation);
    }

    public function actionEdit(ParameterBag $params)
    {
        /**
    
         * @var \FS\UserCarDetails\Entity\Location $carLocation
         */
        $carLocation = $this->assertDataExists($params->location_id);
        return $this->locationAddEdit($carLocation);
    }

    protected function locationAddEdit(\FS\UserCarDetails\Entity\Location $carLocation)
    {
        $viewParams = [
            'location' => $carLocation
        ];

        return $this->view('FS\UserCarDetails:Location\Add', 'fs_user_car_location_add', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->location_id) {
            $locationEditAdd = $this->assertDataExists($params->location_id);
        } else {
            $locationEditAdd = $this->em()->create('FS\UserCarDetails:Location');
        }

        $this->locationSaveProcess($locationEditAdd)->run();

        return $this->redirect($this->buildLink('car-location'));
    }

    protected function locationSaveProcess(\FS\UserCarDetails\Entity\Location $carLocation)
    {
        $input = $this->filter([
            'location' => 'str',
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($carLocation, $input);

        return $form;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->location_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('car-location/delete', $replyExists),
            null,
            $this->buildLink('car-location'),
            "{$replyExists->location}"
        );
    }

    // plugin for check location_id exists or not 

    /**
     * @param string $location_id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\UserCarDetails\Entity\Location
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\UserCarDetails:Location', $id, $extraWith, $phraseKey);
    }
}
