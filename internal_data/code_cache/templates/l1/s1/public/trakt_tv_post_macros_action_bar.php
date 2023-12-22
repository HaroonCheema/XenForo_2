<?php
// FROM HASH: cbc6704c5dcd26b87f6978db15415e38
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (((!$__templater->method($__vars['post'], 'isFirstPost', array())) AND !$__templater->test($__vars['post']['TVPost'], 'empty', array())) OR ($__templater->method($__vars['post'], 'isFirstPost', array()) AND ($__vars['thread']['traktTV']['tv_season'] AND $__vars['thread']['traktTV']['tv_episode']))) {
		$__finalCompiled .= '
	';
		if ($__templater->method($__vars['post'], 'canEdit', array())) {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => 'xf/message.js',
				'min' => '1',
			));
			$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('tvTrakt/episode/update', $__vars['post'], ), true) . '"
			class="actionBar-action actionBar-action--updateEpisode actionBar-action--menuItem"
			data-menu-closer="true">' . 'trakt_tv_update_episode' . '</a>
		';
			$__vars['hasActionBarMenu'] = true;
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);