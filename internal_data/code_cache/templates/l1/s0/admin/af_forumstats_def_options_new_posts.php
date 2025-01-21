<?php
// FROM HASH: f2aaa6ab7bbf8e5251a99b1d6b2502de
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->callMacro('af_forumstats_def_options_thread_macros', 'options', array(
		'options' => $__vars['options'],
		'nodeTree' => $__vars['nodeTree'],
		'cutoff' => array('min' => 0, 'explain' => true, ),
	), $__vars);
	return $__finalCompiled;
}
);