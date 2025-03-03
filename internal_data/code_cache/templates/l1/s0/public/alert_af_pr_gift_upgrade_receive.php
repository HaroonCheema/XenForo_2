<?php
// FROM HASH: b2ddf80ab2453f3ce285ff1410bb1126
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<strong class="subject">You</strong> have been gifted an account upgrade: ' . (((('<a href="' . $__templater->func('link', array('account/upgrades', ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['title'])) . '</a>') . ' by ' . ($__vars['extra']['anon'] ? 'Anonymous' : $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true)) . '';
	return $__finalCompiled;
}
);