<?php
// FROM HASH: fda2422b5f738eab6c3fdfc0ab90cb7d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['providerData']['avatar_url']) {
		$__finalCompiled .= '
	<img src="' . $__templater->escape($__vars['providerData']['avatar_url']) . '" width="48" alt="" />
';
	}
	$__finalCompiled .= '
<div>' . ($__templater->escape($__vars['providerData']['username']) ?: 'Account associated') . '</div>';
	return $__finalCompiled;
}
);