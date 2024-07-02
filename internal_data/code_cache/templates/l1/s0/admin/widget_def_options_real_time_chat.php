<?php
// FROM HASH: e89101420953dcfe03cc489d307d3c8b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTextBoxRow(array(
		'name' => 'options[defaultTag]',
		'value' => $__vars['options']['defaultTag'],
	), array(
		'label' => 'Default room tag',
		'explain' => 'When loading the chat, room with this tag will open automatically',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[compact]',
		'value' => '1',
		'selected' => $__vars['options']['compact'],
		'label' => 'Compact',
		'hint' => 'The chat will be adapted to the small size.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);