<?php
// FROM HASH: f21bcff14b89149d53069ee35dddaeca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' has submitted a new ad: ' . (((('<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/details', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . '';
	return $__finalCompiled;
}
);