<?php
// FROM HASH: 955af88aa69275fb41aa19a6f1f48011
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Extend ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/create.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ((!$__vars['emptySlots']) AND (!$__templater->method($__vars['ad'], 'isActive', array()))) {
		$__compilerTemp1 .= '
					<div class="blockMessage blockMessage--important blockMessage--iconic" style="margin-top: 10px;">
						' . 'We are sorry, currently there are no empty slots available. However, you can still extend your ad and once the invoice is paid, it will be added to the queue until a slot becomes available.' . '
					</div>
				';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
		$__compilerTemp2 .= '
				';
		$__compilerTemp3 = '';
		$__compilerTemp4 = $__templater->method($__vars['ad'], 'getKeywords', array());
		if ($__templater->isTraversable($__compilerTemp4)) {
			foreach ($__compilerTemp4 AS $__vars['keyword']) {
				$__compilerTemp3 .= '
							<li>
								';
				if ($__templater->method($__vars['ad']['Package'], 'getItemCustomCost', array($__vars['keyword'], ))) {
					$__compilerTemp3 .= '
									<span data-cost-premium="' . $__templater->escape($__templater->method($__vars['ad']['Package'], 'getItemCustomCost', array($__vars['keyword'], ))) . '">' . $__templater->escape($__vars['keyword']) . '</span> ' . $__templater->filter($__templater->method($__vars['ad']['Package'], 'getItemCustomCost', array($__vars['keyword'], )), array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . ' <span style="color: gray;">(' . 'Premium keyword' . ')</span>
								';
				} else {
					$__compilerTemp3 .= '
									' . $__templater->escape($__vars['keyword']) . ' ' . $__templater->filter($__vars['ad']['Package']['cost_amount'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . '
								';
				}
				$__compilerTemp3 .= '
							</li>
						';
			}
		}
		$__compilerTemp2 .= $__templater->formRow('
					<ol class="listPlain">
						' . $__compilerTemp3 . '
					</ol>
				', array(
			'label' => 'Keywords',
		)) . '
			';
	}
	$__compilerTemp5 = '';
	if ($__vars['ad']['Package']['cost_exclusive'] > 0) {
		$__compilerTemp5 .= '
				' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'exclusive_use',
			'value' => '1',
			'checked' => ($__vars['ad']['Extra']['exclusive_use'] == 1),
			'data-cost-exclusive' => $__vars['ad']['Package']['cost_exclusive'],
			'label' => 'Exclusive keyword use' . ' (' . $__templater->filter($__vars['ad']['Package']['cost_exclusive'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . ' / ' . 'Keyword' . ')',
			'_type' => 'option',
		)), array(
			'explain' => 'This option allows you to use keywords exclusively.',
		)) . '
			';
	}
	$__compilerTemp6 = '';
	if ($__vars['ad']['Package']['cost_sticky'] > 0) {
		$__compilerTemp6 .= '
				' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'sticky',
			'value' => '1',
			'checked' => ($__vars['ad']['Extra']['is_sticky'] == 1),
			'data-cost-sticky' => $__vars['ad']['Package']['cost_sticky'],
			'label' => 'Stick thread' . ' (' . $__templater->filter($__vars['ad']['Package']['cost_sticky'], array(array('currency', array($__vars['ad']['Package']['cost_currency'], )),), true) . ')',
			'_type' => 'option',
		)), array(
			'explain' => 'Sticky threads are displayed at the top of the thread list based on the last post date.',
		)) . '
			';
	}
	$__compilerTemp7 = '';
	if ($__vars['ad']['Package']['min_purchase'] < $__vars['ad']['Package']['max_purchase']) {
		$__compilerTemp7 .= '
				';
		$__compilerTemp8 = '';
		if ($__vars['ad']['Package']['discount']) {
			$__compilerTemp8 .= '
						';
			$__compilerTemp9 = array();
			if ($__templater->isTraversable($__vars['ad']['Package']['discount'])) {
				foreach ($__vars['ad']['Package']['discount'] AS $__vars['purchase'] => $__vars['discount']) {
					$__compilerTemp9[] = array(
						'data-discount' => $__vars['discount'],
						'data-purchase' => $__vars['purchase'],
						'checked' => ($__vars['ad']['Extra']['purchase'] == $__vars['purchase']),
						'label' => $__templater->escape($__vars['purchase']) . ' ' . $__templater->escape($__templater->method($__vars['ad']['Package'], 'getCostPerPhrase', array($__vars['purchase'], ))) . ' (' . $__templater->escape($__vars['discount']) . '% ' . 'Discount' . ')',
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp8 .= $__templater->formRadio(array(
				'name' => 'discount',
				'style' => 'margin-bottom: 10px;',
			), $__compilerTemp9) . '
					';
		}
		$__compilerTemp7 .= $__templater->formRow('
					' . $__compilerTemp8 . '
					' . $__templater->formNumberBox(array(
			'name' => 'purchase',
			'value' => $__vars['ad']['Extra']['purchase'],
			'size' => '5',
			'min' => $__vars['ad']['Package']['min_purchase'],
			'max' => $__vars['ad']['Package']['max_purchase'],
			'units' => $__templater->method($__vars['ad']['Package'], 'getCostPerPhrase', array(2, )),
		)) . '
				', array(
			'label' => 'Purchase',
			'explain' => 'You can choose a value between ' . $__templater->escape($__vars['ad']['Package']['min_purchase']) . ' and ' . $__templater->escape($__vars['ad']['Package']['max_purchase']) . '.',
		)) . '
			';
	}
	$__compilerTemp10 = '';
	if (!$__templater->test($__vars['usablePromoCodes'], 'empty', array())) {
		$__compilerTemp10 .= '
				' . $__templater->formCheckBoxRow(array(
			'data-xf-init' => 'siropu-ads-manager-apply-promo-code',
		), array(array(
			'label' => 'Do you have a promo code?',
			'data-hide' => 'true',
			'_dependent' => array('
							<div class="inputGroup inputGroup--auto">
								' . $__templater->formTextBox(array(
			'name' => 'promo_code',
			'placeholder' => 'Enter promo code',
			'autocomplete' => 'off',
		)) . '
								<span class="inputGroup-splitter"></span>
								' . $__templater->button('Apply', array(
		), '', array(
		)) . '
							</div>
						'),
			'_type' => 'option',
		)), array(
		)) . '
			';
	}
	$__compilerTemp11 = '';
	if ($__templater->method($__vars['ad'], 'isKeyword', array())) {
		$__compilerTemp11 .= '
				' . $__templater->formTextArea(array(
			'name' => 'content_1',
			'value' => $__vars['ad']['content_1'],
			'style' => 'display: none;',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This option allows you to extend your ad to continue advertising.' . '
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__templater->formRow('', array(
		'label' => 'Cost',
		'html' => $__templater->escape($__templater->method($__vars['ad']['Package'], 'getCost', array($__templater->method($__vars['ad'], 'getCustomCost', array()), ))) . ' ' . ($__templater->method($__vars['ad']['Package'], 'isFree', array()) ? (('(' . $__templater->escape($__templater->method($__vars['ad']['Package'], 'getMinimumLength', array()))) . ')') : ''),
		'explain' => ($__templater->method($__vars['ad'], 'isKeyword', array()) ? 'The cost is per keyword phrase.' : ''),
	)) . '

			' . $__compilerTemp2 . '

			' . $__compilerTemp5 . '

			' . $__compilerTemp6 . '

			' . $__compilerTemp7 . '

			' . $__compilerTemp10 . '

			<hr class="formRowSep" />

			' . $__templater->formRow('
				<span id="samTotalCost" data-cost-amount="' . $__templater->escape($__templater->arrayKey($__templater->method($__vars['ad'], 'getCost', array(0, true, )), 'costDiscounted')) . '">' . $__templater->escape($__templater->arrayKey($__templater->method($__vars['ad'], 'getCost', array(0, true, )), 'costDiscounted')) . ' ' . $__templater->escape($__vars['ad']['Package']['cost_currency']) . '</span>
			', array(
		'label' => 'Total cost',
		'style' => 'font-weight: bold;',
	)) . '

			' . $__compilerTemp11 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'submit' => 'Extend',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/extend', $__vars['ad'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-ad-type' => $__vars['ad']['type'],
		'data-ad-id' => $__vars['ad']['ad_id'],
		'data-cost-amount' => $__vars['ad']['Package']['cost_amount'],
		'data-cost-currency' => $__vars['ad']['Package']['cost_currency'],
		'data-cost-per' => $__vars['ad']['Package']['cost_per'],
		'data-cost-custom' => $__templater->method($__vars['ad'], 'getCustomCost', array()),
		'data-min-purchase' => $__vars['ad']['Package']['min_purchase'],
		'data-extend' => 'true',
		'data-xf-init' => 'siropu-ads-manager-create',
		'data-force-flash-message' => 'on',
	));
	return $__finalCompiled;
}
);