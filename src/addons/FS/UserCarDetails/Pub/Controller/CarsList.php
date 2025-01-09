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

        $carDetails = $this->finder('XF:User');

        $conditions = $this->filterSearchConditions();

        if (isset($conditions['apply']) && $conditions['apply']) {
            $carDetails = $this->applySearchFilter();

            if (count($carDetails->getConditions()) == 0) {
                return $this->error(\XF::phrase('please_complete_required_field'));
            }
        } else {
            $carDetails->where('model_id', '!=', 0)
                ->order('user_id', 'DESC');
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

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
            'models' => $models,
        ];

        return $this->view('FS\UserCarDetails:CarsList\RefineSearch', 'fs_car_details_list_filter', $viewParams);
    }

    protected function filterSearchConditions()
    {
        $filters = $this->filter([
            'model_id' => 'int',
            'car_location' => 'str',
        ]);

        if ($this->filter('apply', 'uint')) {
            $filters['apply'] = true;
        }

        return $filters;
    }

    protected function applySearchFilter()
    {
        $conditions = $this->filterSearchConditions();

        $carDetails = $this->finder('XF:User');

        if ($conditions['model_id']) {

            $carDetails->where('model_id', $conditions['model_id']);
        } else {
            $carDetails->where('model_id', '!=', 0);
        }


        if (!empty($conditions['car_location'])) {

            $carDetails->where('car_location', 'LIKE', $carDetails->escapeLike($conditions['car_location'], '%?%'));
        }

        return $carDetails;
    }
}
