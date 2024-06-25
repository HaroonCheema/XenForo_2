<?php
// FROM HASH: c60ac2221047c919e5ea7461486e055a
return array(
'macros' => array('upgrade_option' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'upgrade' => '!',
		'profiles' => '!',
		'featured' => '',
		'redirect' => '',
		'coupon' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('thmonetize_upgrade_page.less');
	$__finalCompiled .= '
	';
	$__templater->includeCss('thmonetize_user_upgrade_cache.less');
	$__finalCompiled .= '
	<div class="thmonetize_UpgradeOption ' . ($__vars['featured'] ? 'thmonetize_UpgradeOption--featured' : '') . '">
		<div class="block-container thmonetize_upgrade thmonetize_upgrade--' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . ($__vars['upgrade']['thmonetize_style_properties']['color'] ? ' thmonetize_upgrade--hasColor' : '') . '">
			<div class="block-header thmonetize_upgradeHeader' . ($__vars['upgrade']['thmonetize_style_properties']['shape'] ? (' thmonetize_upgradeHeader--shape thmonetize_upgradeHeader--' . $__templater->escape($__vars['upgrade']['thmonetize_style_properties']['shape'])) : '') . '">
				<h2 class="thmonetize_upgradeTitle">' . $__templater->escape($__vars['upgrade']['title']) . '</h2>
				<div class="thmonetize_upgradeHeader__price">
					<span class="thmonetize_upgradeHeader__priceRow">
						';
	if (($__vars['xf']['language']['currency_format'] === '{symbol}{value}') OR ($__vars['xf']['language']['currency_format'] === '{symbol} {value}')) {
		$__finalCompiled .= '
							<span class="thmonetize_upgrade__currency">' . $__templater->escape($__vars['upgrade']['thmonetize_cost_currency_symbol']) . '</span>
						';
	}
	$__finalCompiled .= '
						<span class="thmonetize_upgrade__price">' . $__templater->escape($__vars['upgrade']['thmonetize_cost_amount_formatted']) . '</span>
						';
	if (!($__vars['xf']['language']['currency_format'] === '{symbol}{value}') OR ($__vars['xf']['language']['currency_format'] === '{symbol} {value}')) {
		$__finalCompiled .= '
							<span class="thmonetize_upgrade__currency">' . $__templater->escape($__vars['upgrade']['thmonetize_cost_currency_symbol']) . '</span>
						';
	}
	$__finalCompiled .= '
						';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= $__templater->escape($__vars['upgrade']['thmonetize_length_phrase_short']);
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
							<span class="thmonetize_upgrade__occurrence">/' . $__compilerTemp1 . '</span>
						';
	}
	$__finalCompiled .= '
					</span>
					<span class="thmonetize_upgrade__length">' . $__templater->escape($__vars['upgrade']['thmonetize_length_phrase_long']) . '</span>
				</div>
				<div class="thmonetize_purchase">
					';
	if (!$__templater->method($__vars['upgrade'], 'canPurchase', array())) {
		$__finalCompiled .= '
						';
		$__vars['active'] = $__vars['upgrade']['Active'][$__vars['xf']['visitor']['user_id']];
		$__finalCompiled .= '
						';
		if ($__vars['upgrade']['length_unit'] AND ($__vars['upgrade']['recurring'] AND $__vars['active']['PurchaseRequest'])) {
			$__finalCompiled .= '
							';
			$__vars['provider'] = $__vars['active']['PurchaseRequest']['PaymentProfile']['Provider'];
			$__finalCompiled .= '
							' . $__templater->filter($__templater->method($__vars['provider'], 'renderCancellation', array($__vars['active'], )), array(array('raw', array()),), true) . '
						';
		}
		$__finalCompiled .= '
						';
	} else {
		$__finalCompiled .= '
						';
		$__compilerTemp2 = '';
		if (($__templater->func('count', array($__vars['upgrade']['payment_profile_ids'], ), false) > 1)) {
			$__compilerTemp2 .= '
								';
			$__compilerTemp3 = array(array(
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'Choose a payment method' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['upgrade']['payment_profile_ids'])) {
				foreach ($__vars['upgrade']['payment_profile_ids'] AS $__vars['profileId']) {
					$__compilerTemp3[] = array(
						'value' => $__vars['profileId'],
						'label' => $__templater->escape($__vars['profiles'][$__vars['profileId']]),
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp2 .= $__templater->formSelect(array(
				'name' => 'payment_profile_id',
			), $__compilerTemp3) . '

								<span class="inputGroup-splitter"></span>
								';
		} else {
			$__compilerTemp2 .= '
								' . $__templater->formHiddenVal('payment_profile_id', $__templater->filter($__vars['upgrade']['payment_profile_ids'], array(array('first', array()),), false), array(
			)) . '
							';
		}
		$__compilerTemp4 = '';
		if (($__vars['upgrade']['cost_amount'] == 0) AND (!$__vars['xf']['options']['thmonetize_requireUserUpgradeOnRegistration'])) {
			$__compilerTemp4 .= '
								<a href="' . $__templater->func('link', array('account', ), true) . '" class="button button--fullWidth">' . 'Free account' . '</a>
							';
		} else if ($__vars['coupon']) {
			$__compilerTemp4 .= '
								' . $__templater->button('', array(
				'type' => 'submit',
				'button' => 'Purchase with ' . $__vars['coupon']['code'] . '',
				'icon' => 'purchase',
				'class' => 'button--cta button--fullWidth',
			), '', array(
			)) . '
							';
		} else {
			$__compilerTemp4 .= '
								' . $__templater->button('', array(
				'type' => 'submit',
				'icon' => 'purchase',
				'class' => 'button--cta button--fullWidth',
			), '', array(
			)) . '
							';
		}
		$__compilerTemp5 = '';
		if ($__templater->func('is_addon_active', array('NF/GiftUpgrades', ), false)) {
			$__compilerTemp5 .= '
								';
			if ($__templater->method($__vars['upgrade'], 'canGift', array())) {
				$__compilerTemp5 .= '
									';
				if ($__templater->method($__vars['upgrade'], 'canPurchase', array())) {
					$__compilerTemp5 .= '<span class="inputGroup-splitter"></span>';
				}
				$__compilerTemp5 .= '
									' . $__templater->button('Gift', array(
					'class' => 'button--cta button--fullWidth',
					'type' => 'submit',
					'name' => 'gift',
					'value' => '1',
					'icon' => 'nfgift',
				), '', array(
				)) . '
								';
			}
			$__compilerTemp5 .= '
							';
		}
		$__finalCompiled .= $__templater->form('
							' . $__templater->formHiddenVal('_xfRedirect', $__vars['redirect'], array(
		)) . '
							' . $__compilerTemp2 . '

							' . $__compilerTemp4 . '
							' . $__compilerTemp5 . '
						', array(
			'action' => $__templater->func('link', array('purchase', $__vars['upgrade'], array('user_upgrade_id' => $__vars['upgrade']['user_upgrade_id'], ), ), false),
			'ajax' => 'true',
			'data-xf-init' => 'payment-provider-container',
		)) . '
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
			<div class="block-body">
				';
	if ($__vars['upgrade']['description']) {
		$__finalCompiled .= '
					<div class="block-row">
						<span>' . $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true) . '</span>
					</div>
				';
	}
	$__finalCompiled .= '
				<div class="block-row">
					' . $__templater->callMacro(null, 'features', array(
		'features' => $__vars['upgrade']['thmonetize_features'],
		'upgrade' => $__vars['upgrade'],
		'styleProperties' => $__vars['upgrade']['thmonetize_style_properties'],
	), $__vars) . '
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'upgrade_options' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'upgradePage' => '!',
		'upgrades' => '!',
		'profiles' => '!',
		'showFree' => false,
		'filter' => '',
		'showFilters' => '',
		'redirect' => '',
		'coupons' => '',
		'coupon' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('thmonetize_upgrade_page.less');
	$__finalCompiled .= '

	';
	if ($__vars['xf']['options']['thmonetize_allowFreeUpgrade'] AND ($__vars['showFree'] AND ($__vars['xf']['visitor']['user_id'] AND ($__vars['xf']['visitor']['user_state'] == 'thmonetize_upgrade')))) {
		$__finalCompiled .= '
		<div class="block u-clearFix">	
			<div class="u-pullRight">
				<a class="button button--primary" href="' . $__templater->func('link', array('thmonetize-free-account', ), true) . '" data-xf-click="overlay">' . 'Skip this step' . '</a>
			</div>
		</div>
	';
	}
	$__finalCompiled .= '
	
	<div class="block u-clearFix block--monetizeOptions">
		<div class="buttonGroup u-pullRight">
			';
	if ($__vars['showFilters']) {
		$__finalCompiled .= '
				<a href="' . $__templater->func('link', array('account/upgrades', $__vars['upgradePage'], array('filter' => 'monthly', ), ), true) . '" class="button ' . (($__vars['filter'] != 'monthly') ? 'button--alt' : '') . '">' . 'Monthly' . '</a>
				<a href="' . $__templater->func('link', array('account/upgrades', $__vars['upgradePage'], array('filter' => 'annual', ), ), true) . '" class="button ' . (($__vars['filter'] != 'annual') ? 'button--alt' : '') . '">' . 'Annual' . '</a>
				<a href="' . $__templater->func('link', array('account/upgrades', $__vars['upgradePage'], array('filter' => 'all', ), ), true) . '" class="button ' . (($__vars['filter'] != 'all') ? 'button--alt' : '') . '">' . 'All' . '</a>
			';
	}
	$__finalCompiled .= '
		</div>
		<span class="thmonetize_UpgradePageLinks-more">
			';
	if ($__vars['xf']['options']['thmonetize_allowFreeUpgrade'] AND ($__vars['showFree'] AND ($__vars['xf']['visitor']['user_id'] AND ($__vars['xf']['visitor']['user_state'] == 'thmonetize_upgrade')))) {
		$__finalCompiled .= '
				<a class="button button--primary" href="' . $__templater->func('link', array('thmonetize-free-account', ), true) . '" data-xf-click="overlay">' . 'Free account' . '</a>
			';
	}
	$__finalCompiled .= '
			';
	if ($__vars['upgradePage']['accounts_page_link']) {
		$__finalCompiled .= '
				<a class="button" href="' . $__templater->func('link', array('account/upgrades', null, array('show_all' => 1, ), ), true) . '">' . 'More' . $__vars['xf']['language']['ellipsis'] . '</a>
			';
	}
	$__finalCompiled .= '
		</span>
	</div>

	' . $__templater->callMacro(null, 'coupon_form', array(
		'coupons' => $__vars['coupons'],
		'coupon' => $__vars['coupon'],
	), $__vars) . '

	<div class="block thmonetize_UpgradeOptionsList">
		';
	if ($__templater->isTraversable($__vars['upgrades'])) {
		foreach ($__vars['upgrades'] AS $__vars['userUpgrade']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'upgrade_option', array(
				'upgrade' => $__vars['userUpgrade'],
				'profiles' => $__vars['profiles'],
				'featured' => $__vars['upgradePage']['Relations'][$__vars['userUpgrade']['user_upgrade_id']]['featured'],
				'redirect' => $__vars['redirect'],
				'coupon' => $__vars['coupon'],
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= '
	</div>

	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	if ($__templater->isTraversable($__vars['upgradePage']['UpgradePageLinks'])) {
		foreach ($__vars['upgradePage']['UpgradePageLinks'] AS $__vars['upgradePageLink']) {
			$__compilerTemp1 .= '
					<a class="button button--primary" href="' . $__templater->func('link', array('account/upgrades', null, array('upgrade_page_id' => $__vars['upgradePageLink']['upgrade_page_id'], ), ), true) . '">' . $__templater->escape($__vars['upgradePageLink']['title']) . '</a>
				';
		}
	}
	$__compilerTemp1 .= '
			';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		<div class="thmonetize_UpgradePageLinks">
			' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'features' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'features' => '!',
		'upgrade' => '!',
		'styleProperties' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('thmonetize_upgrade_page.less');
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['features'])) {
		foreach ($__vars['features'] AS $__vars['key'] => $__vars['feature']) {
			$__finalCompiled .= '
		<div class="user-upgrade-feature ' . ($__vars['feature']['description'] ? 'has-description' : '') . '" data-xf-click="toggle" data-target=".user-upgrade-description-' . $__templater->escape($__vars['upgrade']->{'user_upgrade_id'}) . '-' . $__templater->escape($__vars['key']) . '">
			';
			if ($__vars['styleProperties']['icon']) {
				$__finalCompiled .= '
				<i class="fa ' . $__templater->escape($__vars['styleProperties']['icon']) . ' fa-' . $__templater->escape($__vars['styleProperties']['icon']) . '"></i>
				';
			} else if ($__vars['styleProperties']['shape']) {
				$__finalCompiled .= '
				<i class="fa fa-' . $__templater->escape($__vars['styleProperties']['shape']) . '"></i>
				';
			} else {
				$__finalCompiled .= '
				<i class="fa fa-check-circle"></i>
			';
			}
			$__finalCompiled .= '
			<span>' . $__templater->escape($__vars['feature']['text']) . '</span>
			';
			if ($__vars['feature']['description']) {
				$__finalCompiled .= '
				<i class="user-upgrade-toggle-open fa fa-chevron-down"></i>
				<i class="user-upgrade-toggle-close fa fa-chevron-up"></i>
			';
			}
			$__finalCompiled .= '
		</div>
		';
			if ($__vars['feature']['description']) {
				$__finalCompiled .= '
			<div class="block-row user-upgrade-description user-upgrade-description-' . $__templater->escape($__vars['upgrade']->{'user_upgrade_id'}) . '-' . $__templater->escape($__vars['key']) . '">
				<span>' . $__templater->escape($__vars['feature']['description']) . '</span>
			</div>
		';
			}
			$__finalCompiled .= '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'coupon_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'coupons' => '',
		'coupon' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['coupons'], 'empty', array()) OR $__vars['xf']['options']['thmonetize_force_show_coupon_form']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__vars['coupon']) {
			$__compilerTemp1 .= '
						' . $__templater->formRow('
							<strong>' . $__templater->escape($__vars['coupon']['code']) . ' - ' . $__templater->escape($__vars['coupon']['title']) . '</strong>
							&nbsp;
							' . $__templater->button('Remove', array(
				'type' => 'submit',
				'class' => 'button--alt button--small',
				'name' => 'remove',
				'value' => '1',
			), '', array(
			)) . '
						', array(
				'label' => 'Redeemed coupon',
				'explain' => 'This coupon will be applied when you purchase an upgrade.',
			)) . '
					';
		}
		$__finalCompiled .= $__templater->form('
			<div class="block-container">
				<h2 class="block-header">' . 'Redeem coupon' . '</h2>

				<div class="block-body">
					' . $__templater->formTextBoxRow(array(
			'name' => 'coupon',
		), array(
			'label' => 'Coupon code',
		)) . '
					
					' . $__compilerTemp1 . '
				</div>

				' . $__templater->formSubmitRow(array(
			'submit' => 'Redeem',
		), array(
		)) . '
			</div>
		', array(
			'action' => $__templater->func('link', array('account/upgrade-coupon', ), false),
			'class' => 'block',
			'ajax' => 'true',
			'data-force-flash-message' => 'true',
		)) . '
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

';
	return $__finalCompiled;
}
);