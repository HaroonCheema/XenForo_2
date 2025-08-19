<?php
// FROM HASH: 285cabeeba54a39977e0c27a7b2a9fb1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true) . '" class="fauxBlockLink-blockLink">' . $__templater->escape($__vars['content']['name']) . '</a>: ' . $__templater->escape($__vars['alert']['extra_data']['message']);
	return $__finalCompiled;
}
);