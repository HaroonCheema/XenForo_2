<?php
// FROM HASH: 084f135a7db0cc1af8bc1b6f9cea0a08
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

';
	$__vars['aviableForms'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('Snog\\Forms:Form', )), 'findActiveFormsForList', array());
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['aviableForms'])) {
		foreach ($__vars['aviableForms'] AS $__vars['form']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['form']['posid'],
				'label' => '
			' . $__templater->escape($__vars['form']['position']) . '
		',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[posid]',
		'value' => $__vars['options']['posid'],
	), $__compilerTemp1, array(
		'label' => 'Form',
	)) . '

' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'options[row]',
		'value' => $__vars['options']['row'],
		'label' => 'Full width widget',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);