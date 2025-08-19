<?php
// FROM HASH: 86abe64a6d60788ccf0cf6659c28c360
return array(
'macros' => array('user_notification_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<p style="font-size: 10px; color: gray;">
		' . 'To disable email notifications for this ad, please <a href="' . $__templater->func('link', array('canonical:ads-manager/ads/unsubscribe', $__vars['ad'], ), true) . '">click here</a>.' . '
	</p>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);