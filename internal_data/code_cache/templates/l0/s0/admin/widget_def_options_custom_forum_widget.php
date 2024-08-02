<?php
// FROM HASH: 77e6f7e529b6a1d50d4315f44077da19
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
		'explain' => 'Gifted content age limit (in days). Use 0 for no limit.',
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
	));
	return $__finalCompiled;
}
);