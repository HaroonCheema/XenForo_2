<?php
// FROM HASH: 43ecb613b4ff631bc06e0219fe042b2b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('payment_initiate.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/payment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Payment with ' . $__templater->escape($__vars['paymentProfile']['options']['currency_exit']) . '');
	$__finalCompiled .= '

<div class="blocks">
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formRow('
					<img class="qrcode-img" style="margin-left: auto; margin-right: auto; display: block;" src="' . $__templater->escape($__vars['qrcodeUrl']) . '"/>
					<div class="formRow-explain coinpayments-payment-informations" style="text-align:center;">(' . '<i>' . $__templater->escape($__vars['address']) . '</i> - ' . $__templater->escape($__vars['confirmations']) . ' confirmations - Transaction number : <i>' . $__templater->escape($__vars['transactionId']) . '</i> - Tag : ' . $__templater->escape($__vars['tagId']) . '' . ')</div>
					<div class="formRow-explain">' . 'Payments are processed securely by <a href="' . 'https://www.coinpayments.net' . '" target="_blank">' . 'CoinPayments' . '</a>. ' . '</div>
				', array(
		'controlid' => 'qrcode-element',
		'rowtype' => 'input',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formRow(' 
					 
					' . $__templater->button('
						<a target="_blank" href="' . $__templater->escape($__vars['statusUrl']) . '">' . 'Payment informations' . '</a>
					', array(
		'icon' => 'preview',
	), '', array(
	)) . '
					' . $__templater->button('
						' . 'Validate payment ' . '
					', array(
		'type' => 'submit',
		'icon' => 'save',
	), '', array(
	)) . '
				', array(
		'label' => 'Pay ' . $__templater->escape($__vars['amount']) . ' (' . $__templater->escape($__vars['paymentProfile']['options']['currency_exit']) . ') ',
		'rowtype' => 'button',
	)) . '
			</div>
		</div>
	', array(
		'action' => $__templater->func('link', array('purchase/process', null, array('request_key' => $__vars['purchaseRequest']['request_key'], 'transaction_id' => $__vars['transactionId'], ), ), false),
		'class' => 'block block--paymentInitiate',
		'data-xf-init' => 'coinpayments-payment-form',
		'data-publishable-key' => $__vars['publishableKey'],
	)) . '
</div>';
	return $__finalCompiled;
}
);