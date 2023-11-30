<?php
// FROM HASH: 3fb880ca76392b78dc4897d397a41763
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('trakt_movies_check_poster');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['newposter']) {
		$__compilerTemp1 .= '
					' . 'trakt_movies_poster_available' . '
					<div class="u-alignCenter"><img src="https://image.tmdb.org/t/p/' . $__templater->escape($__vars['xf']['options']['traktthreads_largePosterSize']) . $__templater->escape($__vars['posterpath']) . '" alt="" /></div>
				';
	} else {
		$__compilerTemp1 .= '
					' . 'trakt_movies_poster_not_available' . '
					';
		if ($__vars['posterpath']) {
			$__compilerTemp1 .= '
						<strong>' . 'trakt_movies_reupload_old_poster' . '</strong>
					';
		}
		$__compilerTemp1 .= '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['posterpath']) {
		$__compilerTemp2 .= '
				' . $__templater->formSubmitRow(array(
			'submit' => 'trakt_movies_save_poster',
		), array(
			'rowtype' => 'simple',
		)) . '
				<input type="hidden" name="posterpath" value="' . $__templater->escape($__vars['posterpath']) . '" />
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
		'action' => $__templater->func('link', array('movies/poster', $__vars['movie'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);