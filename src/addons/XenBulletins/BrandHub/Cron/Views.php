<?php

namespace XenBulletins\BrandHub\Cron;

class Views
{
	public static function runViewUpdate()
	{
		$app = \XF::app();

		/** @var \XenBulletins\BrandHub\Repository\Item $itemRepo */
		$itemRepo = $app->repository('XenBulletins\BrandHub:Item');
		$itemRepo->batchUpdateItemViews();
                
                /** @var \XenBulletins\BrandHub\Repository\Brand $brandRepo */
		$brandRepo = $app->repository('XenBulletins\BrandHub:Brand');
		$brandRepo->batchUpdateBrandViews();
	}
}