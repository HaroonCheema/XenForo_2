<?php
// FROM HASH: d2f0e0db66a6e9664b6082d3535e9afa
return array(
'macros' => array('upgradeMessage' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    by&nbsp;<a href="https://www.addonflare.com/xenforo-2-addons/paid-registrations.9/" target="_blank">upgrading to full version</a>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['accountType'], 'isInsert', array())) {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add ' . 'Account Type');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit ' . 'Account Type');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['accountType'], 'isUpdate', array()) AND $__vars['accountType']['for_deletion']) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('', array(
			'href' => $__templater->func('link', array('paid-registrations/delete', $__vars['accountType'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__templater->inlineCss('
    .inputGroup--color {
        width: 300px;
    }
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['accountType']['UserUpgrade']) {
		$__compilerTemp1 .= '
                    <a target="_blank" href="' . $__templater->func('link', array('user-upgrades/edit', $__vars['accountType']['UserUpgrade'], ), true) . '">' . $__templater->escape($__vars['accountType']['UserUpgrade']['title']) . ' (' . $__templater->escape($__vars['accountType']['UserUpgrade']['cost_phrase']) . ')</a>
                ';
	} else {
		$__compilerTemp1 .= '
                    ' . $__templater->escape($__vars['accountType']['title']) . '
                ';
	}
	$__compilerTemp2 = '';
	if ($__vars['accountType']['UserUpgrade']) {
		$__compilerTemp2 .= '
                ' . $__templater->formRadioRow(array(
			'name' => 'title_type',
			'value' => ($__vars['accountType']['custom_title'] ? 'custom' : 'default'),
		), array(array(
			'value' => 'default',
			'label' => $__templater->escape($__vars['accountType']['UserUpgrade']['title']),
			'_type' => 'option',
		),
		array(
			'value' => 'custom',
			'data-hide' => '',
			'label' => 'Custom title',
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'custom_title',
			'value' => $__vars['accountType']['custom_title'],
			'maxlength' => $__templater->func('max_length', array($__vars['accountType'], 'custom_title', ), false),
		))),
			'_type' => 'option',
		)), array(
			'label' => 'Title',
		)) . '
            ';
	}
	$__compilerTemp3 = '';
	if ($__vars['accountType']['user_upgrade_id'] != -1) {
		$__compilerTemp3 .= '

                ' . $__templater->callMacro('helper_user_group_edit', 'checkboxes', array(
			'label' => 'User groups allowed to purchase',
			'id' => 'purchase_user_group',
			'selectedUserGroups' => $__vars['accountType']['purchase_user_group_ids'],
		), $__vars) . '

                ';
		if ($__vars['accountType']['version']) {
			$__compilerTemp3 .= '
                    ' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'is_giftable',
				'selected' => $__vars['accountType']['is_giftable'],
				'label' => 'Yes',
				'_type' => 'option',
			)), array(
				'label' => 'Is Giftable',
				'explain' => 'Allow users to purchase as a gift?',
			)) . '

                    ' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => 'allow_custom_amount',
				'selected' => $__vars['accountType']['allow_custom_amount'],
				'label' => 'Yes',
				'data-xf-init' => 'disabler',
				'data-container' => '.js-hiderContainer',
				'data-hide' => 'yes',
				'data-invert' => 'true',
				'_dependent' => array('
                                    ' . $__templater->formTextBox(array(
				'name' => 'custom_amount_min',
				'class' => 'input--autoSize',
				'value' => $__vars['accountType']['custom_amount_min'],
			)) . '
                                    <p class="formRow-explain">' . 'Minimum amount' . '</p>
                                ', '
                                    ' . $__templater->formCheckBox(array(
			), array(array(
				'value' => '1',
				'label' => 'Disable For Guests',
				'name' => 'disable_custom_amount_guest',
				'selected' => $__vars['accountType']['disable_custom_amount_guest'],
				'_type' => 'option',
			))) . '
                                '),
				'_type' => 'option',
			)), array(
				'label' => 'Allow Custom Amount',
				'explain' => 'NOTE: Enabling "Allow Custom Amount" will allow the user to pay any amount they choose for this upgrade. <br>
Useful for donation based upgrades',
			)) . '
                ';
		} else {
			$__compilerTemp3 .= '
                    ' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => '',
				'disabled' => 'disabled',
				'selected' => 0,
				'label' => 'Yes' . ' (Available ' . $__templater->callMacro(null, 'upgradeMessage', array(), $__vars) . ')',
				'_type' => 'option',
			)), array(
				'label' => 'Is Giftable',
				'explain' => 'Allow users to purchase as a gift?',
			)) . '
                    ' . $__templater->formHiddenVal('is_giftable', '1', array(
			)) . '
                    ' . $__templater->formCheckBoxRow(array(
			), array(array(
				'name' => '',
				'disabled' => 'disabled',
				'selected' => 0,
				'label' => 'Yes' . ' (Available ' . $__templater->callMacro(null, 'upgradeMessage', array(), $__vars) . ')',
				'_type' => 'option',
			)), array(
				'label' => 'Allow Custom Amount',
				'explain' => 'NOTE: Enabling "Allow Custom Amount" will allow the user to pay any amount they choose for this upgrade. <br>
Useful for donation based upgrades',
			)) . '
                ';
		}
		$__compilerTemp3 .= '

                <div class="js-hiderContainer">
                    <hr class="formRowSep" />
                    ';
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['accountType']['alias_user_upgrades'])) {
			foreach ($__vars['accountType']['alias_user_upgrades'] AS $__vars['counter'] => $__vars['alias']) {
				$__compilerTemp4 .= '
                                <li class="inputGroup" dir="ltr">
                                    ';
				$__compilerTemp5 = array(array(
					'label' => 'None',
					'_type' => 'option',
				));
				if ($__templater->isTraversable($__vars['upgrades'])) {
					foreach ($__vars['upgrades'] AS $__vars['user_upgrade_id'] => $__vars['upgrade']) {
						$__compilerTemp5[] = array(
							'value' => $__vars['user_upgrade_id'],
							'label' => $__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__vars['upgrade']['cost_phrase']) . ($__vars['upgrade']['length_unit'] ? '' : (' ' . 'Permanent')) . ')',
							'_type' => 'option',
						);
					}
				}
				$__compilerTemp4 .= $__templater->formSelect(array(
					'name' => 'alias_user_upgrades[' . $__vars['counter'] . '][user_upgrade_id]',
					'value' => $__vars['alias']['user_upgrade_id'],
					'class' => 'input--autoSize',
				), $__compilerTemp5) . '
                                    <span class="inputGroup-splitter"></span>

                                    ' . $__templater->formCheckBox(array(
				), array(array(
					'name' => 'alias_user_upgrades[' . $__vars['counter'] . '][default]',
					'value' => '1',
					'selected' => $__vars['alias']['default'],
					'labelclass' => 'inputGroup-text',
					'label' => 'Default',
					'_type' => 'option',
				))) . '
                                </li>
                            ';
			}
		}
		$__compilerTemp6 = array(array(
			'label' => 'None',
			'_type' => 'option',
		));
		if ($__templater->isTraversable($__vars['upgrades'])) {
			foreach ($__vars['upgrades'] AS $__vars['user_upgrade_id'] => $__vars['upgrade']) {
				$__compilerTemp6[] = array(
					'value' => $__vars['user_upgrade_id'],
					'label' => $__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__vars['upgrade']['cost_phrase']) . ($__vars['upgrade']['length_unit'] ? '' : (' ' . 'Permanent')) . ')',
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp3 .= $__templater->formRow('

                        <ul class="listPlain inputGroup-container">
                            ' . $__compilerTemp4 . '
                            <li class="inputGroup" dir="ltr" data-xf-init="field-adder" data-clone-init="true" data-increment-format="alias_user_upgrades[{counter}]">
                                ' . $__templater->formSelect(array(
			'name' => 'alias_user_upgrades[' . $__vars['nextCounter'] . '][user_upgrade_id]',
			'value' => '',
			'class' => 'input--autoSize',
		), $__compilerTemp6) . '
                                <span class="inputGroup-splitter"></span>
                                <span class="inputGroup-text">
                                    ' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'alias_user_upgrades[' . $__vars['nextCounter'] . '][default]',
			'value' => '1',
			'label' => 'Default',
			'_type' => 'option',
		))) . '
                                </span>
                            </li>
                        </ul>
                    ', array(
			'rowtype' => 'input',
			'label' => 'Alias User Upgrades',
			'explain' => 'Aliases are useful if you have several combinations of the same user upgrade  (different lenghts, recurrring/non-recurring, etc) and you want to display all the options in one place for the user to choose.<br><br>

You may add as many user upgrade aliases as you like. User upgrades set to "None" will be ignored.',
		)) . '
                </div>
            ';
	}
	$__compilerTemp7 = '';
	if ($__vars['accountType']['for_deletion']) {
		$__compilerTemp7 .= '
                ' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'active',
			'selected' => $__vars['accountType']['active'],
			'label' => 'Yes',
			'_type' => 'option',
		)), array(
			'label' => 'Active',
		)) . '
            ';
	} else {
		$__compilerTemp7 .= '
                ' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => '',
			'disabled' => 'disabled',
			'selected' => 1,
			'label' => 'Yes' . ' (disable ' . $__templater->callMacro(null, 'upgradeMessage', array(), $__vars) . ')',
			'_type' => 'option',
		)), array(
			'label' => 'Active',
		)) . '
            ';
	}
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formRow('
                ' . $__compilerTemp1 . '
            ', array(
		'label' => 'User Upgrade',
	)) . '

            ' . $__compilerTemp2 . '

            ' . $__templater->formNumberBoxRow(array(
		'name' => 'row',
		'value' => ($__vars['accountType']['row'] ?: 1),
		'min' => '1',
		'step' => '1',
	), array(
		'label' => 'Row',
	)) . '

            ' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => ($__vars['accountType']['display_order'] ?: 5),
		'step' => '5',
	), $__vars) . '

            ' . $__templater->callMacro('public:color_picker_macros', 'color_picker', array(
		'name' => 'color',
		'value' => ($__vars['accountType']['color'] ?: $__templater->func('property', array('paletteColor4', ), false)),
		'allowPalette' => true,
		'label' => 'Color',
		'required' => true,
		'includeScripts' => true,
		'explain' => 'Color of the upgrade shown in the registration page',
	), $__vars) . '

            ' . $__templater->formTextAreaRow(array(
		'name' => 'features',
		'value' => $__vars['accountType']['features'],
		'code' => 'true',
		'autosize' => 'true',
	), array(
		'label' => 'Features',
		'explain' => '
                    These are shown in the registration page<br>
                    1 Per Line (HTML Allowed)
                ',
	)) . '

            ' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'is_featured',
		'selected' => $__vars['accountType']['is_featured'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Featured',
		'explain' => 'Display a "' . 'Featured' . '" badge for this upgrade?',
	)) . '

            ' . $__compilerTemp3 . '

            ' . $__compilerTemp7 . '

            ' . $__templater->formHiddenVal('user_upgrade_id', $__vars['accountType']['user_upgrade_id'], array(
	)) . '

        </div>
        ' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('paid-registrations/save', $__vars['accountType'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	)) . '

';
	return $__finalCompiled;
}
);