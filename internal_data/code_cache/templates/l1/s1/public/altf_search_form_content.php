<?php
// FROM HASH: a3d49a957968a11b6f5cfc9cb6b30104
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['fields']) {
		$__finalCompiled .= '
    ' . $__templater->formRow('
        ' . '
        ' . $__templater->callMacro('altf_thread_filter_form_macros', 'field_form_setup', array(), $__vars) . '
        ' . $__templater->callMacro('altf_thread_filter_form_macros', 'field_form', array(
			'fields' => $__vars['fields'],
			'set' => $__vars['filterSet'],
			'namePrefix' => 'c[thread_fields]',
		), $__vars) . '
    ', array(
			'rowtype' => 'input',
			'label' => 'Additional Filters',
		)) . '
';
	}
	return $__finalCompiled;
}
);