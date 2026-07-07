<?php
// FROM HASH: 49a7c78edebeba0a03f794a954e484f8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] AND $__vars['xf']['session']['lau_id']) {
		$__finalCompiled .= '

    <a href="' . $__templater->func('link', array('logout/lauout', ), true) . '" class="p-staffBar-link">
        ' . 'Logout from' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['xf']['visitor']['username']) . '
    </a>

    ';
	} else if ($__templater->method($__vars['xf']['visitor'], 'canUseLau', array()) AND $__vars['xf']['options']['lau_DisplayLoginStaffBar']) {
		$__finalCompiled .= '
    <a href="' . $__templater->func('link', array('login/lauin', ), true) . '" class="p-staffBar-link" data-xf-click="overlay">
        ' . 'Login as User' . '
    </a>

';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);