<?php
// FROM HASH: b1f8a99c470232537df179713173ef5f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->func('callable', array($__vars['message']['User'], 'canGiftTo', ), false) AND $__templater->method($__vars['message']['User'], 'canGiftTo', array())) {
		$__finalCompiled .= '
	<a href="' . $__templater->func('link', array('members/gift', $__vars['message']['User'], ), true) . '" title="' . $__templater->filter('Gift', array(array('for_attr', array()),), true) . '" data-xf-click="overlay">' . $__templater->fontAwesome('fa-gift', array(
		)) . ' <span>' . 'Gift' . '</span></a>
';
	}
	return $__finalCompiled;
}
);