<?php
// FROM HASH: 13fce855465871f9830f465909ac9c94
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' will expire soon. If you want to continue advertising, please <a href="' . $__templater->func('link', array('ads-manager/ads/extend', $__vars['content'], ), true) . '">extend</a> your ad before it expires.';
	return $__finalCompiled;
}
);