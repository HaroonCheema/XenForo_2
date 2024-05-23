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
        $perPage = 15;
        $categories = $this->finder('FS\QuizSystem:Category');
        $categoryTree = $this->createCategoryTree($categories->fetch());

        if ($this->filter('search', 'uint')) {
            $finder = $this->getSearchFinder();


            if (count($finder->getConditions()) == 0) {
                return $this->error(\XF::phrase('please_complete_required_field'));
            }
        } else if ($params->category_id) {
            $finder = $this->finder('FS\AuctionPlugin:AuctionListing');

            $finder->where('category_id', $params->category_id);
        } else {

            // $options = \XF::options();
            // $perPage = 15;

            $page = $params->page;

            $finder = $this->finder('FS\AuctionPlugin:AuctionListing');


            $finder->limitByPage($page, $perPage);
            $finder->order('last_bumping', 'DESC');
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

        return $this->view('FS\AuctionPlugin:AuctionListing', 'fs_quiz_landing', $viewParams);
    }

    protected function getSearchFinder()
    {
        $conditions = $this->filterSearchConditions();

        $node_id = $this->options()->fs_auction_applicable_forum;
        $finder = $this->finder('XF:Thread')->where('node_id', $node_id)->where('auction_end_date', '!=', 0);

        if ($conditions['fs_auction_username'] != '') {

            $User = $this->finder('XF:User')->where('username', $conditions['fs_auction_username'])->fetchOne();
            if ($User) {
                $finder->where('user_id', $User['user_id']);
            }
        }

        if ($conditions['fs_auction_status'] != 'all') {
            if ($conditions['fs_auction_status'] == '1') {
                $finder->where('auction_end_date', '>=', \XF::$time);
            } else {
                $finder->where('auction_end_date', '<=', \XF::$time);
            }
        }

        $threadIds = $finder->pluckfrom('thread_id')->fetch()->toArray();

        $finder = $this->finder('FS\AuctionPlugin:AuctionListing')->where('thread_id', $threadIds);
        if ($conditions['fs_auction_cat'] != '0') {
            $finder->where('category_id', $conditions['fs_auction_cat']);
        }

        return $finder;
    }

    protected function filterSearchConditions()
    {
        return $this->filter([
            'fs_auction_username' => 'str',
            'fs_auction_status' => 'str',
            'fs_auction_cat' => 'str',
        ]);
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
