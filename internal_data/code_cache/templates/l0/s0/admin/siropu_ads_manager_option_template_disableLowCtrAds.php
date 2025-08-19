<?php
// FROM HASH: 5a0a219d10e0d7c21dff7247e31d32c0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	' . $__templater->formCheckBox(array(
	), array(array(
		'label' => $__templater->escape($__vars['option']['title']),
		'name' => $__vars['inputName'] . '[enabled]',
		'value' => '1',
		'checked' => ($__vars['option']['option_value']['enabled'] == 1),
		'_dependent' => array('
				<div class="inputGroup">
					<span class="inputGroup-text">' . 'If CTR is lower than' . '</span>
					' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[ctr]',
		'value' => $__vars['option']['option_value']['ctr'],
	)) . '
					<span class="inputGroup-text">%</span>
					<span class="inputGroup-text">' . 'After' . '</span>
					' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[days]',
		'value' => $__vars['option']['option_value']['days'],
	)) . '
					<span class="inputGroup-text">' . 'Days' . '</span>
				</div>
			'),
		'_type' => 'option',
	))) . '
', array(
		'rowtype' => 'input',
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);