<?php
// FROM HASH: 4ceee3fa22cb016449f35695d8a9a19a
return array(
'macros' => array('badges_tab' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['user']['badge_count'] != 0) {
		$__finalCompiled .= '
		<!--[OzzModz\\Badges:tabs:before_badges]-->

		<a href="' . $__templater->func('link', array('members/badges', $__vars['user'], ), true) . '"
		   class="tabs-tab"
		   id="badges"
		   role="tab">' . 'Badges' . '</a>

		<!--[OzzModz\\Badges:tabs:after_badges]-->
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'badges_pane' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['user']['badge_count'] != 0) {
		$__finalCompiled .= '
		<!--[OzzModz\\Badges:tab_panes:before_badges]-->

		<li data-href="' . $__templater->func('link', array('members/badges', $__vars['user'], ), true) . '" role="tabpanel" aria-labelledby="badges">
			<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
		</li>

		<!--[OzzModz\\Badges:tab_panes:after_badges]-->
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);