<?php
// FROM HASH: 4ae88221e3c3f68eb034fdaba22f96b7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' wrote a message on <a ' . (('href="' . $__templater->func('link', array('owner-page-posts', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>your owner-page</a>.';
	return $__finalCompiled;
}
);