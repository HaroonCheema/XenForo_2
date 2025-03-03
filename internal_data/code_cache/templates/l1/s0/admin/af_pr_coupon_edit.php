<?php
// FROM HASH: 14d690b00df0d4d6d41c8c3ad4759e78
return array(
'macros' => array('dateTimeInputRow' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'label' => '',
		'name' => '!',
		'date' => '!',
		'data' => '!',
		'withRow' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

    ';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['data']['hours'])) {
		foreach ($__vars['data']['hours'] AS $__vars['hour']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['hour'],
				'label' => $__templater->escape($__vars['hour']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['data']['minutes'])) {
		foreach ($__vars['data']['minutes'] AS $__vars['minute']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['minute'],
				'label' => $__templater->escape($__vars['minute']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = $__templater->mergeChoiceOptions(array(), $__vars['data']['timeZones']);
	$__vars['inner'] = $__templater->preEscaped('
        <div class="inputGroup-container">
            <div class="inputGroup">
                ' . $__templater->formDateInput(array(
		'name' => $__vars['name'] . '[ymd]',
		'value' => $__vars['date']['picker'],
	)) . '
                <span class="inputGroup-text">
                    ' . 'Time' . $__vars['xf']['language']['label_separator'] . '
                </span>
                <span class="inputGroup" dir="ltr">
                    ' . $__templater->formSelect(array(
		'name' => $__vars['name'] . '[hh]',
		'value' => $__vars['date']['hh'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp1) . '
                    <span class="inputGroup-text">:</span>
                    ' . $__templater->formSelect(array(
		'name' => $__vars['name'] . '[mm]',
		'value' => $__vars['date']['mm'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp2) . '
                </span>
            </div>

            <div class="inputGroup">
                <span class="inputGroup-text">' . 'Timezone' . $__vars['xf']['language']['label_separator'] . '</span>
                ' . $__templater->formSelect(array(
		'name' => $__vars['name'] . '[timezone]',
		'value' => ($__vars['date']['timezone'] ? $__vars['date']['timezone'] : $__vars['xf']['visitor']['timezone']),
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp3) . '
            </div>
        </div>
    ');
	$__finalCompiled .= '

    ';
	if ($__vars['withRow']) {
		$__finalCompiled .= '
        ' . $__templater->formRow('
            ' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
        ', array(
			'label' => $__templater->escape($__vars['label']),
		)) . '
    ';
	} else {
		$__finalCompiled .= '
        ' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'checkbox_columns' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'label' => '!',
		'id' => '!',
		'options' => '!',
		'selected' => '!',
		'selectedText' => '!',
		'withRow' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

    ';
	$__vars['allSelected'] = (($__templater->func('array_keys', array($__vars['options'], ), false) == $__vars['selected']) OR $__templater->func('in_array', array('-1', $__vars['selected'], ), false));
	$__finalCompiled .= '

    ';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['options'])) {
		foreach ($__vars['options'] AS $__vars['key'] => $__vars['value']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['key'],
				'selected' => ($__templater->func('in_array', array($__vars['key'], $__vars['selected'], ), false) OR $__vars['allSelected']),
				'label' => '
                                ' . $__templater->escape($__vars['value']) . '
                            ',
				'_type' => 'option',
			);
		}
	}
	$__vars['inner'] = $__templater->preEscaped('
        ' . $__templater->formRadio(array(
		'name' => $__vars['id'],
		'id' => $__vars['id'],
	), array(array(
		'value' => 'all',
		'selected' => $__vars['allSelected'],
		'label' => 'All',
		'_type' => 'option',
	),
	array(
		'value' => 'sel',
		'selected' => !$__vars['allSelected'],
		'label' => $__templater->escape($__vars['selectedText']),
		'_dependent' => array('
                    ' . $__templater->formCheckBox(array(
		'name' => ($__vars['id'] . '_ids'),
		'listclass' => 'listColumns',
	), $__compilerTemp1) . '

                    ' . $__templater->formCheckBox(array(
	), array(array(
		'data-xf-init' => 'check-all',
		'data-container' => ('#' . $__vars['id']),
		'label' => 'Select all',
		'_type' => 'option',
	))) . '
                '),
		'_type' => 'option',
	))) . '
    ');
	$__finalCompiled .= '

    ';
	if ($__vars['withRow']) {
		$__finalCompiled .= '
        ' . $__templater->formRow('
            ' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
        ', array(
			'label' => $__templater->escape($__vars['label']),
			'name' => $__vars['id'],
			'id' => $__vars['id'],
		)) . '
    ';
	} else {
		$__finalCompiled .= '
        ' . $__templater->filter($__vars['inner'], array(array('raw', array()),), true) . '
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
	if ($__templater->method($__vars['coupon'], 'isInsert', array())) {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add coupon');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit coupon' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['coupon']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['coupon'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('', array(
			'href' => $__templater->func('link', array('paid-registrations/coupons/delete', $__vars['coupon'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
    <div class="block-container">
        <div class="block-body">

            ' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['coupon']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['coupon'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

            ' . $__templater->formTextBoxRow(array(
		'name' => 'coupon_code',
		'value' => $__vars['coupon']['coupon_code'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['coupon'], 'coupon_code', ), false),
	), array(
		'label' => 'Coupon code',
		'explain' => 'Case sensitive',
	)) . '

            ' . $__templater->formRadioRow(array(
		'name' => 'discount_type',
		'value' => $__vars['coupon']['discount_type'],
	), array(array(
		'value' => 'flat',
		'label' => 'Flat amount',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'discount_value',
		'value' => (($__vars['coupon']['discount_type'] == 'flat') ? $__templater->filter($__vars['coupon']['discount_value'], array(array('number', array(2, )),), false) : ''),
		'size' => '6',
		'class' => 'input--inline',
	))),
		'_type' => 'option',
	),
	array(
		'value' => 'percent',
		'label' => 'Percentage',
		'_dependent' => array('
                        <div class="inputGroup">
                            ' . $__templater->formTextBox(array(
		'name' => 'discount_value',
		'value' => (($__vars['coupon']['discount_type'] == 'percent') ? $__vars['coupon']['discount_value'] : ''),
		'size' => '6',
		'class' => 'input--inline',
	)) . '
                            <span class="inputGroup-text">%</span>
                        </div>
                    '),
		'_type' => 'option',
	)), array(
		'label' => 'Discount type',
	)) . '

            ' . $__templater->formRadioRow(array(
		'name' => 'unlimited_uses',
		'value' => $__vars['coupon']['unlimited_uses'],
	), array(array(
		'value' => '1',
		'label' => 'Unlimited',
		'_type' => 'option',
	),
	array(
		'value' => '0',
		'label' => 'Limited',
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'uses_remaining',
		'value' => ($__vars['coupon']['unlimited_uses'] ? '' : $__vars['coupon']['uses_remaining']),
		'min' => '0',
		'autocomplete' => 'off',
	))),
		'_type' => 'option',
	)), array(
		'label' => 'Uses',
	)) . '

            ' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'selected' => $__vars['coupon']['active'],
		'label' => 'Enabled',
		'_type' => 'option',
	)), array(
	)) . '

            <hr class="formRowSep" />

            ' . $__templater->callMacro(null, 'dateTimeInputRow', array(
		'label' => 'Start date',
		'name' => 'start_date',
		'date' => $__vars['coupon']['start_date_data'],
		'data' => $__vars['data'],
	), $__vars) . '

            ' . $__templater->formRow('
                ' . $__templater->formRadio(array(
		'name' => 'end_date_type',
		'value' => ((!$__vars['coupon']['end_date']) ? 'never' : 'sel'),
	), array(array(
		'value' => 'never',
		'label' => 'Never',
		'_type' => 'option',
	),
	array(
		'value' => 'sel',
		'label' => 'Date / time',
		'_dependent' => array('
                            ' . $__templater->callMacro(null, 'dateTimeInputRow', array(
		'name' => 'end_date',
		'date' => $__vars['coupon']['end_date_data'],
		'data' => $__vars['data'],
		'withRow' => '0',
	), $__vars) . '
                        '),
		'_type' => 'option',
	))) . '
            ', array(
		'label' => 'End date',
	)) . '

            <hr class="formRowSep" />

            ' . $__templater->callMacro('helper_user_group_edit', 'checkboxes', array(
		'label' => 'User groups allowed',
		'id' => 'user_group',
		'selectedUserGroups' => ($__templater->method($__vars['coupon'], 'isInsert', array()) ? array(-1, ) : $__vars['coupon']['user_group_ids']),
	), $__vars) . '

            ' . $__templater->callMacro(null, 'checkbox_columns', array(
		'label' => 'Account types allowed',
		'id' => 'account_type',
		'options' => $__vars['accountTypeTitlePairs'],
		'selected' => ($__templater->method($__vars['coupon'], 'isInsert', array()) ? array(-1, ) : $__vars['coupon']['account_type_ids']),
		'selectedText' => 'Selected account types' . $__vars['xf']['language']['label_separator'],
	), $__vars) . '

        </div>

        ' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '

    </div>
', array(
		'action' => $__templater->func('link', array('paid-registrations/coupons/save', $__vars['coupon'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	)) . '

' . '

';
	return $__finalCompiled;
}
);