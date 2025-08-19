<?php
// FROM HASH: 31ef03c76f5bdcc4773482cbaaacfb5a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['promoCode'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add promo code');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit promo code' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['promoCode']['promo_code']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['promoCode'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['promoCode'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/promo-codes/delete', $__vars['promoCode'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['packages']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
				<span class="hScroller-scroll">
					<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="general">' . 'Basic information' . '</a>
					' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
				</span>
			</h2>
			<ul class="tabPanes block-body">
				<li role="tabpanel" id="general">
				' . $__templater->formTextBoxRow(array(
		'name' => 'promo_code',
		'value' => $__vars['promoCode']['promo_code'],
	), array(
		'label' => 'Promo code',
		'explain' => 'Promo code must be unique. Use only letters and numbers.',
	)) . '

					' . $__templater->formRow('
						<div class="inputGroup">
							' . $__templater->formNumberBox(array(
		'name' => 'value',
		'value' => $__vars['promoCode']['value'],
		'min' => '0',
	)) . '
							<span class="inputGroup-splitter"></span>
							' . $__templater->formSelect(array(
		'name' => 'type',
		'value' => $__vars['promoCode']['type'],
		'class' => 'input--autoSize',
	), array(array(
		'value' => 'percent',
		'label' => '%',
		'_type' => 'option',
	),
	array(
		'value' => 'amount',
		'label' => '$',
		'_type' => 'option',
	))) . '
						</div>
					', array(
		'label' => 'Discount',
	)) . '

					<hr class="formRowSep" />

					' . $__templater->formSelectRow(array(
		'name' => 'package',
		'value' => $__vars['promoCode']['package'],
		'multiple' => 'true',
	), $__compilerTemp1, array(
		'label' => 'Applies to package',
		'explain' => 'This option allows you to enable the promo code only for certain packages.',
	)) . '
		
					' . $__templater->formNumberBoxRow(array(
		'name' => 'invoice_amount',
		'value' => $__vars['promoCode']['invoice_amount'],
		'min' => '0',
	), array(
		'label' => 'Minimum invoice amount',
		'explain' => 'This option allows you to enable the promo code only for invoices with the amount equal or higher than x.',
	)) . '

					<hr class="formRowSep" />

					' . $__templater->formDateInputRow(array(
		'name' => 'active_date',
		'value' => ($__vars['promoCode']['active_date'] ? $__templater->func('date', array($__vars['promoCode']['active_date'], 'picker', ), false) : ''),
	), array(
		'label' => 'Activation date',
		'explain' => 'This option allows you to activate the promo code at a set date. Promo code must be enabled.',
	)) . '
					
					' . $__templater->formDateInputRow(array(
		'name' => 'expire_date',
		'value' => ($__vars['promoCode']['expire_date'] ? $__templater->func('date', array($__vars['promoCode']['expire_date'], 'picker', ), false) : ''),
	), array(
		'label' => 'Expiration date',
		'explain' => 'Set an expiration date for this promo code. If left blank, the promo code will never expire.',
	)) . '

					<hr class="formRowSep" />

					' . $__templater->formNumberBoxRow(array(
		'name' => 'user_usage_limit',
		'value' => $__vars['promoCode']['user_usage_limit'],
		'min' => '0',
	), array(
		'label' => 'User usage limit',
		'explain' => 'The maximum number of times a user can use the promo code. Set to 0 for unlimited usage.',
	)) . '

					' . $__templater->formNumberBoxRow(array(
		'name' => 'total_usage_limit',
		'value' => $__vars['promoCode']['total_usage_limit'],
		'min' => '0',
	), array(
		'label' => 'Total usage limit',
		'explain' => 'The maximum number of times the promo code can be used. Set to 0 for unlimited usage.',
	)) . '

					<hr class="formRowSep" />

					' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'enabled',
		'value' => '1',
		'selected' => $__vars['promoCode']['enabled'],
		'label' => 'Enable promo code',
		'_type' => 'option',
	)), array(
	)) . '
				</li>

				' . $__templater->callMacro('helper_criteria', 'user_panes', array(
		'criteria' => $__templater->method($__vars['userCriteria'], 'getCriteriaForTemplate', array()),
		'data' => $__templater->method($__vars['userCriteria'], 'getExtraTemplateData', array()),
	), $__vars) . '
			</ul>
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/promo-codes/save', $__vars['promoCode'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);