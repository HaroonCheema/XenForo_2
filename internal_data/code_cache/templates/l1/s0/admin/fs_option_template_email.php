<?php
// FROM HASH: 3c535a3f0c30e8f34ed09bf0b6eae54e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['emailTemplates'] = $__templater->method($__vars['option'], 'getEmailTemplates', array());
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['emailTemplates'])) {
		foreach ($__vars['emailTemplates'] AS $__vars['val']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['val']['id'],
				'label' => $__templater->escape($__vars['val']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('

	' . '' . '

	' . $__templater->formSelect(array(
		'name' => $__vars['inputName'],
		'value' => $__vars['option']['option_value'],
	), $__compilerTemp1) . '


', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);