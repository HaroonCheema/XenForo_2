<?php
// FROM HASH: 700d9fae90703f6cd79c4e6502c64613
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('trakt_movies.less');
	$__finalCompiled .= '
	
';
	if (!$__vars['xf']['options']['traktthreads_mix']) {
		$__finalCompiled .= '
	';
		$__vars['placeholder'] = 'Trakt link or Movie ID';
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['placeholder'] = 'Thread title, Trakt link or Movie ID';
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
	
' . $__templater->formPrefixInputRow($__vars['prefixes'], array(
		'type' => 'thread',
		'prefix-value' => ($__vars['thread']['prefix_id'] ?: $__vars['forum']['default_prefix_id']),
		'textbox-value' => ($__vars['thread']['title'] ?: $__vars['forum']['draft_thread']['title']),
		'textbox-class' => 'input--title',
		'placeholder' => $__vars['placeholder'],
		'autofocus' => 'autofocus',
		'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
	), array(
		'label' => 'Title',
		'explain' => 'Don\'t have the Trakt Link or ID for your movie? Go to <a href="https://trakt.tv/movies" target="_blank" >Trakt Movie Database</a> and look it up.',
		'rowtype' => 'fullWidth noLabel',
	));
	return $__finalCompiled;
}
);