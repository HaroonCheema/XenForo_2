<?php
// FROM HASH: fc454b36d6d54c558eddbb8eb9160384
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[project_id]',
		'value' => $__vars['profile']['options']['project_id'],
		'required' => 'true',
	), array(
		'label' => 'Project ID',
		'hint' => 'Required',
		'explain' => '
		' . 'To get your project-id, Create a project in your PaySera account then go to Project settings -> General project settings' . '
	',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[project_password]',
		'value' => $__vars['profile']['options']['project_password'],
		'required' => 'true',
		'autosize' => 'true',
	), array(
		'label' => 'Project Password',
		'explain' => 'To get your project password, Create a project in your PaySera account then go to Project settings -> General project settings',
		'hint' => 'Required',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[test_payment]',
		'selected' => $__vars['profile']['options']['test_payment'],
		'label' => 'Test Payment',
		'hint' => 'To make test payments, it is necessary to activate the mode for a particular project by logging in and selecting: "Projects and Activities" -> "My projects" -> "Project settings" -> "Payment collection service settings" -> "Allow test payments" (check).',
		'_type' => 'option',
	)), array(
	)) . '

' . $__templater->formHiddenVal('options[legacy]', ($__vars['profile']['options']['legacy'] ? 1 : 0), array(
	));
	return $__finalCompiled;
}
);