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
		'label' => 'Recalculate ratings',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieRebuild',
		'label' => 'Rebuild general movie info',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieCreditsRebuild',
		'label' => 'Movie casts & crew',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MoviePersonsRebuild',
		'label' => 'Rebuild person data',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieVideosRebuild',
		'label' => 'Rebuild videos',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieWatchProvidersRebuild',
		'label' => 'Rebuild watch providers',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktMovies:MovieProductionCompaniesRebuild',
		'label' => 'Rebuild movie production companies',
		'_type' => 'option',
	));
	if ($__templater->func('is_addon_active', array('ThemeHouse/Covers', ), false)) {
		$__compilerTemp1[] = array(
			'value' => 'nick97\\TraktMovies:MovieThreadCoverUpdate',
			'label' => 'Rebuild thread covers',
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