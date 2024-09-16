<?php

namespace SV\MultiPrefix\DBTech\Shop\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;
use XF\Mvc\Reply\View;
use SV\MultiPrefix\Listener;

class Item extends XFCP_Item
{
	protected function setupItemCreate(\DBTech\Shop\Entity\Category $category): \DBTech\Shop\Service\Item\Create
	{
		/** @var \SV\MultiPrefix\DBTech\Shop\Service\Item\Create $creator */
		$creator = parent::setupItemCreate($category);
		Listener::$draftEntity = $item = $creator->getItem();
        $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
		
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
	 * @return View
	 * @throws \XF\Mvc\Reply\Exception
	 */
	public function actionAdd(): AbstractReply
	{
		$response = parent::actionAdd();
		
		if ($response instanceof View)
		{
			/** @var \SV\MultiPrefix\DBTech\Shop\Entity\Item $item */
			$item = $response->getParam('item');
			if ($item && $item->prefix_id)
			{
				$item->sv_prefix_ids = [$item->prefix_id];
			}
		}
		
		return $response;
	}
	
    protected function setupItemEdit(\DBTech\Shop\Entity\Item $item): \DBTech\Shop\Service\Item\Edit
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($item), true);
        $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\DBTech\Shop\Service\Item\Edit $editor */
        $editor = parent::setupItemEdit($item);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$item->Category->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }

    protected function setupItemMove(\DBTech\Shop\Entity\Item $item, \DBTech\Shop\Entity\Category $category): \DBTech\Shop\Service\Item\Move
    {
        if (empty(\XF::options()->svStripPrefixOnContainerChange))
        {
            $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
            $item->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
        }

        /** @var \SV\MultiPrefix\DBTech\Shop\Service\Item\Move $mover */
        $mover = parent::setupItemMove($item, $category);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            $mover->setPrefixIds($prefixIds);
        }

        return $mover;
    }
	
    public function actionEdit(ParameterBag $params): AbstractReply
    {
        $response = parent::actionEdit($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\DBTech\Shop\Entity\Item $item */
            $item = $response->getParam('item');

            /** @var \SV\MultiPrefix\DBTech\Shop\Entity\Category $category */
            $category = $response->getParam('category');
            if ($item && !$category)
            {
                $category = $item->Category;
            }

            if ($item && $category)
            {
                $prefixes = $item->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }
	
	/**
	 * @param ParameterBag $params
	 *
	 * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|View
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
    public function actionMove(ParameterBag $params)
    {
        $response = parent::actionMove($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\DBTech\Shop\Entity\Item $item */
            $item = $response->getParam('item');

            /** @var \SV\MultiPrefix\DBTech\Shop\Entity\Category $category */
            $category = $response->getParam('category');
            if ($item && !$category)
            {
                $category = $item->Category;
            }

            if ($item && $category)
            {
                $prefixes = $item->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }
}