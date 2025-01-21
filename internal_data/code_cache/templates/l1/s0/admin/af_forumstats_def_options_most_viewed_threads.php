<?php
// FROM HASH: 745a036593c243b0faf8e77d957e4e92
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->callMacro('af_forumstats_def_options_thread_macros', 'options', array(
		'options' => $__vars['options'],
		'nodeTree' => $__vars['nodeTree'],
		'cutoff' => array('min' => 1, 'explain' => false, ),
		'includeClosed' => true,
	), $__vars);
	return $__finalCompiled;
}
);