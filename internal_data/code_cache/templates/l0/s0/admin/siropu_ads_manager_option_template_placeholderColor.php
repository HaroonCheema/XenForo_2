<?php
// FROM HASH: 5a2bf78e2dc079590d4098f04cfa8b37
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('
	' . $__templater->callMacro('public:color_picker_macros', 'color_picker', array(
		'name' => $__vars['inputName'],
		'value' => $__vars['option']['option_value'],
		'row' => false,
		'allowPalette' => 'true',
	), $__vars) . '
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);