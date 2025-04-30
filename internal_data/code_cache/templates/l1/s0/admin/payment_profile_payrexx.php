<?php
// FROM HASH: 3a0a17f2913c35fcd21c63da354bbc98
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[instance]',
		'value' => $__vars['profile']['options']['instance'],
	), array(
		'label' => 'Instance',
	)) . '
	
' . $__templater->formTextBoxRow(array(
		'name' => 'options[secret_key]',
		'value' => $__vars['profile']['options']['secret_key'],
	), array(
		'label' => 'Secret Key',
	));
	return $__finalCompiled;
}
);