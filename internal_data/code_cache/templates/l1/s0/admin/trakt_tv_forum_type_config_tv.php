<?php
// FROM HASH: e9ee1e0f58a5085053b9c6c36596909f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['availableGenres']);
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'name' => 'type_config[available_genres]',
		'value' => $__vars['forum']['type_config']['available_genres'],
		'listclass' => 'field listColumns',
	), $__compilerTemp1, array(
		'label' => 'trakt_tv_available_genre',
		'explain' => 'trakt_tv_available_genre_explain',
	));
	return $__finalCompiled;
}
);