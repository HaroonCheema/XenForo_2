<?php
// FROM HASH: f3ed8f3dc01edf552304079a2e2eac33
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Promo codes');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add promo code', array(
		'href' => $__templater->func('link', array('ads-manager/promo-codes/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['promoCodes'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['promoCodes'])) {
			foreach ($__vars['promoCodes'] AS $__vars['promoCode']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['promoCode']['promo_code']),
					'hint' => $__templater->escape($__vars['promoCode']['value']) . (($__vars['promoCode']['type'] == 'percent') ? '%' : $__templater->escape($__vars['xf']['options']['siropuAdsManagerPreferredCurrency'])),
					'explain' => 'Promo code has been used <b>' . $__templater->escape($__vars['promoCode']['usage_count']) . '</b> times.',
					'href' => $__templater->func('link', array('ads-manager/promo-codes/edit', $__vars['promoCode'], ), false),
					'delete' => $__templater->func('link', array('ads-manager/promo-codes/delete', $__vars['promoCode'], ), false),
				), array(array(
					'width' => '5%',
					'class' => 'dataList-cell--separated',
					'_type' => 'cell',
					'html' => '
								' . $__templater->button('', array(
					'class' => 'button--link button--iconOnly menuTrigger',
					'data-xf-click' => 'menu',
					'aria-label' => 'More options',
					'aria-expanded' => 'false',
					'aria-haspopup' => 'true',
					'fa' => 'fas fa-bars',
				), '', array(
				)) . '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<a href="' . $__templater->func('link', array('ads-manager/invoices', '', array('promo_code' => $__vars['promoCode']['promo_code'], ), ), true) . '" class="menu-linkRow">' . 'Find invoices' . '</a>
									</div>
								</div>
							',
				),
				array(
					'name' => 'enabled[' . $__vars['promoCode']['promo_code'] . ']',
					'selected' => $__vars['promoCode']['enabled'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['promoCode']['promo_code'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'promoCodes',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['promoCodes'], ), true) . '</span>
				</div>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/promo-codes/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);