<?php
// FROM HASH: fb4488691e217b9418c67a517717e5d0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['daysValue'] = ($__vars['option']['option_value']['enabled'] ? $__vars['option']['option_value']['days'] : array(1, 3, ));
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array('
            ' . $__templater->formCheckBox(array(
	), array(array(
		'name' => $__vars['inputName'] . '[alerts]',
		'selected' => $__vars['option']['option_value']['alerts'],
		'label' => 'Alerts',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['inputName'] . '[emails]',
		'selected' => $__vars['option']['option_value']['emails'],
		'label' => 'Emails',
		'_type' => 'option',
	))) . '
            <div>' . 'Notify on these days before expiration (separated by commas)' . $__vars['xf']['language']['label_separator'] . '</div>
            ' . '' . '
            ' . $__templater->formTokenInput(array(
		'name' => $__vars['inputName'] . '[days]',
		'value' => $__templater->filter($__vars['daysValue'], array(array('join', array(', ', )),), false),
		'min-length' => '1',
	)) . '
        '),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);