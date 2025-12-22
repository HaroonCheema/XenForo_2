<?php
// FROM HASH: 6403830abaf2291240ed2313824f366d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formDateInput(array(
		'name' => 'options[date]',
		'value' => $__templater->func('date', array($__vars['options']['date'], 'Y-m-d', ), false),
	)) . '
		<span class="inputGroup-splitter"></span>
		' . $__templater->formTextBox(array(
		'name' => 'options[time]',
		'value' => $__vars['options']['time'],
		'type' => 'time',
	)) . '
	</div>
', array(
		'label' => 'Date',
		'rowtype' => 'input',
	)) . '

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['timeZones']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[zone]',
		'value' => $__vars['options']['zone'],
	), $__compilerTemp1, array(
		'label' => 'Time zone',
	)) . '

' . $__templater->formTextAreaRow(array(
		'name' => 'options[active]',
		'value' => $__vars['options']['active'],
		'autosize' => 'true',
	), array(
		'label' => 'Active text',
	)) . '

' . $__templater->formTextAreaRow(array(
		'name' => 'options[inactive]',
		'value' => $__vars['options']['inactive'],
		'autosize' => 'true',
	), array(
		'label' => 'Inactive text',
	));
	return $__finalCompiled;
}
);