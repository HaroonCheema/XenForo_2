<?php
// FROM HASH: a8dc1fb57e26b5f77bc7c8ff297e9c50
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('paidregistrations_paid_registrations_admin');
	$__finalCompiled .= '

';
	$__templater->includeCss('andy_paid_registrations.less');
	$__finalCompiled .= '

' . 'paidregistrations_limit:' . ' ' . $__templater->escape($__vars['limit']) . '

<br /><br />


';
	if ($__templater->isTraversable($__vars['razorpayPaidRegistrations'])) {
		foreach ($__vars['razorpayPaidRegistrations'] AS $__vars['result']) {
			$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row paid-registrations-block-body">
				' . 'paidregistrations_paid_registrations_id:' . ' ' . $__templater->escape($__vars['result']['paid_registrations_id']) . ' &nbsp; (Razorpay)<br />
				' . 'paidregistrations_user_upgrade_id:' . ' ' . $__templater->escape($__vars['result']['user_upgrade_id']) . '<br />
				' . 'Razorpay Order ID' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['result']['razorpay_order_id']) . '<br />
				' . 'Razorpay Payment ID' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['result']['razorpay_payment_id']) . '<br />
				' . 'Razorpay Signature' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['result']['razorpay_signature']) . '<br />
				' . 'Date' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['result']['date'], array(
			))) . '<br />
				' . 'paidregistrations_user_upgrade_record_id:' . ' ' . $__templater->escape($__vars['result']['user_upgrade_record_id']) . '<br /><br />
				
				';
			if ($__vars['result']['razorpay_payment_id']) {
				$__finalCompiled .= '
					<a href="https://dashboard.razorpay.com/app/payments/' . $__templater->escape($__vars['result']['razorpay_payment_id']) . '?init_page=Payments" target="_blank">' . 'View in Razorpay Dashboard' . '</a>
				';
			}
			$__finalCompiled .= '
				
			</div>
		</div>
	</div>											
';
		}
	}
	$__finalCompiled .= '



';
	if ($__templater->isTraversable($__vars['results'])) {
		foreach ($__vars['results'] AS $__vars['result']) {
			$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row paid-registrations-block-body">
				' . 'paidregistrations_paid_registrations_id:' . ' ' . $__templater->escape($__vars['result']['paid_registrations_id']) . '<br />
				' . 'paidregistrations_user_upgrade_id:' . ' ' . $__templater->escape($__vars['result']['user_upgrade_id']) . '<br />
				' . 'paidregistrations_checkout_session_id:' . ' ' . $__templater->escape($__vars['result']['checkout_session_id']) . '<br />
				' . 'paidregistrations_payment_intent:' . ' ' . $__templater->escape($__vars['result']['payment_intent']) . '<br />
				' . 'paidregistrations_subscription:' . ' ' . $__templater->escape($__vars['result']['subscription']) . '<br />
				' . 'Date' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['result']['dateline'], array(
			))) . '<br />
				' . 'paidregistrations_user_upgrade_record_id:' . ' ' . $__templater->escape($__vars['result']['user_upgrade_record_id']) . '<br /><br />
				
				';
			if ($__vars['result']['payment_intent']) {
				$__finalCompiled .= '
					<a href="https://dashboard.stripe.com/payments/' . $__templater->escape($__vars['result']['payment_intent']) . '" target="_blank">' . 'paidregistrations_view_in_stripe_dashboard' . '</a>
				';
			}
			$__finalCompiled .= '
				
				';
			if ($__vars['result']['subscription']) {
				$__finalCompiled .= '
					<a href="https://dashboard.stripe.com/subscriptions/' . $__templater->escape($__vars['result']['subscription']) . '" target="_blank">' . 'paidregistrations_view_in_stripe_dashboard' . '</a>
				';
			}
			$__finalCompiled .= '
				
			</div>
		</div>
	</div>											
';
		}
	}
	$__finalCompiled .= '

';
	if ((!$__vars['results']) AND (!$__vars['razorpayPaidRegistrations'])) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body block-row">
				' . 'No results found.' . '
			</div>
		</div>
	</div>	
';
	}
	return $__finalCompiled;
}
);