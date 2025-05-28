<?php
// FROM HASH: f8449d71e474f2be1e44646f2aaa681c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' was referred by ' . $__templater->func('username_link', array($__vars['extra']['referrer'], ), true) . ' and have been found using the same IP(s).';
	return $__finalCompiled;
}
);