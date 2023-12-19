<?php

namespace nick97\WatchList\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

	public function actionView(ParameterBag $params)
	{
		$parent = parent::actionView($params);
		$user = $this->assertViewableUser($params->user_id);

		$finder = \XF::finder('XF:UserConnectedAccount');
		$traktUser = $finder
			->where('user_id', $params->user_id)->where('provider', 'nick_trakt')
			->fetchOne();

		if (!empty($traktUser)) {

			if (!$user->canViewStats($error)) {
				return $parent;
			} else {
				$traktUserId = null;

				if (!empty($traktUser)) {
					$traktUserId = $traktUser['provider_key'];
				}

				if ($parent instanceof  \XF\Mvc\Reply\View) {
					$parent->setParam('stats', $traktUserId ? $this->userStats($traktUserId) : '');
				}

				return $parent;
			}
		} else {
			return $parent;
		}
	}

	protected function userStats($userId)
	{
		$clientKey = \XF::options()->nick97_watch_list_trakt_api_key;

		if (!$clientKey) {
			throw $this->exception(
				$this->notFound(\XF::phrase("nick97_watch_list_trakt_api_key_not_found"))
			);
		}

		$app = \xf::app();
		$watchListService = $app->service('nick97\WatchList:watchList');

		$toArray = $watchListService->getStatsById($userId, $clientKey);

		$stats = [
			'moviesWatched' => isset($toArray["movies"]["watched"]) ? number_format($toArray["movies"]["watched"]) : null,
			'moviesTime' => $this->convertMinutes($toArray["movies"]["minutes"]),
			'episodesWatched' => isset($toArray["episodes"]["watched"]) ? number_format($toArray["episodes"]["watched"]) : null,
			'episodesTime' => $this->convertMinutes($toArray["episodes"]["minutes"]),
		];

		return $stats;
	}


	protected function convertMinutes($minutes)
	{
		// Convert minutes to hours
		$hours = floor($minutes / 60);
		// $remaining_minutes = $minutes % 60;

		// Convert hours to days
		$days = floor($hours / 24);
		// $remaining_hours = $hours % 24;

		// Convert days to months
		// Assuming 30 days per month (can be adjusted)
		$months = floor($days / 30);
		// $remaining_days = $days % 30;

		$viewParams = [
			'hours' => isset($hours) ? number_format($hours) : 0,
			'days' => isset($days) ? number_format($days) : 0,
			'months' => isset($months) ? number_format($months) : 0,
		];

		return $viewParams;
	}
}
