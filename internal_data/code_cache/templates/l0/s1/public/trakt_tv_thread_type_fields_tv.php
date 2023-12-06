<?php
// FROM HASH: aa84b78816509d217cff53b547d98fe4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['context'] == 'create') AND ($__vars['subContext'] == 'quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth noGutter mergeNext';
		$__finalCompiled .= '
';
	} else if (($__vars['context'] == 'edit') AND ($__vars['subContext'] == 'first_post_quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth mergeNext';
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = '';
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['thread']['Forum']['TVForum'], 'empty', array()) AND $__vars['thread']['Forum']['TVForum']['tv_parent_id']) {
		$__finalCompiled .= '
	' . $__templater->formTextBoxRow(array(
			'name' => 'trakt_tv_tv_id',
			'value' => $__vars['thread']['TV']['tv_episode'],
			'disabled' => ($__vars['context'] == 'edit'),
		), array(
			'label' => 'trakt_tv_episode_number',
			'explain' => 'trakt_tv_episode_enter_episode_number',
			'rowtype' => $__vars['rowType'],
		)) . '
';
	} else {
		$__finalCompiled .= '
	' . $__templater->formTextBoxRow(array(
			'name' => 'trakt_tv_tv_id',
			'value' => $__vars['thread']['TV']['tv_id'],
			'disabled' => ($__vars['context'] == 'edit'),
		), array(
			'label' => 'Trakt TV show link or TV show ID',
			'explain' => 'Don\'t have the Trakt Link or ID for your TV show? Go to <a href="https://trakt.tv/shows/trending" target="_blank" >Trakt Shows</a> and look it up.',
			'rowtype' => $__vars['rowType'],
		)) . '
';
	}
	return $__finalCompiled;
}
);