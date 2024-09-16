<?php
// FROM HASH: bb03dcc708dc7182a41cf67ea016fcba
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="contentRow-title">
	' . '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['newsFeed']['username'], ), ), true) . ' rated to the thread ' . ((((('<a href="' . $__templater->func('link', array('bratr-ratings', $__vars['content'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['content']['Thread'], ), true)) . $__templater->escape($__vars['content']['Thread']['title'])) . '</a>') . '' . '
	
	' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['content']['rating'],
		'class' => 'block-outer-opposite',
	), $__vars) . '
</div>

<div class="contentRow-snippet">' . $__templater->func('snippet', array($__vars['content']['message'], $__vars['xf']['options']['newsFeedMessageSnippetLength'], array('stripQuote' => true, ), ), true) . '</div>
<div class="contentRow-minor">' . $__templater->func('date_dynamic', array($__vars['newsFeed']['event_date'], array(
	))) . '</div>';
	return $__finalCompiled;
}
);