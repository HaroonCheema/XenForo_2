<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Widget;

class FTSliders extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
		'limit' => 5,
		'trim' => 200,
	];

	public function render()
	{
		/*** Limit User ***/
		// $visitor = \XF::visitor();
		// if (!$visitor->hasPermission('FTSlider_permissions', 'FTSlider_view')) {
		// 	return '';
		// }

		/*** Limit View ***/
		$options = $this->options;

		// $isAddonEnabledGlobally = \XF::options()->offsetGet('FTSlider_enable');

		// if (!$isAddonEnabledGlobally) {
		// 	return false;
		// }

		$limit = $options['limit'];
		$limit = \XF::options()->FTSlider_count;

		/** @var \XDinc\FTSlider\Repository */
		// $ftsliderRepo = $this->app->repository('XDinc\FTSlider:FTSlider');

		// $entries = $ftsliderRepo->findFTSlider()->limit(max($limit * 2, 10))
		// 	->where('Thread.discussion_state', 'visible');
		// //	var_dump($entries->fetch());exit;
		// if (!$ftsliders = $entries->fetch()) {
		// 	return false;
		// }

		// $ftsliders = $ftsliders->slice(0, $limit, true);

		// $auctions = \XF::finder('FS\AuctionPlugin:AuctionListing')->where('is_featured', true)->order('auction_id', 'desc')->fetch();
		$auctions = \XF::finder('FS\AuctionPlugin:AuctionListing')->order('auction_id', 'desc')->fetch();

		$viewParams = [
			'ftsliders' => count($auctions) ? $auctions : [],
		];

		// $viewParams = [
		// 	'ftsliders' => $ftsliderRepo->parseFTSliders($ftsliders, $options['trim']),
		// ];

		return $this->renderer('FTSlider_widget_block', $viewParams);
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'limit' => 'uint',
			'trim' => 'uint',
		]);

		if ($options['limit'] < 1) {
			$options['limit'] = 1;
		}

		return true;
	}
}
