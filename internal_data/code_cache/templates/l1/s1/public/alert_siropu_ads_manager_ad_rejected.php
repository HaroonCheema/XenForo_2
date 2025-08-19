<?php
// FROM HASH: a2559493a3ff0214a05248f6f071f3aa
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' has been rejected for the following reason: ' . $__templater->escape($__vars['content']['Extra']['reject_reason']) . '';
	return $__finalCompiled;
}
);