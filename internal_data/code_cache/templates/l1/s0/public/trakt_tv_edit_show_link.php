<?php
// FROM HASH: f1c5cf0d25c7f020a9c1c1f2127a1ca9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['post'], 'isFirstPost', array()) AND (!$__templater->test($__vars['thread']['traktTV'], 'empty', array()) AND (!$__vars['thread']['traktTV']['tv_episode']))) {
		$__finalCompiled .= '
	';
		if ($__templater->method($__vars['post'], 'canEdit', array())) {
			$__finalCompiled .= '
		';
			if (($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('forum', 'trakt_edit_shows', )) AND (!$__vars['thread']['traktTV']['comment'])) OR $__vars['thread']['traktTV']['comment']) {
				$__finalCompiled .= '
			';
				$__templater->includeJs(array(
					'src' => 'xf/message.js',
					'min' => '1',
				));
				$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('tvTrakt/edit', $__vars['thread']['traktTV'], ), true) . '"
				class="actionBar-action actionBar-action--edit actionBar-action--menuItem"
				data-xf-click="quick-edit"
				data-editor-target="#js-post-' . $__templater->escape($__vars['post']['post_id']) . ' .js-quickEditTarget"
				data-menu-closer="true">' . 'Edit' . '</a>
			';
				$__vars['hasActionBarMenu'] = true;
				$__finalCompiled .= '
		';
			}
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);