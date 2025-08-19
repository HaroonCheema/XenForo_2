<?php
// FROM HASH: 11a8959245c4cee698dd8c47fa89b503
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['invoice'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add invoice');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit invoice' . $__vars['xf']['language']['label_separator'] . ' #' . $__templater->escape($__vars['invoice']['invoice_id']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['invoice'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['invoice'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/invoices/delete', $__vars['invoice'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['invoice'], 'isInsert', array())) {
		$__compilerTemp1 .= '
				';
		if (!$__templater->test($__vars['ads'], 'empty', array())) {
			$__compilerTemp1 .= '
					';
			$__compilerTemp2 = array(array(
				'_type' => 'option',
			));
			$__compilerTemp2 = $__templater->mergeChoiceOptions($__compilerTemp2, $__vars['ads']);
			$__compilerTemp1 .= $__templater->formSelectRow(array(
				'name' => 'ad_id',
			), $__compilerTemp2, array(
				'label' => 'Ad',
			)) . '
				';
		} else {
			$__compilerTemp1 .= '
					' . $__templater->formRow('', array(
				'label' => 'Ad',
				'html' => 'No ads have been found.',
			)) . '
				';
		}
		$__compilerTemp1 .= '

				' . $__templater->formTextBoxRow(array(
			'name' => 'username',
			'data-xf-init' => 'auto-complete',
			'data-single' => 'true',
		), array(
			'label' => 'Advertiser',
		)) . '
			';
	} else {
		$__compilerTemp1 .= '
				' . $__templater->formRow('
					' . $__templater->func('username_link', array($__vars['invoice']['User'], true, array(
			'defaultname' => $__vars['invoice']['username'],
		))) . '
				', array(
			'label' => 'Advertiser',
		)) . '
				
				';
		if ($__vars['invoice']['Ad']) {
			$__compilerTemp1 .= '
					' . $__templater->formRow('
						<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['invoice']['Ad'], ), true) . '">' . $__templater->escape($__vars['invoice']['Ad']['name']) . '</a>
					', array(
				'label' => 'Ad',
			)) . '
				';
		}
		$__compilerTemp1 .= '

				<hr class="formRowSep" />

				';
		$__compilerTemp3 = array(array(
			'_type' => 'option',
		));
		$__compilerTemp3 = $__templater->mergeChoiceOptions($__compilerTemp3, $__vars['profiles']);
		$__compilerTemp1 .= $__templater->formSelectRow(array(
			'name' => 'payment_profile_id',
			'value' => $__vars['invoice']['payment_profile_id'],
		), $__compilerTemp3, array(
			'label' => 'Payment profile',
		)) . '
			';
	}
	$__compilerTemp4 = '';
	if ($__templater->method($__vars['invoice'], 'isUpdate', array())) {
		$__compilerTemp4 .= '
			<div class="block-footer">
				' . $__templater->fontAwesome('fas fa-info-circle', array(
		)) . ' ' . 'Changing the invoice status to "Completed" will activate the ad and deactivate it if set to "Cancelled".' . '
			</div>
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '

			' . $__templater->formRow('
				' . $__templater->formTextBox(array(
		'name' => 'cost_amount',
		'value' => $__vars['invoice']['cost_amount'],
		'class' => 'input--inline',
	)) . '
				' . $__templater->callMacro('public:currency_macros', 'currency_list', array(
		'value' => ($__vars['invoice']['cost_currency'] ?: $__vars['xf']['options']['siropuAdsManagerPreferredCurrency']),
		'name' => 'cost_currency',
		'class' => 'input--inline',
	), $__vars) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Amount',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'status',
		'value' => $__vars['invoice']['status'],
	), array(array(
		'value' => 'pending',
		'label' => 'Pending',
		'_type' => 'option',
	),
	array(
		'value' => 'completed',
		'label' => 'Completed',
		'_type' => 'option',
	),
	array(
		'value' => 'cancelled',
		'label' => 'Cancelled',
		'_type' => 'option',
	)), array(
		'label' => 'Status',
	)) . '
		</div>
		' . $__compilerTemp4 . '
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/invoices/save', $__vars['invoice'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);