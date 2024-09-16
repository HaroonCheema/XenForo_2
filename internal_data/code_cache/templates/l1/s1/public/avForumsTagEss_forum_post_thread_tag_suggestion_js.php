<?php
// FROM HASH: de4dca50493d4e794b7d3458393d4ecd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['tagessSuggestTags']) {
		$__finalCompiled .= '
';
		$__templater->includeJs(array(
			'src' => 'avforums/tagess/tag_suggestion_from_title.js',
			'addon' => 'AVForums/TagEssentials',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'avforums/tagess/tag_suggestion_from_prefix.js',
		'addon' => 'AVForums/TagEssentials',
		'min' => '1',
	));
	return $__finalCompiled;
}
);