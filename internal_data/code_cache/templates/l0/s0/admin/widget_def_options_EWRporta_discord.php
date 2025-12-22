<?php
// FROM HASH: 21f12ba69e9fa4f33a1fb9cca0cc7fde
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[server]',
		'value' => $__vars['options']['server'],
	), array(
		'label' => 'Server ID',
	)) . '
' . $__templater->formNumberBoxRow(array(
		'name' => 'options[height]',
		'value' => $__vars['options']['height'],
		'min' => '300',
	), array(
		'label' => 'Height',
	)) . '

<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[advanced_mode]',
		'value' => '1',
		'selected' => $__vars['options']['advanced_mode'],
		'label' => 'Advanced mode',
		'hint' => 'If enabled, the HTML for your page will not be contained within a block.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);