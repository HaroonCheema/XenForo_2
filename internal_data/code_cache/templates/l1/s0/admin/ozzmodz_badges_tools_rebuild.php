<?php
// FROM HASH: b7ce714e5d07b369d51ea423d37915ed
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['ozzModzBadgesUserBadgeRebuildBody'] = $__templater->preEscaped('
	' . $__templater->formInfoRow('Rebuild of all existing badges for all users (rewards if criteria is met and revoked if not)', array(
	)) . '
');
	$__finalCompiled .= '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => '[OzzModz] Badges: ' . 'Rebuild user badges',
		'body' => $__vars['ozzModzBadgesUserBadgeRebuildBody'],
		'job' => 'OzzModz\\Badges:UserBadgeRebuild',
	), $__vars) . '

<!--[OzzModz\\Badges:after_user_badges]-->

';
	$__vars['ozzModzBadgesUserBadgeCacheRebuildBody'] = $__templater->preEscaped('
	' . $__templater->formInfoRow('Rebuilds cached user badges values (recent user badges, tier counters) that used to display in common places where additional database queries are not allowed (postbit, member card).', array(
	)) . '
');
	$__finalCompiled .= '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => '[OzzModz] Badges: ' . 'Rebuild user badge cache',
		'body' => $__vars['ozzModzBadgesUserBadgeCacheRebuildBody'],
		'job' => 'OzzModz\\Badges:UserBadgeCacheRebuild',
	), $__vars) . '

<!--[OzzModz\\Badges:after_user_badge_cache]-->

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => '[OzzModz] Badges: ' . 'Recalculate badge count',
		'job' => 'OzzModz\\Badges:UserBadgeCountRebuild',
	), $__vars) . '

<!--[OzzModz\\Badges:after_badge_count]-->';
	return $__finalCompiled;
}
);