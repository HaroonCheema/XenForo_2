<?php
// FROM HASH: 6f4c108bcba59f4e1a00edc8e8fafdc2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('
	' . $__templater->callMacro('public:currency_macros', 'currency_list', array(
		'value' => $__vars['option']['option_value'],
		'name' => $__vars['inputName'],
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