<?php
// FROM HASH: 07d96a564fa5d69ce88373f600aae472
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Your ad will expire soon' . '</mail:subject>

<p>' . 'Your ad ' . $__templater->func('link', array('canonical:ads-manager/ads/edit', $__vars['ad'], ), true) . ' will expire soon. If you want to continue advertising, please <a href="{extend}">extend</a> your ad before it expires.' . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads/extend', $__vars['ad'], ), true) . '" class="button">' . 'Extend your ad' . '</a></p>

' . $__templater->callMacro('siropu_ads_manager_macros', 'user_notification_footer', array(
		'ad' => $__vars['ad'],
	), $__vars);
	return $__finalCompiled;
}
);