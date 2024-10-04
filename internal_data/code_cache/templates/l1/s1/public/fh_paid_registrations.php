<?php
// FROM HASH: adddda8471f4e2df7c63cca200aa314b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('paidregistrations_choose_account_type');
	$__finalCompiled .= '

';
	$__templater->includeCss('andy_paid_registrations.less');
	$__finalCompiled .= '
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['results'])) {
		foreach ($__vars['results'] AS $__vars['result']) {
			$__vars['i']++;
			$__finalCompiled .= '
	
	' . '
	
	<span class="block paid-registrations-block">
		<div class="block-container paid-registrations-block-container">
			<h2 class="block-header">' . $__templater->escape($__vars['result']['title']) . '</h2>
			<div class="block-body block-row paid-registrations-block-body">
				';
			if (($__vars['i'] == 1) OR ($__vars['i'] == 4)) {
				$__finalCompiled .= '
					<div class="paid-registrations-circle-1">
						' . $__templater->escape($__vars['result']['cost_phrase']) . ' 
					</div>
				';
			}
			$__finalCompiled .= '
				';
			if (($__vars['i'] == 2) OR ($__vars['i'] == 5)) {
				$__finalCompiled .= '
					<div class="paid-registrations-circle-2">
						' . $__templater->escape($__vars['result']['cost_phrase']) . ' 
					</div>
				';
			}
			$__finalCompiled .= '
				';
			if (($__vars['i'] == 3) OR ($__vars['i'] == 6)) {
				$__finalCompiled .= '
					<div class="paid-registrations-circle-3">
						' . $__templater->escape($__vars['result']['cost_phrase']) . '
					</div>
				';
			}
			$__finalCompiled .= '
				<div class="paid-registrations-join-now">
					
					';
			if ($__vars['result']['andy_paid_registrations_stripe']) {
				$__finalCompiled .= '
						' . $__templater->button('
							' . 'paidregistrations_join_now' . '
						', array(
					'href' => $__vars['result']['andy_paid_registrations_stripe'],
					'class' => 'button--link',
					'target' => '_blank',
				), '', array(
				)) . '
					';
			}
			$__finalCompiled .= '


					
					';
			if ($__vars['result']['fh_paid_registrations_razorpay']) {
				$__finalCompiled .= '
						' . $__templater->button('paidregistrations_join_now', array(
					'class' => 'button--link',
					'id' => 'rzp-button-' . $__vars['i'],
				), '', array(
				)) . '

						<script>					
							document.getElementById(\'rzp-button-' . $__templater->escape($__vars['i']) . '\').onclick = function(e){

								XF.ajax(\'GET\', XF.canonicalizeUrl(\'index.php?paidregistrations/create-order\'), {userUpgradeId: ' . $__templater->escape($__vars['result']['user_upgrade_id']) . '}, function (res) {
									var razorpayOptions =	res.razorpayOptions;

									var rzp1 = new Razorpay(razorpayOptions);
									rzp1.open();
								});

								e.preventDefault();
							}
						</script>
					';
			}
			$__finalCompiled .= '

				</div>
				<div class="paid-registrations-description">
					' . $__templater->filter($__vars['result']['description'], array(array('raw', array()),), true) . '
				</div>
			</div>
		</div>
	</span>
';
		}
	}
	return $__finalCompiled;
}
);