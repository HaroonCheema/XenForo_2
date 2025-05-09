<?php

namespace FS\TractorLandingPageApi\Api\Controller;

use XF\Api\Controller\AbstractController;

/**
 * @api-group Stats
 */
class TractorController extends AbstractController
{
	/**
	 * @api-desc Gets site statistics and general activity information
	 *
	 * @api-out int $totals[threads]
	 * @api-out int $totals[messages]
	 * @api-out int $totals[users]
	 *
	 */
	public function actionGet()
	{

		// forum Stats

		$forumStats = $this->app()->forumStatistics;

		// Tractor Database

		$page = 1;
		$perPage = \XF::options()->fs_tractorbynet_database;

		$brands = \XF::app()->Finder('XenBulletins\BrandHub:Brand');

		$brands->limitByPage($page, $perPage);

		$defaultOrder = \XF::options()->bh_brandListDefaultOrder;
		$defaultDir =  'desc';

		$brands->order($defaultOrder, $defaultDir);

		// Marketplace Categories Url

		$tractors = \XF::options()->fs_tractorbynet_tractors;
		$construction = \XF::options()->fs_tractorbynet_construction;
		$lawnAndGarden = \XF::options()->fs_tractorbynet_lawn_garder;

		// Forums by brand and topic

		$brandForumIds = \XF::options()->fs_tractorbynet_forums_brand;
		$topicForumIds = \XF::options()->fs_tractorbynet_forums_topic;

		$forumsByBrand = array();
		$forumsByTopic = array();

		if ($brandForumIds) {

			$forumIdsBrand = array_filter(array_map('trim', explode(',', $brandForumIds)));

			$forumsByBrand = $this->finder("XF:Node")
				->where("node_id", $forumIdsBrand)->fetch();
		}

		if ($topicForumIds) {

			$forumIdsTopic = array_filter(array_map('trim', explode(',', $topicForumIds)));

			$forumsByTopic = $this->finder("XF:Node")
				->where("node_id", $forumIdsTopic)->fetch();
		}

		return $this->apiResult([
			'threads' => $forumStats['threads'] ?? 0,
			'messages' => $forumStats['messages'] ?? 0,
			'users' => $forumStats['users'] ?? 0,

			'brands' => $brands->fetch(),

			'tractors' => $tractors,
			'construction' => $construction,
			'lawnAndGarden' => $lawnAndGarden,

			'forumsByBrand' => $forumsByBrand,
			'forumsByTopic' => $forumsByTopic
		]);
	}
}
