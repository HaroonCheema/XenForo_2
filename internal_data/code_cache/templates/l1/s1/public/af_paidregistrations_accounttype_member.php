<?php
// FROM HASH: 162641b97eb416dfe45159f015ae1b58
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account upgrades');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/payment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->inlineCss('
    .accountType-title .priceContainer {
        font-size: ' . $__vars['xf']['options']['af_paidregistrations_priceFontSize'] . ';
    }
    .accountType {
        margin-top: 0;
        margin-left: ' . $__vars['xf']['options']['af_paidregistrations_box_margin'] . ';
        margin-right: ' . $__vars['xf']['options']['af_paidregistrations_box_margin'] . ';
    }
    @media (max-width: ' . $__templater->func('property', array('responsiveWide', ), false) . ')
    {
        .accountType {
            margin-left: auto;
            margin-right: auto;
        }
    }
    .accountTypesRow .accountType:first-child {
        margin-left: 0;
    }
    .accountTypesRow .accountType:last-child {
        margin-right: 0;
    }
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '

        ';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
                ' . $__templater->callMacro('af_paidregistrations_accounttype_macros', 'account_types', array(
		'accountTypeRows' => $__vars['accountTypeRows'],
	), $__vars) . '
            ';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
            <div class="block" style="margin-bottom: 0;">
                <div class="block-container">
                    <h2 class="block-header">' . 'Available upgrades' . '</h2>
                </div>
            </div>
            ' . $__compilerTemp2 . '
        ';
	}
	$__compilerTemp1 .= '

        ';
	$__templater->inlineCss('
            .button.button--icon--gift > .button-text::before {
                content: "\\f06b";
                display: inline-block;
                width: 0.89em;
            }
        ');
	$__compilerTemp1 .= '

        ';
	if ($__vars['xf']['options']['af_paidregistrations_gift_upgrades']) {
		$__compilerTemp1 .= '
            ' . $__templater->form('
                <div class="block-container">
                    <h2 class="block-header">
                        <span class="collapseTrigger collapseTrigger--block ' . ((!$__templater->func('is_toggled', array('collapse_afpr_gift', ), false)) ? 'is-active' : '') . '" data-xf-click="toggle" data-xf-init="toggle-storage" data-storage-key="collapse_afpr_gift" data-storage-type="cookie" data-target="#js-collapse_afpr_gift">
                            ' . 'Gift Upgrade' . '
                        </span>
                    </h2>
                    <div class="block-body block-body--collapsible ' . ((!$__templater->func('is_toggled', array('collapse_afpr_gift', ), false)) ? 'is-active' : '') . '" id="js-collapse_afpr_gift">
                        ' . $__templater->formRow('
                            <div class="inputGroup">
                                ' . $__templater->formTextBox(array(
			'name' => 'username',
			'ac' => 'single',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		)) . '
                                ' . $__templater->button('Proceed' . $__vars['xf']['language']['ellipsis'], array(
			'type' => 'submit',
			'icon' => 'gift',
			'class' => 'button--primary',
		), '', array(
		)) . '
                            </div>
                        ', array(
			'rowtype' => 'input',
			'label' => 'Username',
			'explain' => 'Enter the username of the user you want to gift an account upgrade.',
		)) . '
                    </div>
                </div>
            ', array(
			'action' => $__templater->func('link', array('purchase/gift-upgrade', ), false),
			'method' => 'get',
			'class' => 'block',
		)) . '
        ';
	}
	$__compilerTemp1 .= '

        ';
	if (!$__templater->test($__vars['purchased'], 'empty', array())) {
		$__compilerTemp1 .= '
            <div class="block">
                <div class="block-container">
                    <h2 class="block-header">' . 'Purchased upgrades' . '</h2>

                    <ul class="block-body listPlain">
                        ';
		if ($__templater->isTraversable($__vars['purchased'])) {
			foreach ($__vars['purchased'] AS $__vars['upgrade']) {
				$__compilerTemp1 .= '
                            <li>
                                <div>
                                    ';
				$__vars['active'] = $__vars['upgrade']['Active'][$__vars['xf']['visitor']['user_id']];
				$__compilerTemp1 .= '
                                    ';
				$__compilerTemp3 = '';
				if ($__vars['active']['end_date']) {
					$__compilerTemp3 .= '
                                            ' . 'Expires' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['active']['end_date'], array(
					))) . '
                                        ';
				} else {
					$__compilerTemp3 .= '
                                            ' . 'Expires: Never' . '
                                        ';
				}
				$__compilerTemp4 = '';
				$__compilerTemp5 = '';
				$__compilerTemp5 .= '
                                                    ';
				if ($__templater->method($__vars['upgrade'], 'canExtendUpgrade', array())) {
					$__compilerTemp5 .= '
                                                        <div>
                                                            ' . $__templater->button('
                                                                ' . 'Extend' . '
                                                            ', array(
						'href' => $__templater->func('link', array('account/upgrade-payment-options', null, array('extend' => 1, 'userUpgradeId' => $__vars['upgrade']['user_upgrade_id'], ), ), false),
						'overlay' => 'true',
						'target' => '_blank',
					), '', array(
					)) . '
                                                        </div>
                                                    ';
				}
				$__compilerTemp5 .= '

                                                    ';
				if ($__vars['upgrade']['length_unit'] AND ($__vars['upgrade']['recurring'] AND $__vars['active']['PurchaseRequest'])) {
					$__compilerTemp5 .= '
                                                        ';
					$__vars['provider'] = $__vars['active']['PurchaseRequest']['PaymentProfile']['Provider'];
					$__compilerTemp5 .= '
                                                        ' . $__templater->filter($__templater->method($__vars['provider'], 'renderCancellation', array($__vars['active'], )), array(array('raw', array()),), true) . '
                                                    ';
				}
				$__compilerTemp5 .= '
                                                ';
				if (strlen(trim($__compilerTemp5)) > 0) {
					$__compilerTemp4 .= '
                                            <div class="afprUserUpgradeButtonGroup">
                                                ' . $__compilerTemp5 . '
                                            </div>
                                        ';
				}
				$__compilerTemp1 .= $__templater->formRow('

                                        ' . $__compilerTemp3 . '

                                        ' . $__compilerTemp4 . '
                                    ', array(
					'rowclass' => 'formRow--noColon',
					'label' => $__templater->escape($__vars['upgrade']['title']),
					'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
					'explain' => $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true),
				)) . '
                                </div>
                            </li>
                        ';
			}
		}
		$__compilerTemp1 .= '
                    </ul>
                </div>
            </div>
        ';
	}
	$__compilerTemp1 .= '
    ';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
    ' . $__compilerTemp1 . '
';
	} else {
		$__finalCompiled .= '
    <div class="blockMessage">' . 'There are currently no purchasable user upgrades.' . '</div>
';
	}
	$__finalCompiled .= '

';
	$__templater->inlineCss('
    .afprUserUpgradeButtonGroup > div
    {
        display: inline-block;
    }
');
	$__finalCompiled .= '



';
	return $__finalCompiled;
}
);