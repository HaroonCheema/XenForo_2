<?php
// FROM HASH: 8a11839a7eb13244f3719a20a129c4ac
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<span class="u-anchorTarget" id="job-traktTv"></span>

';
	$__compilerTemp1 = array(array(
		'value' => 'nick97\\TraktTV:TvRatingRebuild',
		'label' => 'trakt_tv_recalculate_ratings',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvForumRatingRebuild',
		'label' => 'trakt_tv_recalculate_forum_ratings',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvThreadRebuild',
		'label' => 'trakt_tv_rebuild_tv_threads',
		'hint' => 'trakt_tv_rebuild_tv_threads_explain',
		'data-hide' => 'true',
		'_dependent' => array($__templater->formCheckBox(array(
		'name' => 'options[rebuildTypes]',
	), array(array(
		'value' => 'credits',
		'label' => 'trakt_tv_credits',
		'_type' => 'option',
	),
	array(
		'value' => 'videos',
		'label' => 'Videos',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvPostRebuild',
		'label' => 'trakt_tv_rebuild_episode_posts',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvCreditsRebuild',
		'label' => 'trakt_tv_rebuild_credits',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvPersonsRebuild',
		'label' => 'trakt_tv_rebuild_persons',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvVideoRebuild',
		'label' => 'trakt_tv_rebuild_videos',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvWatchProviderRebuild',
		'label' => 'trakt_tv_rebuild_watch_providers',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvProductionCompaniesRebuild',
		'label' => 'trakt_tv_rebuild_tv_production_companies',
		'_type' => 'option',
	)
,array(
		'value' => 'nick97\\TraktTV:TvNetworksRebuild',
		'label' => 'trakt_tv_rebuild_tv_networks',
		'_type' => 'option',
	));
	if ($__templater->func('is_addon_active', array('ThemeHouse/Covers', ), false)) {
		$__compilerTemp1[] = array(
			'value' => 'nick97\\TraktTV:TvThreadCoverUpdate',
			'label' => 'trakt_tv_rebuild_thread_covers',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<h2 class="block-header">[nick97] Trakt TV Thread Starter</h2>
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'job',
	), $__compilerTemp1, array(
	)) . '
			
			' . $__templater->formRow('
				' . $__templater->formRadio(array(
		'name' => 'job',
	), array(array(
		'value' => 'nick97\\TraktTV:TvThreadImageDownload',
		'label' => 'trakt_tv_download_thread_poster_images',
		'_type' => 'option',
	),
	array(
		'value' => 'nick97\\TraktTV:TvForumImageDownload',
		'label' => 'trakt_tv_download_forum_poster_images',
		'_type' => 'option',
	),
	array(
		'value' => 'nick97\\TraktTV:TvPostImageDownload',
		'label' => 'trakt_tv_download_episode_images',
		'_type' => 'option',
	),
	array(
		'value' => 'nick97\\TraktTV:TvPersonsImageDownload',
		'label' => 'trakt_tv_download_person_images',
		'_type' => 'option',
	),
	array(
		'value' => 'nick97\\TraktTV:TvNetworkImageDownload',
		'label' => 'trakt_tv_download_network_images',
		'_type' => 'option',
	),
	array(
		'value' => 'nick97\\TraktTV:TvCompanyImageDownload',
		'label' => 'trakt_tv_download_company_images',
		'_type' => 'option',
	))) . '
			', array(
		'label' => 'trakt_tv_tools_local_images',
		'explain' => 'trakt_tv_download_images_explain',
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