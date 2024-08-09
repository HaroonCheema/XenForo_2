<?php
// FROM HASH: 2803df45669043ca60cc3125dcdc1346
return array(
'macros' => array('location_option' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'fieldCache' => '!',
		'fieldId' => '!',
		'location' => '!',
		'label' => '!',
		'column' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = array();
	if ($__vars['column']) {
		$__compilerTemp1[] = array(
			'name' => 'field_column_cache[' . $__vars['fieldId'] . '][' . $__vars['location'] . '][column]',
			'value' => '1',
			'checked' => ($__vars['fieldCache'][$__vars['fieldId']] AND ($__vars['fieldCache'][$__vars['fieldId']][$__vars['location']] AND $__vars['fieldCache'][$__vars['fieldId']][$__vars['location']]['column'])),
			'label' => 'As a separate column',
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'name' => 'field_column_cache[' . $__vars['fieldId'] . '][' . $__vars['location'] . '][metadata]',
		'value' => '1',
		'checked' => ($__vars['fieldCache'][$__vars['fieldId']] AND ($__vars['fieldCache'][$__vars['fieldId']][$__vars['location']] AND $__vars['fieldCache'][$__vars['fieldId']][$__vars['location']]['metadata'])),
		'label' => 'As metadata (under the title)',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'name' => 'field_column_cache[' . $__vars['fieldId'] . '][' . $__vars['location'] . '][prefix]',
		'value' => '1',
		'checked' => ($__vars['fieldCache'][$__vars['fieldId']] AND ($__vars['fieldCache'][$__vars['fieldId']][$__vars['location']] AND $__vars['fieldCache'][$__vars['fieldId']][$__vars['location']]['prefix'])),
		'label' => 'As a prefix',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->formCheckBox(array(
	), array(array(
		'name' => 'field_column_cache[' . $__vars['fieldId'] . '][' . $__vars['location'] . '][enabled]',
		'value' => '1',
		'checked' => ($__vars['fieldCache'][$__vars['fieldId']] AND ($__vars['fieldCache'][$__vars['fieldId']][$__vars['location']] AND $__vars['fieldCache'][$__vars['fieldId']][$__vars['location']]['enabled'])),
		'label' => $__templater->escape($__vars['label']),
		'data-hide' => 'true',
		'_dependent' => array('
                ' . $__templater->formCheckBox(array(
	), $__compilerTemp1) . '
            '),
		'_type' => 'option',
	))) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['availableFields'], 'empty', array())) {
		$__finalCompiled .= '
    ';
		$__compilerTemp1 = array();
		if ($__templater->isTraversable($__vars['availableFields'])) {
			foreach ($__vars['availableFields'] AS $__vars['fieldId'] => $__vars['field']) {
				$__compilerTemp1[] = array(
					'name' => 'field_column_cache[' . $__vars['fieldId'] . '][enabled]',
					'value' => '1',
					'label' => $__templater->escape($__vars['field']['title']),
					'data-hide' => 'true',
					'checked' => ($__vars['forum']['field_column_cache'][$__vars['fieldId']] AND $__vars['forum']['field_column_cache'][$__vars['fieldId']]['enabled']),
					'_dependent' => array('
                    ' . $__templater->callMacro(null, 'location_option', array(
					'fieldCache' => $__vars['forum']['field_column_cache'],
					'fieldId' => $__vars['fieldId'],
					'location' => 'forum_view',
					'label' => 'In forum view',
				), $__vars) . '
                    ' . $__templater->callMacro(null, 'location_option', array(
					'fieldCache' => $__vars['forum']['field_column_cache'],
					'fieldId' => $__vars['fieldId'],
					'location' => 'search',
					'column' => false,
					'label' => 'In search results',
				), $__vars) . '
                '),
					'_type' => 'option',
				);
			}
		}
		$__finalCompiled .= $__templater->formCheckBoxRow(array(
			'name' => 'field_column_cache',
			'value' => $__vars['forum']['field_column_cache'],
			'listclass' => 'listColumns fieldColumnSelector',
		), $__compilerTemp1, array(
			'label' => 'Show in Thread List',
			'explain' => 'The fields selected will be shown in the locations chosen.',
			'hint' => '
            ' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.listColumns.fieldColumnSelector',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '
        ',
		)) . '
';
	}
	$__finalCompiled .= '

' . $__templater->formRadioRow(array(
		'name' => 'filter_location',
		'value' => $__vars['node']['filter_location'],
	), array(array(
		'value' => '',
		'label' => 'Inherit',
		'_type' => 'option',
	),
	array(
		'value' => 'popup',
		'label' => 'Popup (XenForo Default)',
		'_type' => 'option',
	),
	array(
		'value' => 'sidebar',
		'label' => 'Sidebar',
		'_type' => 'option',
	),
	array(
		'value' => 'above_thread_list',
		'label' => 'Above thread list',
		'_type' => 'option',
	)), array(
		'label' => 'Filter Location',
		'explain' => 'Choose Inherit to use the location configured board-wide in Thread Filter setting or the location setup for any parent node.',
	)) . '

';
	return $__finalCompiled;
}
);