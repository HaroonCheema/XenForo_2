<?php
// FROM HASH: 0182f674e7449fd4054fa94c14012534
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Your ad has been approved!' . '</mail:subject>

<p>' . 'Your ad ' . $__templater->func('link', array('canonical:ads-manager/ads/edit', $__vars['ad'], ), true) . ' has been approved.' . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads', ), true) . '" class="button">' . 'Manage your ads' . '</a></p>

' . $__templater->callMacro('siropu_ads_manager_macros', 'user_notification_footer', array(
		'ad' => $__vars['ad'],
	), $__vars);
	return $__finalCompiled;
}
);