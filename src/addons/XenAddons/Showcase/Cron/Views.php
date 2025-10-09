<?php

namespace XenAddons\Showcase\Cron;

class Views
{
	public static function runViewUpdate()
	{
		$app = \XF::app();

		/** @var \XenAddons\Showcase\Repository\Item $itemRepo */
		$itemRepo = $app->repository('XenAddons\Showcase:Item');
		$itemRepo->batchUpdateItemViews();
	}
}