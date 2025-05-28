<?php
// FROM HASH: daf673ba0aa4c837d1760e2ffd7578d9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' has registered using your referral link!';
	return $__finalCompiled;
}
);