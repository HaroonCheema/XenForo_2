<?php
// FROM HASH: b0dfd29b03e5d07f1bd7e912381d5c7e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['content'], 'isQueued', array())) {
		$__finalCompiled .= '
	' . 'Your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' has been approved and added to the queue.' . '
';
	} else {
		$__finalCompiled .= '
	' . 'Your ad ' . (((('<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' has been approved.' . '
';
	}
	return $__finalCompiled;
}
);