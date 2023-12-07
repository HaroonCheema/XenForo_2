<?php

namespace nick97\WatchList\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class WatchList extends AbstractController
{

	public function actionIndex(ParameterBag $params)
	{
		// return $this->message("Index page. Template not created yet.");

		$conditions = [
			['discussion_type', 'snog_movies_movie'],
			['discussion_type', 'trakt_movies_movie'],
		];

		$threadIds = $this->finder('XF:Thread')
			->whereOr($conditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		$tmdbMovies = $this->finder('Snog\Movies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();
		$traktMovies = $this->finder('nick97\TraktMovies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();

		$movies = array_merge($tmdbMovies, $traktMovies);


		$tvConditions = [
			['discussion_type', 'trakt_tv'],
			['discussion_type', 'snog_tv'],
		];

		$tvThreadIds = $this->finder('XF:Thread')
			->whereOr($tvConditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		if (count($tvThreadIds) > 0) {
			$tmdbTv = $this->finder('Snog\TV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();
			$traktTv = $this->finder('nick97\TraktTV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();

			$tvShows = array_merge($tmdbTv, $traktTv);
		} else {
			$tvShows = null;
		}



		$viewpParams = [
			"movies" => $movies,
			"tvShows" => $tvShows,
		];

		return $this->view('nick97\WatchList:index', 'nick97_watch_list_index', $viewpParams);
	}


	public function actionMy()
	{

		// return $this->message("Template not created yet.");

		$conditions = [
			['discussion_type', 'snog_movies_movie'],
			['discussion_type', 'trakt_movies_movie'],
		];

		$threadIds = $this->finder('XF:Thread')
			->whereOr($conditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		$tmdbMovies = $this->finder('Snog\Movies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();
		// $traktMovies = $this->finder('nick97\TraktMovies:Movie')->where('thread_id', $threadIds)->fetch()->toArray();

		// $movies = array_merge($tmdbMovies, $traktMovies);


		// $tvConditions = [
		// 	['discussion_type', 'trakt_tv'],
		// 	['discussion_type', 'snog_tv'],
		// ];

		// $tvThreadIds = $this->finder('XF:Thread')
		// 	->whereOr($tvConditions)->where('watch_list', 1)->pluckfrom('thread_id')->fetch()->toArray();

		// if (count($tvThreadIds) > 0) {
		// 	$tmdbTv = $this->finder('Snog\TV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();
		// 	$traktTv = $this->finder('nick97\TraktTV:TV')->where('thread_id', $tvThreadIds)->fetch()->toArray();

		// 	$tvShows = array_merge($tmdbTv, $traktTv);
		// } else {
		// 	$tvShows = null;
		// }

		$viewpParams = [
			'pageSelected' => 'my',

			"movies" => $tmdbMovies,
			// "movies" => $movies,
			// "tvShows" => $tvShows,
		];

		return $this->view('nick97\WatchList:index', 'nick97_watch_list_my_watch_list', $viewpParams);
	}
}
