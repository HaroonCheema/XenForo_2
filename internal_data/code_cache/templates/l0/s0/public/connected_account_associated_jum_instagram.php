<?php
// FROM HASH: 2b135c6091551ffad478bf13e3ffc5e7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['providerData']['avatar_url']) {
		$__finalCompiled .= '
	<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">
		<img src="' . $__templater->escape($__vars['providerData']['avatar_url']) . '" width="48" alt="" />
	</a>
';
	}
	$__finalCompiled .= '
<div>
	<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">' . ($__templater->escape($__vars['providerData']['fullname']) ?: 'View account') . '</a>
</div>';
	return $__finalCompiled;
}
);