<?php
// FROM HASH: d9b48522d9a2f8f1dd62d02385528648
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->inlineCss('
	.paymnet_btc_img{
	margin-left:3px;
	display:inline-block;
	width:25px;
	height:25px;
	}
');
	$__finalCompiled .= '



<div class="modal fade in show myElement" id="blockoPayModal" tabindex="-1" role="dialog" aria-labelledby="blockoPayModalLabel" style="padding-right: 15px;">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Premium Companion Subscription</h4>
				<p class="modal-desc">Upgrade your existed pakage to avail new features. This upgrading is valid for one month.</p>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<input type="email" class="form-control" id="email" placeholder="Email Address">
				</div>
				
				<div class="form-group">
					<input type="text" class="form-control" id="name" placeholder="Name">
				</div>

				<div class="form-group centered">
					<button type="submit" class="btn btn-warning" onclick="pay(\'' . $__templater->escape($__vars['encrypt']) . '\')">Pay 80 USD</button>
				</div>

				<div id="bitcoinpay"></div>

				<div id="blockoPayBtnResponse" style="display: none;">
					<p id="blockoPaySection">
						<a id="blockoPayBtnQrCode"></a>
					</p>
					<div id="blockoCopyAmountText">To pay send this amount</div>
					<input class="form-control" id="blockoPayBtnBTCAmount" value="" readonly="">
					<div id="blockoCopyAddressText">to this bitcoin address</div>
					<input class="form-control" id="blockoPayBtnBTCAddress" value="" readonly="">
					<p></p>
					<div class="ticker clearfix">
						<div id="timeRemainingText"></div>
						<div class="time-progress">
							<div id="prog" class="prog" style="width: 0px;"></div>
						</div>
					</div>
					<div id="btcConversion"><span id="blockoPayBtnCurAmount"></span> &lt;-&gt; <span id="blockoPayBtnBTCEqui"></span> BTC</div>
				</div>
				<div id="blockoPayBtnSuccess" style="display: none;">
					<p class="message"> <span id="blockoPayBtnTick">✔</span> </p>
					<p>Thank you, your order has been received.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://blockonomics.co/js/pay_widget.js"></script>

<script>

		
	function pay(encrypt) {

		var encrypt = encrypt;
		console.log(encrypt);
		var email = document.getElementById(\'email\').value;
		
		Blockonomics.widget({
			msg_area: \'bitcoinpay\',
			uid: \'08785fe7b68d4191\',
			email: email,
			custom_one: encrypt
			
		});
		
	}


	$(document).ready(function() {
		
		$(".close").click(function() {
			$(".myElement").css("display", "none"); // Change color to red
		});
	});

</script>';
	return $__finalCompiled;
}
);