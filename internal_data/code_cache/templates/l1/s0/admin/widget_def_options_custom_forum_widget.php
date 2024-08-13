<?php
// FROM HASH: 00a2b0bdbdc6c97c83ee19e7447b7987
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[dateLimit]',
		'value' => $__vars['options']['dateLimit'],
		'units' => 'Days',
		'min' => '0',
	), array(
		'label' => 'Date limit',
		'explain' => 'Enter date in days here...!',
	)) . '

' . $__templater->formRadioRow(array(
		'name' => 'options[order]',
		'value' => ($__vars['options']['order'] ?: 'newest'),
	), array(array(
		'value' => 'newest',
		'label' => 'Newest threads',
		'_type' => 'option',
	),
	array(
		'value' => 'random',
		'label' => 'Random threads',
		'hint' => 'From all threads that meet set criteria',
		'_type' => 'option',
	)), array(
		'label' => 'Display order',
	)) . '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'All forums',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'Forum'),
				'label' => '
			' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
		',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[node_ids][]',
		'value' => ($__vars['options']['node_ids'] ?: ''),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp1, array(
		'label' => 'Forum limit',
		'explain' => 'Only include threads in the selected forums.',
	)) . '

<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[slider][item]',
		'value' => $__vars['options']['slider']['item'],
		'min' => '1',
	), array(
		'label' => 'Maximum slides',
		'explain' => 'This is the maximum number of slides that will be shown at a time.',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'data-hide' => 'true',
		'selected' => ($__vars['options']['slider']['itemWide'] OR $__vars['options']['slider']['itemMedium']) OR $__vars['options']['slider']['itemNarrow'],
		'label' => 'Enable responsive slides',
		'_dependent' => array('
			<dl class="inputLabelPair">
				<dt><label for="ctrl_wide">' . 'Maximum slides' . ' ' . $__vars['xf']['language']['parenthesis_open'] . 'Wide' . $__vars['xf']['language']['parenthesis_close'] . '</label></dt>
				<dd>' . $__templater->formNumberBox(array(
		'name' => 'options[slider][itemWide]',
		'id' => 'ctrl_wide',
		'value' => $__vars['options']['slider']['itemWide'],
		'min' => '0',
		'required' => false,
	)) . '</dd>
			</dl>
			<dl class="inputLabelPair">
				<dt><label for="ctrl_medium">' . 'Maximum slides' . ' ' . $__vars['xf']['language']['parenthesis_open'] . 'Medium' . $__vars['xf']['language']['parenthesis_close'] . '</label></dt>
				<dd>' . $__templater->formNumberBox(array(
		'name' => 'options[slider][itemMedium]',
		'id' => 'ctrl_medium',
		'value' => $__vars['options']['slider']['itemMedium'],
		'min' => '0',
		'required' => false,
	)) . '</dd>
			</dl>
			<dl class="inputLabelPair">
				<dt><label for="ctrl_narrow">' . 'Maximum slides' . ' ' . $__vars['xf']['language']['parenthesis_open'] . 'Narrow' . $__vars['xf']['language']['parenthesis_close'] . '</label></dt>
				<dd>' . $__templater->formNumberBox(array(
		'name' => 'options[slider][itemNarrow]',
		'id' => 'ctrl_narrow',
		'value' => $__vars['options']['slider']['itemNarrow'],
		'min' => '0',
		'required' => false,
	)) . '</dd>
			</dl>
		'),
		'afterhint' => 'The maximum number of slides displayed at a time can be flexible depending on viewport size. If checked, leave fields blank or 0 to not change the value for a particular breakpoint.',
		'_type' => 'option',
	)), array(
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[slider][auto]',
		'selected' => $__vars['options']['slider']['auto'],
		'hint' => 'Slider will automatically play slides.',
		'label' => '
		' . 'Auto-play' . '
	',
		'_type' => 'option',
	),
	array(
		'name' => 'options[slider][loop]',
		'selected' => $__vars['options']['slider']['loop'],
		'hint' => 'Allow slider to loop back to the beginning when the end is reached.',
		'label' => '
		' . 'Loop slides' . '
	',
		'_type' => 'option',
	)), array(
	)) . '

<hr class="formRowSep" />

' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
		'type' => 'threads',
		'set' => $__vars['thread']['custom_fields'],
		'onlyInclude' => $__vars['onlyInclude'],
		'options' => $__vars['options'],
		'requiredOnly' => 'false',
	), $__vars);
	return $__finalCompiled;
}
);