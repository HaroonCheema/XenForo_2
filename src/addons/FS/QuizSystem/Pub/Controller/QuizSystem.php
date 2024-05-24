<?php

namespace FS\QuizSystem\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class QuizSystem extends AbstractController
{

    public function actionIndex(ParameterBag $params)
    {
        $page = 0;
        $perPage = 0;
        $categories = $this->finder('FS\QuizSystem:Category');
        $categoryTree = $this->createCategoryTree($categories->fetch());

        $finder = $this->finder('FS\QuizSystem:Quiz');

        if ($this->filter('search', 'uint')) {
            $finder = $this->getSearchFinder($finder);

            if (count($finder->getConditions()) == 0) {
                return $this->error(\XF::phrase('fs_quiz_please_complete_required_field'));
            }
        } else if ($params->category_id) {

            $finder->where('category_id', $params->category_id);
        } else {

            $perPage = 15;

            $page = $params->page;

            $finder->limitByPage($page, $perPage);
            $finder->order('quiz_id', 'DESC');
        }


        $viewParams = [
            'categories' => $categories,
            'categoryTree' => $categoryTree,

            'listings' => $finder->fetch(),


            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'totalReturn' => count($finder->fetch()),

            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('FS\QuizSystem:QuizSystem', 'fs_quiz_landing', $viewParams);
    }

    protected function getSearchFinder($finder)
    {
        $conditions = $this->filterSearchConditions();

        if ($conditions['fs_quiz_status'] != 'all') {
            if ($conditions['fs_quiz_status'] == '1') {
                $finder->where('quiz_end_date', '>=', \XF::$time);
            } else {
                $finder->where('quiz_end_date', '<=', \XF::$time);
            }
        }

        if ($conditions['fs_quiz_cat'] != '0') {
            $finder->where('category_id', $conditions['fs_quiz_cat']);
        }

        return $finder;
    }

    protected function filterSearchConditions()
    {
        return $this->filter([
            'fs_quiz_status' => 'str',
            'fs_quiz_cat' => 'str',
        ]);
    }

    public function actionRefineSearch(ParameterBag $params)
    {
        $categories = $this->finder('FS\QuizSystem:Category')->fetch();

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
            'categories' => $categories,
        ];

        return $this->view('FS\QuizSystem:QuizSystem\RefineSearch', 'fs_quiz_search_filter', $viewParams);
    }

    /**
     * @param null $categories
     * @param int $rootId
     *
     * @return \XF\Tree
     */
    public function createCategoryTree($categories = null, $rootId = 0)
    {
        if ($categories === null) {
            $categories = $this->findCategoryList()->fetch();
        }
        return new \XF\Tree($categories, 'parent_category_id', $rootId);
    }
}
