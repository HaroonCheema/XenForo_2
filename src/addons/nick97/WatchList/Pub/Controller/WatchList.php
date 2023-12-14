<?php

namespace nick97\WatchList\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class WatchList extends AbstractController
{

	public function actionIndex(ParameterBag $params)
	{

		// /** @var \XF\Entity\User $user */
		// $user = $this->assertRecordExists('XF:User', 1);

		// if (!$user->canViewWatchList($error)) {
		//     throw $this->exception($this->noPermission($error));
		// }

		// if (!$user->canViewStats($error)) {
		//     throw $this->exception($this->noPermission($error));
		// }


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

		// get visitor
		$visitor = \XF::visitor();

		// get permission
		if ($visitor->hasPermission('nick97_watch_list', 'view_own_watchlist')) {
			$threadIds = $this->finder('XF:Thread')
				->whereOr($conditions)->where('user_id', $visitor->user_id)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

			$tvThreadIds = $this->finder('XF:Thread')
				->whereOr($tvConditions)->where('user_id', $visitor->user_id)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();
		} elseif ($visitor->hasPermission('nick97_watch_list', 'view_everyone_watchlist')) {
			$threadIds = $this->finder('XF:Thread')
				->whereOr($conditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

			$tvThreadIds = $this->finder('XF:Thread')
				->whereOr($tvConditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();
		}

		if (count($threadIds) > 0) {
			$tmdbMovies = $this->finder('Snog\Movies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();
			$traktMovies = $this->finder('nick97\TraktMovies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();

			$movies = array_merge($tmdbMovies, $traktMovies);
		} else {
			$movies = [];
		}

		if (count($tvThreadIds) > 0) {
			$tmdbTv = $this->finder('Snog\TV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();
			$traktTv = $this->finder('nick97\TraktTV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();

			$tvShows = array_merge($tmdbTv, $traktTv);
		} else {
			$tvShows = [];
		}



		$viewpParams = [
			'stats' => $this->userStats(),
			"movies" => $movies,
			"tvShows" => $tvShows,
		];

		return $this->view('nick97\WatchList:index', 'nick97_watch_list_index', $viewpParams);
	}


	public function actionMy()
	{

		$threadIds = $this->finder('XF:Thread')
			->where('discussion_type', 'snog_movies_movie')->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		if (count($threadIds) > 0) {
			$tmdbMovies = $this->finder('Snog\Movies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();
		} else {
			$tmdbMovies = null;
		}

		$traktThreadIds = $this->finder('XF:Thread')
			->where('discussion_type', 'trakt_movies_movie')->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		if (count($traktThreadIds) > 0) {
			$traktMovies = $this->finder('nick97\TraktMovies:Movie')->where('thread_id', $traktThreadIds)->fetch()->toArray();
		} else {
			$traktMovies = null;
		}

		$tvThreadIds = $this->finder('XF:Thread')
			->where('discussion_type', 'snog_tv')->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		if (count($tvThreadIds) > 0) {
			$tmdbTvShows = $this->finder('Snog\TV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();
		} else {
			$tmdbTvShows = null;
		}

		$traktTvThreadIds = $this->finder('XF:Thread')
			->where('discussion_type', 'trakt_tv')->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		if (count($traktTvThreadIds) > 0) {
			$traktTvShows = $this->finder('nick97\TraktTV:TV')->where('thread_id', $traktTvThreadIds)->fetch()->toArray();
		} else {
			$traktTvShows = null;
		}

		$viewpParams = [
			'pageSelected' => 'my',

			"movies" => $tmdbMovies,
			"traktMovies" => $traktMovies,
			"tmdbTvShows" => $tmdbTvShows,
			"traktTvShows" => $traktTvShows,
		];

		return $this->view('nick97\WatchList:index', 'nick97_watch_list_my_watch_list', $viewpParams);
	}

	protected function userStats()
	{

		$endpoint = 'https://api.trakt.tv/users/sean/stats';

		$clientKey = \XF::options()->nick97_watch_list_trakt_api_key;

		if (!$clientKey) {
			throw $this->exception(
				$this->notFound(\XF::phrase("nick97_watch_list_trakt_api_key_not_found"))
			);
		}

		$headers = array(
			'Content-Type: application/json',
			'trakt-api-version: 2',
			'trakt-api-key: ' . $clientKey
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);

		if ($result === false) {
			echo "cURL Error: " . curl_error($ch) . "\n";
			exit;
		}

		curl_close($ch);

		$toArray = json_decode($result, true);

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
