<?php
// FROM HASH: de072aaba9e9337e7cd3b4fa844fcbc2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
		var rzp1 = new Razorpay(' . $__templater->filter($__vars['razorpayOptions'], array(array('raw', array()),), true) . ');
		rzp1.open();
	
</script>';
	return $__finalCompiled;
}
);