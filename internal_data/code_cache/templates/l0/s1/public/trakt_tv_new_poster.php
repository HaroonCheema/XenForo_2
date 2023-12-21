<?php
// FROM HASH: 135f91d81e7f0834f408dbbe7057e777
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Check for new poster');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['newposter']) {
		$__compilerTemp1 .= '
					' . 'trakt_tv_poster_available' . '<br /><br />
					<span style="text-align:center;"><img src="https://image.tmdb.org/t/p/' . $__templater->escape($__vars['xf']['options']['traktTvThreads_largePosterSize']) . $__templater->escape($__vars['posterpath']) . '" alt="" /></span>
				';
	} else {
		$__compilerTemp1 .= '
					' . 'trakt_tv_poster_not_available' . '
					';
		if ($__vars['posterpath']) {
			$__compilerTemp1 .= '
						<strong>' . 'trakt_tv_reupload_old_poster' . '</strong>
					';
		}
		$__compilerTemp1 .= '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['posterpath']) {
		$__compilerTemp2 .= '
				<input type="hidden" name="posterpath" value="' . $__templater->escape($__vars['posterpath']) . '" />
				' . $__templater->formSubmitRow(array(
			'submit' => 'trakt_tv_save_poster',
		), array(
			'rowtype' => 'simple',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			
			' . $__compilerTemp2 . '

		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('tvTrakt/poster', $__vars['tvshow'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);