<?php
// FROM HASH: a44cbb78f71e984cac26eebe767ba2a4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Gift upgrade to ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__vars['breadcrumbs']);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['isWarnedContent'] AND (!$__vars['xf']['options']['nfDisplayGiftingOnWarnedContent'])) {
		$__compilerTemp1 .= '
				<div class="block-rowMessage block-rowMessage--warning">
					' . 'This content has a warning attached, and will not display that it has received a gift upgrade.<br/><br/>
The user will still receive the selected upgrade.' . '
				</div>
			';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['upgrades'], 'count', array()) === 1) {
		$__compilerTemp2 .= '
				';
		$__vars['upgrade'] = $__templater->method($__vars['upgrades'], 'first', array());
		$__compilerTemp2 .= '
				';
		$__compilerTemp3 = '';
		if (($__vars['upgrade']['cost_amount'] == '0.00') AND $__templater->func('is_addon_active', array('SV/UserEssentials', ), false)) {
			$__compilerTemp3 .= '
						' . $__templater->escape($__vars['upgrade']['title']) . ' 
						' . $__templater->includeTemplate('sv_ue_account_upgrades_cost_input', $__vars) . '
					';
		} else {
			$__compilerTemp3 .= '
						' . $__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__templater->method($__vars['upgrade'], 'getGiftCostPhrase', array())) . ')
					';
		}
		$__compilerTemp4 = '';
		if (($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) > 1)) {
			$__compilerTemp4 .= '
						';
			$__compilerTemp5 = array(array(
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
				foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
					$__compilerTemp5[] = array(
						'value' => $__vars['profileId'],
						'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp4 .= $__templater->formSelect(array(
				'name' => 'payment_profile_id',
			), $__compilerTemp5) . '
						';
		} else {
			$__compilerTemp4 .= '
						' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['upgrade']['payment_profile_ids'], array(array('first', array()),), false), array(
			)) . '
					';
		}
		$__compilerTemp2 .= $__templater->formRow('					
					' . $__compilerTemp3 . '
					' . $__compilerTemp4 . '
					' . $__templater->formHiddenVal('user_upgrade_id', $__templater->arrayKey($__templater->method($__vars['upgrades'], 'first', array()), 'user_upgrade_id'), array(
		)) . '
				', array(
			'label' => 'Upgrade',
		)) . '
			';
	} else {
		$__compilerTemp2 .= '
				';
		$__compilerTemp6 = array();
		if ($__templater->isTraversable($__vars['upgrades'])) {
			foreach ($__vars['upgrades'] AS $__vars['upgrade']) {
				$__compilerTemp7 = '';
				if (($__vars['upgrade']['cost_amount'] == '0.00') AND $__templater->func('is_addon_active', array('SV/UserEssentials', ), false)) {
					$__compilerTemp7 .= '
									' . $__templater->includeTemplate('sv_ue_account_upgrades_cost_input', $__vars) . '
								';
				}
				$__compilerTemp8 = '';
				if (($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) > 1)) {
					$__compilerTemp8 .= '
									';
					$__compilerTemp9 = array(array(
						'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
						'_type' => 'option',
					));
					if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
						foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
							$__compilerTemp9[] = array(
								'value' => $__vars['profileId'],
								'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
								'_type' => 'option',
							);
						}
					}
					$__compilerTemp8 .= $__templater->formSelect(array(
						'name' => 'payment_profile_id',
					), $__compilerTemp9) . '
								';
				} else {
					$__compilerTemp8 .= '
									' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['upgrade']['payment_profile_ids'], array(array('first', array()),), false), array(
					)) . '
								';
				}
				$__compilerTemp6[] = array(
					'value' => $__vars['upgrade']['user_upgrade_id'],
					'label' => $__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__templater->method($__vars['upgrade'], 'getGiftCostPhrase', array())) . ')',
					'selected' => ($__vars['upgrade']['user_upgrade_id'] === $__vars['selectedUpgradeId']),
					'data-hide' => 'True',
					'_dependent' => array('
								' . $__compilerTemp7 . '
								' . $__compilerTemp8 . '								
							'),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp2 .= $__templater->formRadioRow(array(
			'name' => 'user_upgrade_id',
		), $__compilerTemp6, array(
			'label' => 'Upgrade',
		)) . '
			';
	}
	$__compilerTemp10 = array(array(
		'name' => 'anonymous',
		'label' => 'Send gift anonymously',
		'hint' => 'Checking this option will not reveal your identity to the user you are gifting.',
		'_type' => 'option',
	));
	if ($__templater->method($__vars['xf']['visitor'], 'canGiftForFree', array())) {
		$__compilerTemp10[] = array(
			'name' => 'gift_for_free',
			'label' => 'Gift for free',
			'hint' => 'Checking this will bestow this upgrade upon the user but won\'t charge them or you for it.',
			'_type' => 'option',
		);
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			' . $__compilerTemp2 . '

			' . $__templater->formCheckBoxRow(array(
	), $__compilerTemp10, array(
	)) . '
			
			' . $__templater->formHiddenVal('confirmed', '1', array(
	)) . '
			' . $__templater->formHiddenVal('gift', '1', array(
	)) . '
			' . $__templater->formHiddenVal('username', $__vars['user']['username'], array(
	)) . '
			' . $__templater->formHiddenVal('gift_to_user_id', $__vars['user']['user_id'], array(
	)) . '
			' . $__templater->formHiddenVal('content_id', $__templater->method($__vars['content'], 'getEntityId', array()), array(
	)) . '
			' . $__templater->formHiddenVal('content_type', $__templater->method($__vars['content'], 'getEntityContentType', array()), array(
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('purchase', array('purchasable_type_id' => 'user_upgrade', ), ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);