<?php
// FROM HASH: 0fad17645cabfa448009639637128523
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Pay invoice' . $__vars['xf']['language']['label_separator'] . ' #' . $__templater->escape($__vars['invoice']['invoice_id']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['invoice'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/payment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__vars['hasPaymentProfiles'] = !$__templater->test($__vars['xf']['options']['siropuAdsManagerPaymentProfiles'], 'empty', array());
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['invoices'], 'empty', array())) {
		$__compilerTemp1 .= '
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['invoices'])) {
			foreach ($__vars['invoices'] AS $__vars['inv']) {
				$__compilerTemp2 .= '
							<li><a href="' . $__templater->func('link', array('ads-manager/invoices/view', $__vars['inv'], ), true) . '" data-xf-click="overlay">#' . $__templater->escape($__vars['inv']['invoice_id']) . '</a>  - ' . $__templater->filter($__vars['inv']['cost_amount'], array(array('currency', array($__vars['inv']['cost_currency'], )),), true) . '</li>
						';
			}
		}
		$__compilerTemp1 .= $__templater->formRow('
					<ul class="listPlain">
						' . $__compilerTemp2 . '
					</ul>
				', array(
			'label' => 'Invoices',
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['hasPaymentProfiles']) {
		$__compilerTemp3 .= '
				';
		$__compilerTemp4 = $__templater->mergeChoiceOptions(array(), $__vars['paymentProfiles']);
		$__compilerTemp3 .= $__templater->formSelectRow(array(
			'name' => 'payment_profile_id',
		), $__compilerTemp4, array(
			'label' => 'Choose a payment method',
		)) . '

				';
		if ($__vars['xf']['options']['siropuAdsManagerSubscriptions'] AND ($__vars['invoice']['Ad'] AND ((!$__templater->func('in_array', array($__vars['invoice']['Ad']['Package']['cost_per'], array('cpm', 'cpc', ), ), false)) AND $__templater->test($__vars['invoices'], 'empty', array())))) {
			$__compilerTemp3 .= '
					' . $__templater->formCheckBoxRow(array(
				'name' => 'recurring',
			), array(array(
				'value' => '1',
				'label' => 'Subscribe',
				'_type' => 'option',
			)), array(
				'explain' => 'Check this option if you want to opt in for recurring payments.',
			)) . '
				';
		}
		$__compilerTemp3 .= '
			';
	} else {
		$__compilerTemp3 .= '
				' . $__templater->formRow('', array(
			'label' => 'Choose a payment method',
			'html' => 'No payment method has been found.',
		)) . '
			';
	}
	$__compilerTemp5 = '';
	if ($__vars['xf']['options']['siropuAdsManagerPaymentInstructions']) {
		$__compilerTemp5 .= '
				' . $__templater->formRow('', array(
			'label' => '',
			'html' => $__templater->filter($__vars['xf']['options']['siropuAdsManagerPaymentInstructions'], array(array('raw', array()),), true),
		)) . '
			';
	}
	$__compilerTemp6 = '';
	if ($__vars['hasPaymentProfiles']) {
		$__compilerTemp6 .= '
			' . $__templater->formSubmitRow(array(
			'icon' => 'purchase',
			'submit' => 'Pay',
		), array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('', array(
		'label' => 'Amount',
		'html' => $__templater->filter($__vars['invoice']['cost_amount'], array(array('currency', array($__vars['invoice']['cost_currency'], )),), true),
	)) . '

			' . $__compilerTemp1 . '

			' . $__compilerTemp3 . '
			' . $__compilerTemp5 . '
		</div>
		' . $__compilerTemp6 . '
	</div>
', array(
		'action' => $__templater->func('link', array('purchase', $__vars['invoice'], array('invoice_id' => $__vars['invoice']['invoice_id'], ), ), false),
		'class' => 'block',
		'ajax' => 'true',
		'data-xf-init' => 'payment-provider-container',
	)) . '
<div class="js-paymentProviderReply-advertising' . $__templater->escape($__vars['invoice']['invoice_id']) . '"></div>';
	return $__finalCompiled;
}
);