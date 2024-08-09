<?php
// FROM HASH: df146e0a6f701ba9ce8717f4e351480a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('altf_thread_filter_form_macros', 'field_form', array(
		'fields' => $__vars['fields'],
		'set' => $__vars['filterSet'],
		'reloadTarget' => '.block[data-type=\'thread\']',
		'namePrefix' => 'thread_fields',
	), $__vars);
	return $__finalCompiled;
}
);