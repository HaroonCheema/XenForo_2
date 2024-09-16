<?php
/** 
* @package [AddonsLab] Thread Filter
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 3.8.0
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/


namespace AL\ThreadFilter\XF\Pub\Controller;

use AL\FilterFramework\FilterApp;
use AL\FilterFramework\RootFinder;
use AL\FilterFramework\Service\TotalCountCalculator;
use AL\ThreadFilter\App;
use AL\ThreadFilter\XF\Entity\User;
use SV\AggregatingForums\Globals;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Exception;
use XF\Mvc\Reply\Redirect;
use XF\Mvc\Reply\View;

class Forum extends XFCP_Forum
{
    protected $facetedCounts = null;

    protected $skip_filter_check = false;

    public function actionLoadSelectionOptions()
    {
        $this->setResponseType('json');

        $page = max(1, $this->filter('page', 'uint'));
        $fieldId = str_replace(App::getContentTypeProvider()->getFilterName() . '[', '', $this->filter('select_name', 'str'));
        $fieldId = trim($fieldId, '[]');
        $search = $this->filter('search', 'str');

        $data = App::getContextProvider()->getFieldOptionSuggestions(
            $page,
            $fieldId,
            $search
        );

        return $this->view('AL\ThreadFilter:OptionList', '', [
            'data' => $data,
        ]);
    }

    public function actionFilters(ParameterBag $params)
    {
        $reply = parent::actionFilters($params);

        if ($reply instanceof View)
        {
            $reply->setParams(App::getContextProvider()->setupViewParams($reply->getParams(), $this), false);
        }

        if (App::getContentTypeProvider()->getTotalCountIndicatorSetting())
        {
            /** @var TotalCountCalculator $service */
            $service = $this->service('AL\FilterFramework:TotalCountCalculator');

            if ($reply instanceof Redirect)
            {
                $totalCount = $service->getTotalCount($reply->getUrl(), 'total_with_sticky');
                $reply->setJsonParam('filterInfo', [
                    'total_with_sticky' => $totalCount,
                    // we put the total key here as well, as JS code common for all products expects it in the reply
                    'total' => $totalCount,
                ]);
            }
            else if ($reply instanceof View)
            {
                $totalCount = $service->getTotalCount($this->request->getReferrer(), 'total_with_sticky');
                $reply->setParam('total_with_sticky', $totalCount);
            }
        }
        return $reply;
    }

    /**
     * @param ParameterBag $params
     * @return View
     * @throws Exception
     * Takes the arguments in filters and creates active filter information to be shown on top of thread lists
     */
    public function actionForum(ParameterBag $params)
    {
        $reply = parent::actionForum($params);

        if ($reply instanceof View)
        {
            // Set an additional param "total_with_sticky" as we use that param to show the total
            // number matching the filters
            $stickyThreads = $reply->getParam('stickyThreads');
            $total_with_sticky = $reply->getParam('total');

            if ($stickyThreads)
            {
                $total_with_sticky += $stickyThreads->count();
            }

            $reply->setParam('total_with_sticky', $total_with_sticky);

            $reply->setParams(
                $viewParams = App::getContextProvider()->setupViewParams(
                    $reply->getParams(),
                    $this,
                    $this->facetedCounts
                )
            );


            // XenForo 2.x requires also thread types sort options in the array
            // Calling the filter action itself will get the variables required
            // and make them available to this template
            // This approach is the safest way to ensure all extending add-ons
            // will have their filters shown in the sidebar the same way as in the popup
            if (\XF::$versionId > 2020000)
            {
                $this->skip_filter_check = true;
                $filterReply = $this->actionFilters($params);
                if ($filterReply instanceof View)
                {
                    $reply->setParams($reply->getParams() + $filterReply->getParams(), false);
                }
                $this->skip_filter_check = false;
            }
        }

        return $reply;
    }

    public function filter($key, $type = null, $default = null)
    {
        if ($key === 'apply' && $this->skip_filter_check)
        {
            return false;
        }
        return parent::filter($key, $type, $default);
    }


    protected function getForumFilterInput(\XF\Entity\Forum $forum)
    {
        $filters = parent::getForumFilterInput($forum);

        /** @var User $user */
        $user = \XF::visitor();
        if(!$user->canUseThreadFilter($forum))
        {
            return $filters;
        }

        $lockedStatus = $this->filter('is_locked', 'int');
        if (in_array($lockedStatus, [-1, 1], true))
        {
            $filters['is_locked'] = $lockedStatus;
        }

        $filterName = App::getContentTypeProvider()->getFilterName();

        $filters[$filterName] = $this->filter($filterName, 'array');

        if (empty($filters[$filterName]))
        {
            unset($filters[$filterName]);
        }
        else
        {
            FilterApp::getInputTransformer(App::getContentTypeProvider())->normalizeInput($filters[$filterName]);
        }


        return $filters;
    }

    protected function applyForumFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
    {
        RootFinder::setRootFinder($threadFinder);

        $fieldCache = App::getContentTypeProvider()->getFieldCacheForCategory($forum);

        $sortOptions = App::getContextProvider()->getSortOptions($fieldCache);

        if (isset($filters['order']) && isset($sortOptions[$filters['order']]))
        {
            $fieldId = str_replace(App::getContentTypeProvider()->getFilterName() . '_', '', $filters['order']);
            $indexRelationName = "CustomFieldIndex|$fieldId";
            $threadFinder->with($indexRelationName, true);
        }

        parent::applyForumFilters($forum, $threadFinder, $filters);

        $nodes = [$forum->node_id];

        if (
            class_exists(Globals::class)
            && Globals::$forumParent
            && Globals::$forums
            && Globals::$forumParent->node_id === $forum->node_id
        )
        {
            $nodes = array_merge($nodes, Globals::$forums->keys());
        }

        App::getContextProvider()->applyCategoryFilters(
            $threadFinder,
            $filters,
            $nodes,
            App::getContentTypeProvider()->getFieldCacheForCategory($forum)
        );
        if (!empty($filters['is_locked']))
        {
            $threadFinder->where('discussion_open', $filters['is_locked'] === 1 ? 0 : 1);
        }
    }

    protected function applyDateLimitFilters(\XF\Entity\Forum $forum, \XF\Finder\Thread $threadFinder, array $filters)
    {
        parent::applyDateLimitFilters($forum, $threadFinder, $filters);

        App::getContextProvider()->executeFacetedSearch(
            $threadFinder,
            App::getContentTypeProvider()->getFieldCacheForCategory($forum)
        );
    }


    protected function getAvailableForumSorts(\XF\Entity\Forum $forum)
    {
        $sorts = parent::getAvailableForumSorts($forum);

        $fieldCache = App::getContentTypeProvider()->getFieldCacheForCategory($forum);

        /** @var User $user */
        $user = \XF::visitor();
        if  (!$user->canUseThreadFilter($forum))
        {
            return $sorts;
        }

        $sorts += App::getContextProvider()->getSortOptions($fieldCache);

        return $sorts;
    }
}
