<?php
// FROM HASH: 18f828711599956b14cb9ea6964b9f8e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['upgradePage']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Leave Rating', array(
		'href' => $__templater->func('link', array('package-rating/add', ), false),
		'icon' => 'rate',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['purchased'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Purchased upgrades' . '</h2>

			<ul class="block-body listPlain">
				';
		if ($__templater->isTraversable($__vars['purchased'])) {
			foreach ($__vars['purchased'] AS $__vars['upgrade']) {
				$__finalCompiled .= '
					<li>
						<div>
							';
				$__vars['active'] = $__vars['upgrade']['Active'][$__vars['xf']['visitor']['user_id']];
				$__finalCompiled .= '
							';
				$__compilerTemp1 = '';
				if ($__vars['active']['end_date']) {
					$__compilerTemp1 .= '
									' . 'Expires' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['active']['end_date'], array(
					))) . '
									';
				} else {
					$__compilerTemp1 .= '
									' . 'Expires: Never' . '
								';
				}
				$__compilerTemp2 = '';
				if ($__vars['upgrade']['length_unit'] AND ($__vars['upgrade']['recurring'] AND $__vars['active']['PurchaseRequest'])) {
					$__compilerTemp2 .= '
									';
					$__vars['provider'] = $__vars['active']['PurchaseRequest']['PaymentProfile']['Provider'];
					$__compilerTemp2 .= '
									' . $__templater->filter($__templater->method($__vars['provider'], 'renderCancellation', array($__vars['active'], )), array(array('raw', array()),), true) . '
								';
				}
				$__finalCompiled .= $__templater->formRow('

								' . $__compilerTemp1 . '

								' . $__compilerTemp2 . '
							', array(
					'label' => $__templater->escape($__vars['upgrade']['title']),
					'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
					'explain' => '',
				)) . '
						</div>
					</li>

';
				if ($__vars['xf']['visitor']['user_id'] == $__vars['active']['User']['user_id']) {
					$__finalCompiled .= '
    ' . $__templater->formRow('
        ' . $__templater->button('Cancel Subscription', array(
						'href' => $__templater->func('link', array('account/downgrade', null, array('user_upgrade_record_id' => $__vars['active']['user_upgrade_record_id'], ), ), false),
						'icon' => 'cancel',
						'class' => 'button--link',
						'overlay' => 'true',
					), '', array(
					)) . '
    ', array(
						'rowtype' => 'button',
					)) . '
    <div style="border: 1px solid red; background-color: black; color: white; padding: 10px; margin-top: 10px; display: flex; align-items: center;">
        <i class="fa fa-exclamation-triangle" style="color: red; margin-right: 10px;"></i>
        Canceling will immediately remove all perks and access.
    </div>
';
				}
				$__finalCompiled .= '
';
			}
		}
		$__finalCompiled .= '
</ul>


		</div>
	</div>
';
	}
	$__finalCompiled .= '



';
	$__templater->includeCss('thmonetize_upgrade_page.less');
	$__finalCompiled .= '

' . $__templater->callMacro('thmonetize_upgrade_page_macros', 'upgrade_options', array(
		'upgradePage' => $__vars['upgradePage'],
		'upgrades' => $__vars['upgrades'],
		'profiles' => $__vars['profiles'],
		'showFree' => true,
		'filter' => $__vars['filter'],
		'showFilters' => $__vars['showFilters'],
		'redirect' => $__vars['redirect'],
		'coupons' => $__vars['coupons'],
		'coupon' => $__vars['coupon'],
	), $__vars);
	return $__finalCompiled;
}
);