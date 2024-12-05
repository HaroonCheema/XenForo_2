<?php

namespace FS\ExtendThreadCredits\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class ThreadCreditsLog extends AbstractController
{

    public function preDispatchController($action, ParameterBag $params)
    {
        $visitor = \xf::visitor();

        if (!$visitor->user_id) {
            throw $this->noPermission();
        }
    }

    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->Finder('ThemeHouse\ThreadCredits:ThreadPayment');

        if ($this->filter('search', 'uint')) {
            $finder = $this->applySearchFilter();

            // if (count($finder->getConditions()) == 0) {
            //     return $this->error(\XF::phrase('please_complete_required_field'));
            // }
        } else {
            $finder->order('thread_payment_id', 'DESC');
        }

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'pageSelected' => 'thread-credits-log/',

            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'totalReturn' => count($finder->fetch()),

            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('FS\ExtendThreadCredits:Index', 'fs_extend_thread_credits_log', $viewParams);
    }

    public function actionRefineSearch()
    {

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('CRUD\XF:Crud\RefineSearch', 'fs_extend_thread_order_by__filter', $viewParams);
    }

    protected function applySearchFilter()
    {
        $conditions = $this->filterSearchConditions();

        $finder = $this->Finder('ThemeHouse\ThreadCredits:ThreadPayment');

        if ($conditions['order'] == 'purchased_at') {

            $finder->order('purchased_at', $conditions['direction']);
        } elseif ($conditions['order'] == 'credits_spent') {

            $finder->order('thread_payment_id', $conditions['direction']);
        } elseif ($conditions['order'] == 'thread_title') {

            $tempThreadIds = \xf::finder('ThemeHouse\ThreadCredits:ThreadPayment')->pluckfrom('thread_id')->fetch()->toArray();

            $threadFinder = \xf::finder('XF:Thread')->where("thread_id", $tempThreadIds)->order('title', $conditions['direction']);
            $threadIds = $threadFinder->pluckfrom('thread_id')->fetch()->toArray();

            $quoteThreadIds = \XF::db()->quote($threadIds);

            $setOrderFilter = \XF::finder('ThemeHouse\ThreadCredits:ThreadPayment');

            $finder = $setOrderFilter->where("thread_id", $threadIds)->order($setOrderFilter->expression('FIELD(thread_id, ' . $quoteThreadIds . ')'));
        }

        return $finder;
    }

    protected function filterSearchConditions()
    {
        $filters = $this->filter([
            'order' => 'str',
            'direction' => 'str',
        ]);

        if ($this->filter('search', 'uint')) {
            $filters['search'] = true;
        }

        return $filters;
    }
}
