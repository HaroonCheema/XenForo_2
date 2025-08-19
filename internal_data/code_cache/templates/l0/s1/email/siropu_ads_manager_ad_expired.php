<?php
// FROM HASH: 613d6c067f7bf871139567b457ff56ca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Your ad has expired' . '</mail:subject>

<p>' . 'Your ad ' . $__templater->func('link', array('canonical:ads-manager/ads/edit', $__vars['ad'], ), true) . ' has expired. If you want to continue advertising, please <a href="{extend}">extend</a> your ad.' . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads', ), true) . '" class="button">' . 'Manage your ads' . '</a></p>

' . $__templater->callMacro('siropu_ads_manager_macros', 'user_notification_footer', array(
		'ad' => $__vars['ad'],
	), $__vars);
	return $__finalCompiled;
}
);