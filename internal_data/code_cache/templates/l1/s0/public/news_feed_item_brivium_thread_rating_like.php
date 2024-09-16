<?php
// FROM HASH: a8a95770200ceebf96f1319fc12f4011
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="contentRow-title">
	';
	if ($__vars['content']['user_id'] == $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
		' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['user']['username'], ), ), true) . ' liked your rated in the thread ' . ((((('<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['content'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '' . '
		';
	} else {
		$__finalCompiled .= '
		' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['user']['username'], ), ), true) . ' liked <a ' . (('href="' . $__templater->func('link', array('posts', $__vars['content'], ), true)) . '"') . '>' . $__templater->escape($__vars['content']['username']) . '\'s rated </a> in the thread ' . ((((('<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['content'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '.' . '
	';
	}
	$__finalCompiled .= '

	' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['content']['rating'],
		'class' => 'block-outer-opposite',
	), $__vars) . '
</div>

<div class="contentRow-snippet">' . $__templater->func('snippet', array($__vars['content']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>';
	return $__finalCompiled;
}
);