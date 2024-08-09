<?php
// FROM HASH: 75772d8638b2558302ea8b9fb21bc575
return array(
'macros' => array('filter_element' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . '
    ';
	if ($__templater->func('in_array', array($__vars['definition']['field_type'], array('textbox', 'textarea', 'bbcode', ), ), false)) {
		$__finalCompiled .= '
        ' . $__templater->callMacro(null, 'altf_custom_fields_edit_textbox', array(
			'set' => $__vars['set'],
			'definition' => $__vars['definition'],
			'editMode' => $__vars['editMode'],
			'namePrefix' => $__vars['namePrefix'],
		), $__vars) . '

        ';
	} else if ($__vars['definition']['field_type'] === 'stars') {
		$__finalCompiled .= '
        ' . $__templater->callMacro('rating_macros', 'rating', array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'currentRating' => $__vars['set'][$__vars['definition']['field_id']],
			'deselectable' => 'true',
			'row' => false,
		), $__vars) . '

        ';
	} else if ($__templater->func('in_array', array($__vars['definition']['field_type'], array('location', ), ), false)) {
		$__finalCompiled .= '
        ' . $__templater->callMacro(null, 'altf_custom_fields_edit_location', array(
			'set' => $__vars['set'],
			'definition' => $__vars['definition'],
			'editMode' => $__vars['editMode'],
			'namePrefix' => $__vars['namePrefix'],
		), $__vars) . '

        ' . '
        ';
	} else if ($__templater->func('in_array', array($__vars['definition']['FieldData']['filter_template'], array('checkbox', 'select', 'radio', 'multiselect', ), ), false)) {
		$__finalCompiled .= '
        ' . $__templater->callMacro(null, 'custom_fields_edit_' . $__vars['definition']['FieldData']['filter_template'], array(
			'set' => $__vars['set'],
			'definition' => $__vars['definition'],
			'editMode' => $__vars['editMode'],
			'namePrefix' => $__vars['namePrefix'],
		), $__vars) . '

        ';
	} else {
		$__finalCompiled .= '
        ' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit_' . $__vars['definition']['FieldData']['filter_template'], array(
			'set' => $__vars['set'],
			'definition' => $__vars['definition'],
			'editMode' => $__vars['editMode'],
			'namePrefix' => $__vars['namePrefix'],
		), $__vars) . '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_multiselect' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

    ' . $__templater->callMacro(null, 'custom_fields_edit_select', array(
		'set' => $__vars['set'],
		'definition' => $__vars['definition'],
		'editMode' => '!',
		'multi' => '1',
		'namePrefix' => $__vars['namePrefix'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'multi' => '',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoices', array($__vars['definition'], $__vars['set'], false, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['option']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['key'],
				'labelclass' => $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoiceClass', array($__vars['definition'], $__vars['key'], )),
				'label' => $__templater->filter($__vars['option'], array(array('raw', array()),), true) . '
            ',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelect(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => (($__vars['set'][$__vars['definition']['field_id']] === null) ? '' : $__vars['set'][$__vars['definition']['field_id']]),
		'multiple' => $__vars['multi'],
		'size' => ($__vars['multi'] AND ($__vars['xf']['options']['altf_filterable_lists'] ? 1 : 0)),
		'class' => 'field_' . $__vars['definition']['field_id'],
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_radio' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = array();
	if (!$__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], ))) {
		$__compilerTemp1[] = array(
			'value' => '',
			'label' => 'No selection',
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoices', array($__vars['definition'], $__vars['set'], ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['option']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['key'],
				'labelclass' => $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoiceClass', array($__vars['definition'], $__vars['key'], )),
				'label' => $__templater->filter($__vars['option'], array(array('raw', array()),), true) . '
            ',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRadio(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => (($__vars['set'][$__vars['definition']['field_id']] === null) ? '' : $__vars['set'][$__vars['definition']['field_id']]),
		'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
		'class' => 'field_' . $__vars['definition']['field_id'],
		'listclass' => 'listColumns',
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'custom_fields_edit_checkbox' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__compilerTemp1 = array();
	$__compilerTemp2 = $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoices', array($__vars['definition'], $__vars['set'], ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['option']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['key'],
				'labelclass' => $__templater->method($__templater->method($__vars['definition'], 'getFacetData', array()), 'getChoiceClass', array($__vars['definition'], $__vars['key'], )),
				'label' => $__templater->filter($__vars['option'], array(array('raw', array()),), true) . '
            ',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBox(array(
		'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
		'value' => $__vars['set'][$__vars['definition']['field_id']],
		'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
		'listclass' => 'field_' . $__vars['definition']['field_id'] . ' listColumns',
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'altf_custom_fields_edit_location' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . $__templater->callMacro('allf_custom_fields_macros', 'custom_fields_filter_location', array(
		'set' => $__vars['set'],
		'definition' => $__vars['definition'],
		'editMode' => $__vars['editMode'],
		'defaultDistanceUnit' => $__vars['xf']['options']['altf_default_distance_unit'],
		'namePrefix' => $__vars['namePrefix'],
		'customFieldContainerType' => 'threads',
		'hideDistanceUnit' => $__vars['xf']['options']['altf_hide_distance_unit'],
	), $__vars) . '
    ' . '
';
	return $__finalCompiled;
}
),
'altf_custom_fields_edit_textbox' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'set' => '!',
		'definition' => '!',
		'editMode' => '!',
		'namePrefix' => 'custom_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

    ';
	if ($__vars['definition']['match_type'] == 'date') {
		$__finalCompiled .= '

        ' . $__templater->formDateInput(array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . '][from]',
			'value' => $__vars['set'][$__vars['definition']['field_id']]['from'],
			'data-field' => $__vars['definition']['field_id'],
			'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
			'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
			'class' => 'field_' . $__vars['definition']['field_id'],
			'placeholder' => ' ' . 'From...' . ' ',
		)) . '

        <span class="inputGroup-splitter"></span>

        ' . $__templater->formDateInput(array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . '][to]',
			'value' => $__vars['set'][$__vars['definition']['field_id']]['to'],
			'data-field' => $__vars['definition']['field_id'],
			'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
			'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
			'class' => 'field_' . $__vars['definition']['field_id'],
			'placeholder' => ' ' . 'To...' . ' ',
		)) . '


        ';
	} else if ($__vars['definition']['match_type'] == 'color') {
		$__finalCompiled .= '

        ' . $__templater->callMacro('color_picker_macros', 'color_picker', array(
			'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
			'value' => $__vars['set'][$__vars['definition']['field_id']],
			'mapName' => '',
			'row' => false,
			'required' => $__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )),
		), $__vars) . '

        ';
	} else {
		$__finalCompiled .= '

        ';
		if ($__vars['definition']['match_type'] == 'number') {
			$__finalCompiled .= '

            ';
			$__vars['type'] = 'number';
			$__finalCompiled .= '
            ';
			$__vars['step'] = '1';
			$__finalCompiled .= '

            ';
			if ($__vars['definition']['match_params']['number_integer']) {
				$__finalCompiled .= '
                ';
				if ($__vars['definition']['match_params']['number_min'] >= 0) {
					$__finalCompiled .= '
                    ';
					$__vars['pattern'] = '\\d*';
					$__finalCompiled .= '
                ';
				}
				$__finalCompiled .= '
                ';
			} else {
				$__finalCompiled .= '
                ';
				$__vars['step'] = 'any';
				$__finalCompiled .= '
            ';
			}
			$__finalCompiled .= '
            ';
			if ($__vars['definition']['match_params']['number_min'] !== '') {
				$__finalCompiled .= '
                ';
				$__vars['min'] = $__vars['definition']['match_params']['number_min'];
				$__finalCompiled .= '
            ';
			}
			$__finalCompiled .= '
            ';
			if ($__vars['definition']['match_params']['number_max'] !== '') {
				$__finalCompiled .= '
                ';
				$__vars['max'] = $__vars['definition']['match_params']['number_max'];
				$__finalCompiled .= '
            ';
			}
			$__finalCompiled .= '

            ';
		} else if ($__templater->func('in_array', array($__vars['definition']['match_type'], array('regex', 'alphanumeric', ), ), false)) {
			$__finalCompiled .= '

            ';
			$__vars['type'] = 'text';
			$__finalCompiled .= '
            ';
			$__vars['pattern'] = (($__vars['definition']['match_type'] == 'regex') ? $__vars['definition']['match_params']['regex'] : '\\w+');
			$__finalCompiled .= '
            ';
			$__vars['title'] = $__templater->preEscaped('Please enter a value that matches the required format.');
			$__finalCompiled .= '

            ';
		} else if ($__templater->func('in_array', array($__vars['definition']['match_type'], array('date', 'email', 'url', 'color', ), ), false)) {
			$__finalCompiled .= '

            ';
			$__vars['type'] = $__vars['definition']['match_type'];
			$__finalCompiled .= '

            ';
		} else {
			$__finalCompiled .= '

            ';
			$__vars['type'] = 'text';
			$__finalCompiled .= '

        ';
		}
		$__finalCompiled .= '

        ';
		if ($__vars['type'] === 'number') {
			$__finalCompiled .= '
            ' . $__templater->formTextBox(array(
				'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . '][from]',
				'value' => $__vars['set'][$__vars['definition']['field_id']]['from'],
				'type' => $__vars['type'],
				'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
				'pattern' => $__vars['pattern'],
				'title' => $__vars['title'],
				'min' => $__vars['min'],
				'max' => $__vars['max'],
				'step' => $__vars['step'],
				'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
				'class' => 'field_' . $__vars['definition']['field_id'],
				'placeholder' => ' ' . 'From...' . ' ',
			)) . '

            <span class="inputGroup-splitter"></span>

            ' . $__templater->formTextBox(array(
				'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . '][to]',
				'value' => $__vars['set'][$__vars['definition']['field_id']]['to'],
				'type' => $__vars['type'],
				'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
				'pattern' => $__vars['pattern'],
				'title' => $__vars['title'],
				'min' => $__vars['min'],
				'max' => $__vars['max'],
				'step' => $__vars['step'],
				'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
				'class' => 'field_' . $__vars['definition']['field_id'],
				'placeholder' => ' ' . 'To...' . ' ',
			)) . '
            ';
		} else {
			$__finalCompiled .= '
            ' . $__templater->formTextBox(array(
				'name' => $__vars['namePrefix'] . '[' . $__vars['definition']['field_id'] . ']',
				'value' => $__vars['set'][$__vars['definition']['field_id']],
				'type' => $__vars['type'],
				'maxlength' => ($__vars['definition']['max_length'] ? $__vars['definition']['max_length'] : ''),
				'pattern' => $__vars['pattern'],
				'title' => $__vars['title'],
				'min' => $__vars['min'],
				'max' => $__vars['max'],
				'step' => $__vars['step'],
				'required' => ($__templater->method($__vars['definition'], 'isRequired', array($__vars['editMode'], )) ? 'required' : ''),
				'class' => 'field_' . $__vars['definition']['field_id'],
			)) . '
        ';
		}
		$__finalCompiled .= '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '
' . '

' . '

' . '

' . '

' . '

' . '
';
	return $__finalCompiled;
}
);