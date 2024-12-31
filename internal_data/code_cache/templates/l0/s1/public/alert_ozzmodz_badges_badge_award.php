<?php
// FROM HASH: 79ed3b2ce2ef1300c55c8a6f7ba50ba2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['badge'] = $__templater->preEscaped('
	<span class="badgeAlert badgeAlert--' . $__templater->escape($__vars['content']['badge_id']) . ' ' . $__templater->escape($__vars['content']['class']) . '">
		' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_icon', array(
		'badge' => $__vars['content'],
		'context' => 'alert',
	), $__vars) . '
		
		<a href="' . $__templater->func('link', array('members', $__vars['xf']['visitor'], ), true) . '#badges" class="badgeTitle fauxBlockLink-blockLink">
			' . $__templater->escape($__vars['content']['title']) . '
		</a>
	</span>
');
	$__finalCompiled .= ' 

' . 'You have been awarded a badge: ' . $__templater->escape($__vars['badge']) . '';
	return $__finalCompiled;
}
);