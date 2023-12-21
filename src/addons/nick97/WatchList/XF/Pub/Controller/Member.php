<?php

namespace nick97\WatchList\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

	// public function actionView(ParameterBag $params)
	// {
	// 	$parent = parent::actionView($params);
	// 	$user = $this->assertViewableUser($params->user_id);

	// 	$finder = \XF::finder('XF:UserConnectedAccount');
	// 	$traktUser = $finder
	// 		->where('user_id', $params->user_id)->where('provider', 'nick_trakt')
	// 		->fetchOne();

	// 	if (!empty($traktUser)) {

	// 		if (!$user->canViewStats($error)) {
	// 			return $parent;
	// 		} else {
	// 			$traktUserId = null;

	// 			if (!empty($traktUser)) {
	// 				$traktUserId = $traktUser['provider_key'];
	// 			}

	// 			if ($parent instanceof  \XF\Mvc\Reply\View) {
	// 				$parent->setParam('stats', $traktUserId ? $this->userStats($traktUserId) : '');
	// 			}

	// 			return $parent;
	// 		}
	// 	} else {
	// 		return $parent;
	// 	}
	// }

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

	public function actionStats(ParameterBag $params)
	{
		$user = $this->assertViewableUser($params->user_id);

		$finder = \XF::finder('XF:UserConnectedAccount');
		$traktUser = $finder
			->where('user_id', $params->user_id)->where('provider', 'nick_trakt')
			->fetchOne();

		$traktUserId = null;
		$limit = false;

		if (!empty($traktUser)) {

			if (!$user->canViewStats($error)) {
				$traktUserId = null;
				$limit = true;
			} else {
				if (!empty($traktUser)) {
					$traktUserId = $traktUser['provider_key'];
				}
			}
		}

		$viewParams = [
			'stats' => $traktUserId ? $this->userStats($traktUserId) : '',
			'limit' => $limit
		];

		return $this->view('XF:Member\Stats', 'nick97_watchlist_profile_stats', $viewParams);
	}


	public function actionWatchlist(ParameterBag $params)
	{
		$conditions = [
			['discussion_type', 'snog_movies_movie'],
			['discussion_type', 'trakt_movies_movie'],
		];

		$tvConditions = [
			['discussion_type', 'trakt_tv'],
			['discussion_type', 'snog_tv'],
		];

		$threadIds = [];
		$tvThreadIds = [];

		$limit = false;


		$user = $this->assertViewableUser($params->user_id);

		// get visitor
		$visitor = \XF::visitor();

		// get permission

		if ($user->canViewWatchList($error)) {

			// if ($visitor->hasPermission('nick97_watch_list', 'view_own_watchlist')) {

			$allThreadIds = $this->finder('nick97\WatchList:WatchList')
				->where('user_id', $user->user_id)->pluckfrom('thread_id')->fetch()->toArray();

			$threadIds = $this->finder('XF:Thread')
				->whereOr($conditions)->where('thread_id', $allThreadIds)->pluckfrom('thread_id')->fetch()->toArray();

			$tvThreadIds = $this->finder('XF:Thread')
				->whereOr($tvConditions)->where('thread_id', $allThreadIds)->pluckfrom('thread_id')->fetch()->toArray();
			// }
		} else {
			$limit = true;
		}

		if (count($threadIds) > 0) {
			// $tmdbMovies = $this->finder('Snog\Movies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();
			$traktMovies = $this->finder('nick97\TraktMovies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();

			// $movies = array_merge($tmdbMovies, $traktMovies);
			$movies = $traktMovies;
		} else {
			$movies = [];
		}

		if (count($tvThreadIds) > 0) {

			// $tmdbTv = $this->finder('Snog\TV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();
			$traktTv = $this->finder('nick97\TraktTV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();

			// $tvShows = array_merge($tmdbTv, $traktTv);
			$tvShows = $traktTv;
		} else {
			$tvShows = [];
		}

		$viewParams = [
			"movies" => $movies,
			"tvShows" => $tvShows,

			'limit' => $limit
		];

		return $this->view('XF:Member\Watchlist', 'nick97_watchlist_profile_watchlist', $viewParams);
	}
}
