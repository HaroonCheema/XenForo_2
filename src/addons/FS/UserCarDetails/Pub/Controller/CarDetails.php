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

        $models = $this->Finder('FS\UserCarDetails:Model')->fetch();

        $viewpParams = [
            'pageSelected' => 'carDetails/',

            'user' => $visitor,
            'models' => $models,
        ];

        return $this->view('FS\SelectTeam:Index', 'fs_vis_car_details_index', $viewpParams);
    }

    public function actionSave()
    {
        $visitor = \XF::visitor();

        $input = $this->filterInputs();

        $visitor->bulkSet($input);

        $visitor->save();

        return $this->redirect($this->buildLink('car-details/'));
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'model_id' => 'int',
            'car_colour' => 'str',
            'car_trim' => 'str',
            'car_location' => 'str',
            'car_plaque_number' => 'str',
            'car_reg_number' => 'str',
            'car_forum_name' => 'str',
            'car_unique_information' => 'str'
        ]);

        if (!$input['model_id'] || $input['car_colour'] == '' || $input['car_trim'] == '' || $input['car_plaque_number'] == '' || $input['car_reg_number'] == '') {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        if ($this->filter('car_reg_date', 'str')) {
            $input['car_reg_date'] = strtotime($this->filter('car_reg_date', 'str'));
        }

        return $input;
    }
}
