<?php
// FROM HASH: 148ee9ad1463d543e316fe4bfa65bf09
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('thcovers_modify_cover_image');
	$__finalCompiled .= '

';
	$__templater->includeCss('th_covers.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['hasNewBackdrop']) {
		$__compilerTemp1 .= '
				' . 'trakt_tv_backdrop_available' . '<br /><br />
				<span style="text-align:center;"><img src="https://image.tmdb.org/t/p/' . $__templater->escape($__vars['xf']['options']['traktTvThreads_backdropCoverSize']) . $__templater->escape($__vars['backdropPath']) . '" alt="" /></span>
			';
	} else {
		$__compilerTemp1 .= '
				' . 'trakt_tv_new_backdrop_not_available' . '
				';
		if ($__vars['backdropPath']) {
			$__compilerTemp1 .= '
					<strong>' . 'trakt_tv_reupload_old_backdrop' . '</strong>
				';
		}
		$__compilerTemp1 .= '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		' . $__templater->formInfoRow('
			' . $__compilerTemp1 . '
		', array(
		'rowtype' => 'confirm',
	)) . '

		' . $__templater->formSubmitRow(array(
		'submit' => 'Okay',
		'class' => 'js-overlayClose',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('covers/tv-update', array('content_type' => $__vars['contentType'], 'content_id' => $__vars['contentId'], ), ), false),
		'ajax' => 'true',
		'upload' => 'true',
		'class' => 'block',
		'data-xf-init' => 'cover-upload',
	));
	return $__finalCompiled;
}
);