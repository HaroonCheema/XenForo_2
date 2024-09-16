<?php
// FROM HASH: c4de75d4f9a426ae105797f318c2c50d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' tagged a ' . $__templater->escape($__vars['contentTypePhrase']) . ' ' . (((('<a href="' . $__templater->escape($__vars['contentLink'])) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['contentTitle'])) . '</a>') . ' with ' . $__templater->escape($__vars['extra']['tag']) . '';
	return $__finalCompiled;
}
);