<?php
// FROM HASH: ef485c15d4649ebd3e342869a9a619e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['providerData']) {
		$__finalCompiled .= '
	' . $__templater->callMacro('connected_account_provider_test_macros', 'explain', array(
			'providerTitle' => $__vars['provider']['title'],
			'keyName' => 'App ID',
			'keyValue' => $__vars['provider']['options']['app_id'],
		), $__vars) . '
';
	} else {
		$__finalCompiled .= '
	' . $__templater->callMacro('connected_account_provider_test_macros', 'success', array(), $__vars) . '

	' . $__templater->callMacro('connected_account_provider_test_macros', 'display_name', array(
			'name' => $__vars['providerData']['username'],
		), $__vars) . '

	' . $__templater->callMacro('connected_account_provider_test_macros', 'picture', array(
			'url' => $__vars['providerData']['avatar_url'],
		), $__vars) . '
';
	}
	return $__finalCompiled;
}
);