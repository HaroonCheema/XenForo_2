<?php
// FROM HASH: f17e558621c3aa6d13e10237491eeeb4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['xf']['options']['traktTvThreads_mix']) {
		$__finalCompiled .= '
	';
		$__vars['placeholder'] = 'trakt_tv_post_show';
		$__finalCompiled .= '
	';
		$__vars['titleholder'] = 'trakt_tv_post_new_show';
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['placeholder'] = 'Trakt TV show link or TV show ID';
		$__finalCompiled .= '
	';
		$__vars['titleholder'] = 'trakt_tv_post_show_thread';
		$__finalCompiled .= '	
';
	}
	$__finalCompiled .= '

' . $__templater->formPrefixInput($__templater->method($__vars['forum'], 'getUsablePrefixes', array()), array(
		'maxlength' => $__templater->func('max_length', array('XF.Thread', 'title', ), false),
		'placeholder' => $__vars['placeholder'],
		'title' => $__vars['titleholder'],
		'prefix-value' => $__vars['forum']['default_prefix_id'],
		'type' => 'thread',
		'data-xf-init' => 'tooltip',
	)) . '

<span class="tvhint">' . 'Don\'t have the Trakt Link or ID for your TV show? Go to <a href="https://trakt.tv/shows/trending" target="_blank" >Trakt Shows</a> and look it up.' . '</span>';
	return $__finalCompiled;
}
);