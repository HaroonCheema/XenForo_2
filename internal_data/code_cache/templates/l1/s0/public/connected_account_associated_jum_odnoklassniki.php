<?php
// FROM HASH: 1abb4c564f863b1237f25dd574d5b4bb
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
	<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">' . ($__templater->escape($__vars['providerData']['username']) ?: 'View account') . '</a>
</div>';
	return $__finalCompiled;
}
);