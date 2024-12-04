<?php
// FROM HASH: 9fb290519b5734c5ee5ffbe351865547
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['creditPackage'], 'isInsert', array())) {
		$__compilerTemp1 .= '
		' . 'Add credit package' . '
		';
	} else {
		$__compilerTemp1 .= '
		' . 'Edit credit package' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['creditPackage']['title']) . '
	';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['profiles'])) {
		foreach ($__vars['profiles'] AS $__vars['profileId'] => $__vars['profile']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['profileId'],
				'label' => (($__vars['profile']['Provider']['title'] !== $__vars['profile']['title']) ? (($__templater->escape($__vars['profile']['Provider']['title']) . ' - ') . $__templater->escape($__vars['profile']['title'])) : $__templater->escape($__vars['profile']['Provider']['title'])),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = $__templater->mergeChoiceOptions(array(), $__vars['userGroups']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
		' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['creditPackage']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['creditPackage'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['creditPackage']['description'],
		'autosize' => 'true',
	), array(
		'label' => 'Description',
		'hint' => 'You may use HTML',
	)) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => ($__vars['creditPackage']['display_order'] ?: 1),
	), $__vars) . '

			' . $__templater->formRow('

				<div class="inputGroup">
					' . $__templater->formTextBox(array(
		'name' => 'cost_amount',
		'value' => ($__vars['creditPackage']['cost_amount'] ?: 5),
		'style' => 'width: 120px',
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->callMacro('public:currency_macros', 'currency_list', array(
		'value' => ($__vars['creditPackage']['cost_currency'] ?: 'USD'),
		'class' => 'input--autoSize',
	), $__vars) . '
				</div>

				<div class="formRow-explain">' . '<strong>Note:</strong> Ensure your merchant account with the selected payment profiles supports the above currencies. Currency support may vary by region.' . '</div>
			', array(
		'rowtype' => 'input',
		'label' => 'Cost',
	)) . '
			
			' . $__templater->formNumberBoxRow(array(
		'name' => 'credits',
		'min' => '1',
		'step' => '1',
		'value' => $__vars['creditPackage']['credits'],
	), array(
		'label' => 'Credits',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'length_type',
	), array(array(
		'value' => 'permanent',
		'selected' => $__vars['creditPackage']['length_unit'] == '',
		'label' => 'Permanent',
		'_type' => 'option',
	),
	array(
		'value' => 'timed',
		'selected' => $__vars['creditPackage']['length_unit'] != '',
		'label' => 'For length' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array('
						<div class="inputGroup">
							' . $__templater->formNumberBox(array(
		'name' => 'length_amount',
		'value' => ($__vars['creditPackage']['length_amount'] ?: 1),
		'min' => '1',
	)) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->formSelect(array(
		'name' => 'length_unit',
		'value' => ((($__vars['creditPackage']['length_unit'] == 'permanent') OR (!$__vars['creditPackage']['length_amount'])) ? 'months' : $__vars['upgrade']['length_unit']),
		'class' => 'input--inline',
	), array(array(
		'value' => 'day',
		'label' => 'Days',
		'_type' => 'option',
	),
	array(
		'value' => 'month',
		'label' => 'Months',
		'_type' => 'option',
	),
	array(
		'value' => 'year',
		'label' => 'Years',
		'_type' => 'option',
	))) . '
						</div>

					'),
		'_type' => 'option',
	)), array(
		'label' => 'Expire after',
	)) . '

			' . $__templater->formCheckBoxRow(array(
		'name' => 'payment_profile_ids',
		'value' => $__vars['creditPackage']['payment_profile_ids'],
	), $__compilerTemp2, array(
		'label' => 'Payment profile',
	)) . '

			' . $__templater->formCheckBoxRow(array(
		'name' => 'extra_group_ids',
		'value' => $__vars['creditPackage']['extra_group_ids'],
		'listclass' => 'listColumns',
	), $__compilerTemp3, array(
		'label' => 'Additional user groups',
		'explain' => 'Puts the user in the selected groups while the upgrade is active.',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'can_purchase',
		'selected' => $__vars['creditPackage']['can_purchase'],
		'label' => 'Can be purchased',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'ajax' => '1',
		'class' => 'block',
		'action' => $__templater->func('link', array('thtc-credit-package/save', $__vars['creditPackage'], ), false),
	));
	return $__finalCompiled;
}
);