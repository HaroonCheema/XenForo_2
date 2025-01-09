<?php

namespace FS\UserCarDetails\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class CarDetails extends AbstractController
{
    public function preDispatchController($action, ParameterBag $params)
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id) {
            throw $this->exception($this->noPermission());
        }
    }

    public function actionIndex(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        $models = $this->finder('FS\UserCarDetails:Model')->fetch();

        $viewpParams = [
            'pageSelected' => 'carDetails/',

            'user' => $visitor,
            'models' => $models,
        ];

        return $this->view('FS\SelectTeam:Index', 'fs_vis_car_details_index', $viewpParams);
    }

    public function actionSave()
    {
        $user = \XF::visitor();

        $carDetailsServ = $this->service('FS\UserCarDetails:AddEditCarDetails');
        $carDetailsServ->filterInputs($user);

        return $this->redirect($this->buildLink('car-details/'));
    }
}
