<?php
// FROM HASH: fe9dc2ac6408189f3a98101ead689c40
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->isTraversable($__vars['ozzmodzBadgesBadgeTiers'])) {
		foreach ($__vars['ozzmodzBadgesBadgeTiers'] AS $__vars['id'] => $__vars['tier']) {
			$__finalCompiled .= '
	.ozzmodzBadges-tier--' . $__templater->escape($__vars['id']) . '
	{
		border-left: 3px solid ' . $__templater->filter($__vars['tier']['color'], array(array('raw', array()),), true) . ';
	}
';
		}
	}
	return $__finalCompiled;
}
);