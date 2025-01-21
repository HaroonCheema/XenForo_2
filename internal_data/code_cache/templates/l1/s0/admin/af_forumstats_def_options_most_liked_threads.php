<?php
// FROM HASH: 532e56098ad16dfb3022634dabba0203
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
		'name' => 'options[cutoff]',
		'value' => $__vars['options']['cutoff'],
		'min' => '1',
	), array(
		'label' => 'Cutoff Days',
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
		'label' => 'Included Forums',
		'explain' => 'Only include threads in the selected forums.',
	)) . '

';
	$__compilerTemp3 = array(array(
		'value' => '',
		'label' => 'None',
		'_type' => 'option',
	));
	$__compilerTemp4 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp4)) {
		foreach ($__compilerTemp4 AS $__vars['treeEntry']) {
			$__compilerTemp3[] = array(
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
		'name' => 'options[excluded_node_ids][]',
		'value' => ($__vars['options']['excluded_node_ids'] ?: ''),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp3, array(
		'label' => 'Excluded Forums',
		'explain' => 'These forums will always be excluded (overrides the setting above)',
	)) . '

' . $__templater->formSelectRow(array(
		'name' => 'options[thread_prefix]',
		'value' => ($__vars['options']['thread_prefix'] ?: ''),
	), array(array(
		'value' => '',
		'label' => 'No prefix',
		'_type' => 'option',
	),
	array(
		'value' => 'html',
		'label' => 'HTML',
		'_type' => 'option',
	),
	array(
		'value' => 'plain',
		'label' => 'Plain',
		'_type' => 'option',
	)), array(
		'label' => 'Thread Prefix',
	)) . '

' . $__templater->formRadioRow(array(
		'name' => 'options[include_closed]',
		'value' => $__vars['options']['include_closed'],
	), array(array(
		'value' => '1',
		'label' => 'Yes',
		'_type' => 'option',
	),
	array(
		'value' => '0',
		'label' => 'No',
		'_type' => 'option',
	)), array(
		'label' => 'Include Closed',
		'explain' => 'Include closed threads?',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[ignore_view_perms]',
		'selected' => $__vars['options']['ignore_view_perms'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Ignore user view permissions',
	));
	return $__finalCompiled;
}
);