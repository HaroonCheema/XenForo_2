<?php
// FROM HASH: 807efb94e474fa99d3b4505032d0b35c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'You received ' . $__templater->escape($__vars['extra']['credits']) . ' credits for your thread <a href="' . $__templater->escape($__vars['extra']['thread_url']) . '">' . $__templater->escape($__vars['extra']['thread_title']) . '</a>.';
	return $__finalCompiled;
}
);