<?php
// FROM HASH: a8152ca9a1a2acd89d106c958184486c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->callMacro('af_forumstats_def_options_thread_macros', 'options', array(
		'options' => $__vars['options'],
		'nodeTree' => $__vars['nodeTree'],
		'cutoff' => false,
	), $__vars);
	return $__finalCompiled;
}
);