<?php
// FROM HASH: 60f929cdbbdb307f4b9d0f61361ad988
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' tagged a ' . $__templater->escape($__vars['alert']['content_type']) . ' ' . (((('<a href="' . $__templater->escape($__vars['alert']['extra_data']['link'])) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['alert']['extra_data']['title'])) . '</a>') . ' with {tag}';
	return $__finalCompiled;
}
);