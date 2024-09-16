<?php

namespace SV\MultiPrefix\XFRM\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use SV\MultiPrefix\Listener;

class Category extends XFCP_Category
{
    /**
     * @param \SV\MultiPrefix\XFRM\Entity\Category $category
     * @return \SV\MultiPrefix\XFRM\Service\ResourceItem\Create|\XFRM\Service\ResourceItem\Create
     */
    protected function setupResourceCreate(\XFRM\Entity\Category $category)
    {
        /** @var \SV\MultiPrefix\XFRM\Service\ResourceItem\Create $creator */
        $creator = parent::setupResourceCreate($category);
        Listener::$draftEntity = $resource = $creator->getResource();
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $resource->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$category->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Message
     */
    public function actionDraft(ParameterBag $params)
    {
        try
        {
            return parent::actionDraft($params);
        }
        finally
        {
            Listener::$draftEntity = null;
        }
    }

    /**
     * @param ParameterBag $params
     *
     * @return View
     */
    public function actionAdd(ParameterBag $params)
    {
        $response = parent::actionAdd($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XFRM\Entity\Category $category */
            $category = $response->getParam('category');
            /** @var \SV\MultiPrefix\XFRM\Entity\ResourceItem $resource */
            $resource = $response->getParam('resource');
            if ($resource && !$category)
            {
                $category = $resource->Category;
            }

            if ($resource && $category)
            {
                $draft = $category->draft_resource;
                $resource->sv_prefix_ids = $draft->sv_prefix_ids ?? [];

                if (empty($resource->sv_prefix_ids))
                {
                    $prefixId = $resource->prefix_id;
                    if ($prefixId)
                    {
                        $resource->sv_prefix_ids = [$prefixId];
                    }
                }
            }
        }

        return $response;
    }
}