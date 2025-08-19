<?php
// FROM HASH: 76721234cf449e17599d378f297b3402
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' has expired. If you want to continue advertising, please <a href="' . $__templater->func('link', array('ads-manager/ads/extend', $__vars['content'], ), true) . '">extend</a> your ad.';
	return $__finalCompiled;
}
);