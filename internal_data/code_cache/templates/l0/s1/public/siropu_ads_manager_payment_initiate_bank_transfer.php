<?php
// FROM HASH: 51df279d90865de26d104d51c37a671a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Bank transfer details');
	$__finalCompiled .= '

';
	$__vars['isInvoice'] = ($__vars['purchase']['extraData']['ads_manager'] ? true : false);
	$__finalCompiled .= '

<div class="blocks">
	';
	$__compilerTemp1 = '';
	if ($__vars['paymentProfile']['options']['instructions']) {
		$__compilerTemp1 .= '
					' . $__templater->formInfoRow($__templater->filter($__vars['paymentProfile']['options']['instructions'], array(array('raw', array()),), true), array(
		)) . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['isInvoice']) {
		$__compilerTemp2 .= '
						' . 'Invoice ID' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['purchase']['purchasableId']) . '
					';
	} else {
		$__compilerTemp2 .= '
						' . $__templater->escape($__vars['purchase']['title']) . '
					';
	}
	$__compilerTemp3 = '';
	if ($__vars['paymentProfile']['options']['mark_as_paid']) {
		$__compilerTemp3 .= '
				';
		$__templater->includeJs(array(
			'src' => 'siropu/am/invoice.js',
			'min' => '1',
		));
		$__compilerTemp3 .= '
				' . $__templater->formSubmitRow(array(
			'submit' => 'Mark as paid',
			'data-xf-click' => 'siropu-ads-manager-mark-as-paid',
			'data-type' => ($__vars['isInvoice'] ? 'invoice' : 'upgrade'),
			'data-id' => $__vars['purchase']['purchasableId'],
			'data-redirect' => ($__vars['isInvoice'] ? $__templater->func('link', array('ads-manager/invoices', ), false) : $__templater->func('link', array('account/upgrades', ), false)),
		), array(
			'rowtype' => 'button',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__compilerTemp1 . '
				' . $__templater->formRow('', array(
		'label' => 'Bank account name',
		'html' => $__templater->escape($__vars['paymentProfile']['options']['account_name']),
	)) . '
				' . $__templater->formRow('', array(
		'label' => 'Bank account number (IBAN)',
		'html' => $__templater->escape($__vars['paymentProfile']['options']['account_number']),
	)) . '
				' . $__templater->formRow('', array(
		'label' => 'SWIFT code',
		'html' => $__templater->escape($__vars['paymentProfile']['options']['swift_code']),
	)) . '
				' . $__templater->formRow('', array(
		'label' => 'Amount',
		'html' => $__templater->filter($__vars['purchase']['cost'], array(array('currency', array($__vars['purchase']['currency'], )),), true),
	)) . '
				' . $__templater->formRow('
					' . $__compilerTemp2 . '
				', array(
		'label' => 'Payment description',
		'explain' => 'Please provide this in the bank transfer payment description to identify the payment.',
	)) . '
			</div>
			' . $__compilerTemp3 . '
		</div>
	', array(
		'class' => 'block',
	)) . '
</div>';
	return $__finalCompiled;
}
);