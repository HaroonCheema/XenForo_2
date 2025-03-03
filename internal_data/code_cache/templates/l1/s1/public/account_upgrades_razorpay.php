<?php
// FROM HASH: 49570e0cae84f3b1c7bce68d1317692d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['available'], 'empty', array())) {
		$__finalCompiled .= '
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	';
		if ($__templater->isTraversable($__vars['available'])) {
			foreach ($__vars['available'] AS $__vars['upgrade']) {
				$__finalCompiled .= '
		<script>
			document.getElementById(\'rzp-button-' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . '\').onclick = function(e) {
				// Get the form by its ID
				var form = document.getElementById(\'paymentForm-' . $__templater->escape($__vars['upgrade']['user_upgrade_id']) . '\');

				// Get the form data
				var formData = new FormData(form);

				// Retrieve payment_profile_id from the FormData
				var paymentProfileId = formData.get(\'payment_profile_id\');


				console.log(paymentProfileId);
				var userUpgradeId = formData.get(\'user_upgrade_id\'); 
								console.log(userUpgradeId);
				// Check if the payment profile ID is 2
				if (paymentProfileId == ' . $__templater->escape($__vars['xf']['options']['razor_payment_profile_id']) . ') {
					console.log(paymentProfileId);
					// If payment_profile_id is 2, submit the form via AJAX
					e.preventDefault(); // Prevent default form submission

					var actionUrl = form.action;
					 var urlParams = new URLSearchParams(actionUrl.split(\'?\')[1]);
					 var userUpgradeId = urlParams.get(\'user_upgrade_id\'); // 
					console.log(paymentProfileId);
					console.log(userUpgradeId);

					 var ajaxData = new FormData();
					ajaxData.append(\'user_upgrade_id\', userUpgradeId); // Append user_upgrade_id to FormData
					ajaxData.append(\'payment_profile_id\', paymentProfileId); // Append payment_profile_id to FormData
					// Make the AJAX request using the new FormData object
						XF.ajax(\'POST\', XF.canonicalizeUrl(\'index.php?razorpay/create-order\'), ajaxData, function(res) {
							var razorpayOptions = res.razorpayOptions;
							
							  console.log(razorpayOptions);

							var rzp1 = new Razorpay(razorpayOptions);
							rzp1.open();
						});

				} 
				// If payment_profile_id is not 2, do nothing; the form will submit normally
			}
		</script>
	';
			}
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);