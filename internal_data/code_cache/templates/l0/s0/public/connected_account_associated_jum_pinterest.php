<?php
// FROM HASH: 03e24da21a6acc5c26be3461a8c076cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">' . ($__templater->escape($__vars['providerData']['username']) ?: 'View account') . '</a>';
	return $__finalCompiled;
}
);