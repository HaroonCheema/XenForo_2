<?php
// FROM HASH: e5aab1fcc5927b697a177a3fe0e37161
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' gifted you an <a href="' . $__templater->func('link', array('account/upgrades', ), true) . '">account upgrade</a>.';
	return $__finalCompiled;
}
);