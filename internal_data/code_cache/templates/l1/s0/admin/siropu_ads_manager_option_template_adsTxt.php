<?php
// FROM HASH: 1849d641dabe4c5414eb2f5ef82e5e38
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextAreaRow(array(
		'name' => $__vars['inputName'],
		'value' => $__vars['option']['option_value'],
		'rows' => '5',
	), array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);