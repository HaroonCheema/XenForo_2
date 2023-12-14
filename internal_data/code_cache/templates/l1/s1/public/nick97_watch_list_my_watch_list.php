<?php
// FROM HASH: 81ab288c44603c3a098c8d4c95546b8e
return array(
'macros' => array('my_watch_list_tmdb_movies' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'movies' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['movies'])) {
		foreach ($__vars['movies'] AS $__vars['movie']) {
			$__finalCompiled .= '

		<div class="structItem structItem--resource">

			<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded">
				<div class="structItem-iconContainer">

					<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '">
						<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '">
					</a>

				</div>
			</div>
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				<div class="structItem-title">

					<a href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['movie']['Thread']['title']) . '</a>

				</div>

				';
			if ($__vars['resource']['resource_state'] != 'deleted') {
				$__finalCompiled .= '
					<div class="structItem-resourceTagLine">' . $__templater->escape($__vars['movie']['tmdb_tagline']) . '</div>
				';
			}
			$__finalCompiled .= '
			</div>
			<div class="structItem-cell structItem-cell--resourceMeta">

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--status">
					<dt>' . 'Status' . '</dt>
					<dd>' . $__templater->escape($__vars['movie']['tmdb_status']) . '</dd>
				</dl>

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--release">
					<dt>' . 'Release' . '</dt>
					<dd><a href="' . $__templater->func('link', array('resources/updates', $__vars['resource'], ), true) . '" class="u-concealed">' . $__templater->escape($__vars['movie']['tmdb_release']) . '</a></dd>
				</dl>

				';
			if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('nick97_watch_list', 'manage_watchlist', ))) {
				$__finalCompiled .= '

					<dl>
						' . $__templater->button('
							' . 'Remove' . '
						', array(
					'href' => $__templater->func('link', array('threads/my-watch-list', $__vars['movie']['Thread'], ), false),
					'icon' => 'delete',
					'overlay' => 'true',
				), '', array(
				)) . '
					</dl>

				';
			}
			$__finalCompiled .= '

			</div>
		</div>
	';
		}
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'my_watch_list_trakt_movies' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'traktMovies' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['traktMovies'])) {
		foreach ($__vars['traktMovies'] AS $__vars['movie']) {
			$__finalCompiled .= '

		<div class="structItem structItem--resource">

			<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded">
				<div class="structItem-iconContainer">

					<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '">
						<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '">
					</a>

				</div>
			</div>
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				<div class="structItem-title">

					<a href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['movie']['Thread']['title']) . '</a>

				</div>

				';
			if ($__vars['resource']['resource_state'] != 'deleted') {
				$__finalCompiled .= '
					<div class="structItem-resourceTagLine">' . $__templater->escape($__vars['movie']['trakt_tagline']) . '</div>
				';
			}
			$__finalCompiled .= '
			</div>
			<div class="structItem-cell structItem-cell--resourceMeta">

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--status">
					<dt>' . 'Status' . '</dt>
					<dd>' . $__templater->escape($__vars['movie']['trakt_status']) . '</dd>
				</dl>

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--release">
					<dt>' . 'Release' . '</dt>
					<dd><a href="' . $__templater->func('link', array('resources/updates', $__vars['resource'], ), true) . '" class="u-concealed">' . $__templater->escape($__vars['movie']['trakt_release']) . '</a></dd>
				</dl>

				<dl>
					' . $__templater->button('
						' . 'Remove' . '
					', array(
				'href' => $__templater->func('link', array('threads/my-watch-list', $__vars['movie']['Thread'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
				</dl>

			</div>
		</div>
	';
		}
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'my_watch_list_tmdb_tv' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tmdbTvShows' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['tmdbTvShows'])) {
		foreach ($__vars['tmdbTvShows'] AS $__vars['tv']) {
			$__finalCompiled .= '

		<div class="structItem structItem--resource">

			<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded">
				<div class="structItem-iconContainer">

					<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['tv']['Thread'], ), true) . '">
						<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['tv'], 'getImageUrl', array())) . '">
					</a>

				</div>
			</div>
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				<div class="structItem-title">

					<a href="' . $__templater->func('link', array('threads', $__vars['tv']['Thread'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['tv']['Thread']['title']) . '</a>

				</div>

				';
			if ($__vars['resource']['resource_state'] != 'deleted') {
				$__finalCompiled .= '
					<div class="structItem-resourceTagLine">' . $__templater->escape($__vars['tv']['tv_genres']) . '</div>
				';
			}
			$__finalCompiled .= '
			</div>
			<div class="structItem-cell structItem-cell--resourceMeta">

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--status">
					<dt>' . 'Status' . '</dt>
					<dd>' . $__templater->escape($__vars['tv']['status']) . '</dd>
				</dl>

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--release">
					<dt>' . 'Release' . '</dt>
					<dd><a href="' . $__templater->func('link', array('resources/updates', $__vars['resource'], ), true) . '" class="u-concealed">' . $__templater->escape($__vars['tv']['tv_release']) . '</a></dd>
				</dl>

				<dl>
					' . $__templater->button('
						' . 'Remove' . '
					', array(
				'href' => $__templater->func('link', array('threads/my-watch-list', $__vars['movie']['Thread'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
				</dl>

			</div>
		</div>
	';
		}
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'my_watch_list_trakt_tv' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'traktTvShows' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['traktTvShows'])) {
		foreach ($__vars['traktTvShows'] AS $__vars['tv']) {
			$__finalCompiled .= '

		<div class="structItem structItem--resource">

			<div class="structItem-cell structItem-cell--icon structItem-cell--iconExpanded">
				<div class="structItem-iconContainer">

					<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['tv']['Thread'], ), true) . '">
						<img class="tvPoster" src="' . $__templater->escape($__templater->method($__vars['tv'], 'getImageUrl', array())) . '">
					</a>

				</div>
			</div>
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				<div class="structItem-title">

					<a href="' . $__templater->func('link', array('threads', $__vars['tv']['Thread'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['tv']['Thread']['title']) . '</a>

				</div>

				';
			if ($__vars['resource']['resource_state'] != 'deleted') {
				$__finalCompiled .= '
					<div class="structItem-resourceTagLine">' . $__templater->escape($__vars['tv']['tv_genres']) . '</div>
				';
			}
			$__finalCompiled .= '
			</div>
			<div class="structItem-cell structItem-cell--resourceMeta">

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--status">
					<dt>' . 'Status' . '</dt>
					<dd>' . $__templater->escape($__vars['tv']['status']) . '</dd>
				</dl>

				<dl class="pairs pairs--justified structItem-minor structItem-metaItem structItem-metaItem--release">
					<dt>' . 'Release' . '</dt>
					<dd><a href="' . $__templater->func('link', array('resources/updates', $__vars['resource'], ), true) . '" class="u-concealed">' . $__templater->escape($__vars['tv']['tv_release']) . '</a></dd>
				</dl>

				<dl>
					' . $__templater->button('
						' . 'Remove' . '
					', array(
				'href' => $__templater->func('link', array('threads/my-watch-list', $__vars['movie']['Thread'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
				</dl>

			</div>
		</div>
	';
		}
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Watch List');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block-container">
	<div class="block-body">

		';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '
		';
	$__templater->includeCss('xfrm.less');
	$__finalCompiled .= '

		<!-- Tmdb Movies -->

		';
	if (!$__templater->test($__vars['movies'], 'empty', array())) {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'my_watch_list_tmdb_movies', array(
			'movies' => $__vars['movies'],
		), $__vars) . '

		';
	}
	$__finalCompiled .= '

		<!-- Trakt Movies -->

		';
	if (!$__templater->test($__vars['traktMovies'], 'empty', array())) {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'my_watch_list_trakt_movies', array(
			'traktMovies' => $__vars['traktMovies'],
		), $__vars) . '

		';
	}
	$__finalCompiled .= '

		<!-- Tmdb Tv & Shows -->

		';
	if (!$__templater->test($__vars['tmdbTvShows'], 'empty', array())) {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'my_watch_list_tmdb_tv', array(
			'tmdbTvShows' => $__vars['tmdbTvShows'],
		), $__vars) . '

		';
	}
	$__finalCompiled .= '

		<!-- Trakt Tv & Shows -->

		';
	if (!$__templater->test($__vars['traktTvShows'], 'empty', array())) {
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'my_watch_list_trakt_tv', array(
			'traktTvShows' => $__vars['traktTvShows'],
		), $__vars) . '

		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->test($__vars['movies'], 'empty', array()) AND ($__templater->test($__vars['traktMovies'], 'empty', array()) AND ($__templater->test($__vars['tmdbTvShows'], 'empty', array()) AND $__templater->test($__vars['traktTvShows'], 'empty', array())))) {
		$__finalCompiled .= '

			<div class="blockMessage">
				' . 'There are no movies & TV Shows in this Watch List.' . '
			</div>

		';
	}
	$__finalCompiled .= '

	</div>


</div>


<!-- Tmdb Movies -->

' . '

<!-- Trakt Movies -->

' . '

<!-- Tmdb Tv & Shows -->

' . '

<!-- Trakt Tv & Shows -->

';
	return $__finalCompiled;
}
);