<?php
// FROM HASH: 482a18f5556f5abe6f321ca20cfe3af3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canAwardWithBadge', array())) {
		$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('members/award-badge', $__vars['user'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
		' . 'Award with badge' . '
	</a>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['user'], 'canTakeAwayBadges', array())) {
		$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('members/take-away-badge', $__vars['user'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
		' . 'Take away badge' . '
	</a>
';
	}
	return $__finalCompiled;
}
);