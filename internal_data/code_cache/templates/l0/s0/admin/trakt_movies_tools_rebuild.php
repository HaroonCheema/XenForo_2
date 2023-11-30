<?php
// FROM HASH: 01022effb13e7f9ee46673d65292453a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<span class="u-anchorTarget" id="job-TraktMovies"></span>

';
	$__compilerTemp1 = array(array(
		'value' => 'nick97\\TraktMovies:MovieRatingRebuild',
		'label' => 'trakt_movies_recalculate_ratings',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieRebuild',
		'label' => 'trakt_movies_rebuild_general_movie_info',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieCreditsRebuild',
		'label' => 'trakt_movies_rebuild_credits',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MoviePersonsRebuild',
		'label' => 'trakt_movies_rebuild_persons',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieVideosRebuild',
		'label' => 'trakt_movies_rebuild_videos',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieWatchProvidersRebuild',
		'label' => 'trakt_movies_rebuild_watch_providers',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieProductionCompaniesRebuild',
		'label' => 'trakt_movies_rebuild_movie_production_companies',
		'_type' => 'option',
	));
	if ($__templater->func('is_addon_active', array('ThemeHouse/Covers', ), false)) {
		$__compilerTemp1[] = array(
			'value' => 'nick97\\TraktMovies:MovieThreadCoverUpdate',
			'label' => 'trakt_movies_rebuild_thread_covers',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-header">[nick97] Trakt Movie Thread Starter</h2>
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'job',
	), $__compilerTemp1, array(
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'submit' => 'Rebuild now',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('tools/rebuild', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);