<?php

namespace FS\UserCarDetails\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class CarsList extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $page = $params->page;
        $perPage = 15;

        $carDetails = $this->finder('FS\UserCarDetails:UserCarDetail');

        $conditions = $this->filterSearchConditions();

        if (isset($conditions['apply']) && $conditions['apply']) {
            $carDetails = $this->applySearchFilter();

            if (count($carDetails->getConditions()) == 0) {
                return $this->error(\XF::phrase('please_complete_required_field'));
            }
        } else {

            $conditions = [
                ['model_id', '!=', 0],
                ['location_id', '!=', 0],
                ['car_colour', '!=', ''],
                ['car_trim', '!=', ''],
                ['car_plaque_number', '!=', ''],
                ['car_reg_number', '!=', ''],
                ['car_reg_date', '!=', 0],
                ['car_forum_name', '!=', ''],
                ['car_unique_information', '!=', '']
            ];

            $carDetails->whereOr($conditions)
                ->order('updated_at', 'DESC');
        }

        $carDetails
            ->limitByPage($page, $perPage);


        $total = $carDetails->total();

        $viewParams = [
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,

            'data' => $carDetails->fetch(),

            'conditions' => $conditions,
        ];

        return $this->view('FS\UserCarDetails:Index', 'fs_car_details_list_index', $viewParams);
    }

    public function actionRefineSearch()
    {
        $models = $this->finder('FS\UserCarDetails:Model')->fetch();
        $locations = $this->finder('FS\UserCarDetails:Location')->fetch();

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
            'models' => $models,
            'locations' => $locations,
        ];

        return $this->view('FS\UserCarDetails:CarsList\RefineSearch', 'fs_car_details_list_filter', $viewParams);
    }

    public function actionUniqueInfo(ParameterBag $params)
    {
        $car_unique_information = $this->filter('car_unique_information', 'str');

        $viewParams = [
            'car_unique_information' => $car_unique_information,
        ];

        return $this->view('FS\UserCarDetails:CarsList\UniqueInfo', 'fs_car_unique_information', $viewParams);
    }

    protected function filterSearchConditions()
    {
        $filters = $this->filter([
            'fs_car_details_username' => 'str',
            'model_id' => 'int',
            'car_location' => 'str',
            'location_id' => 'int',
        ]);

        if ($this->filter('apply', 'uint')) {
            $filters['apply'] = true;
        }

        return $filters;
    }

    protected function applySearchFilter()
    {
        $conditions = $this->filterSearchConditions();

        $carDetails = $this->finder('FS\UserCarDetails:UserCarDetail');

        if ($conditions['model_id']) {

            $carDetails->where('model_id', $conditions['model_id']);
        }

        // else {
        //     $carDetails->where('model_id', '!=', 0);
        // }

        if ($conditions['location_id']) {

            $carDetails->where('location_id', $conditions['location_id']);
        }


        // if (!empty($conditions['car_location'])) {

        //     $carDetails->where('car_location', 'LIKE', $carDetails->escapeLike($conditions['car_location'], '%?%'));
        // } 

        if (!empty($conditions['fs_car_details_username'])) {
            $carDetails->where('username', $conditions['fs_car_details_username']);
        }

        return $carDetails;
    }
}
