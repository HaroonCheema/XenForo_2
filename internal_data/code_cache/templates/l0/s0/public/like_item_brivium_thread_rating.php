<?php
// FROM HASH: 7acedb7c84e092870066a599ab5a8dd0
return array(
'macros' => array('like_snippet' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'liker' => '!',
		'rating' => '!',
		'date' => '!',
		'fallbackName' => 'Unknown member',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow-title">
		';
	if ($__vars['rating']['user_id'] == $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			' . '' . $__templater->func('username_link', array($__vars['liker'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' liked your rated in the thread ' . ((((('<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['rating'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['rating']['Thread'], ), true)) . $__templater->escape($__vars['rating']['Thread']['title'])) . '</a>') . '' . '
		';
	} else {
		$__finalCompiled .= '
			' . '' . $__templater->func('username_link', array($__vars['liker'], false, array('defaultname' => $__vars['fallbackName'], ), ), true) . ' liked <a {ratedParams}>{userRated}\'s rated </a> in the thread ' . ((((('<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['rating'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['rating']['Thread'], ), true)) . $__templater->escape($__vars['rating']['Thread']['title'])) . '</a>') . '.' . '
		';
	}
	$__finalCompiled .= '
	</div>

	<div class="contentRow-snippet">' . $__templater->func('snippet', array($__vars['rating']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>

	<div class="contentRow-minor">' . $__templater->func('date_dynamic', array($__vars['date'], array(
	))) . '</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->callMacro(null, 'like_snippet', array(
		'liker' => $__vars['like']['Liker'],
		'rating' => $__vars['content'],
		'date' => $__vars['like']['like_date'],
		'fallbackName' => $__templater->arrayKey($__templater->method($__vars['content'], 'getUser', array()), 'username'),
	), $__vars);
	return $__finalCompiled;
}
);