<?php
// FROM HASH: 1557e1e2cb1cd5c914a6ebf3b866c3ec
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

<a href=""  class="blockoPayBtn button button--icon blockoPayButton">
	Purchase 
	<img class="paymnet_btc_img "  src="' . $__templater->func('base_url', array('styles/FS/BitcoinIntegration/btc.png', ), true) . '">
</a>

<div class="modal fade in show myElement" id="blockoPayModal" tabindex="-1" role="dialog" aria-labelledby="blockoPayModalLabel" style="display:none;padding-right: 15px;">
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
					<button type="submit" class="btn btn-warning" onclick="pay(' . $__templater->escape($__vars['xf']['visitor']['user_id']) . ',5)">Pay 80 USD</button>
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

		
	function pay(userid,groupid) {

		var userid = userid;
		var groupid = groupid;
		var email = document.getElementById(\'email\').value;
		var blockoPayModal = document.getElementById("blockoPayModal");
		blockoPayModal.style.display = "block";
		Blockonomics.widget({
			msg_area: \'bitcoinpay\',
			custom_field1: \'testeer\',
			uid: \'08785fe7b68d4191\',
			email: email,
			custom_one: userid,
			custom_two: groupid
		});
		
	}


	$(document).ready(function() {
		

		$(".blockoPayBtn").click(function() {
			$(".myElement").css("display", "block"); // Change color to red
		});
		$(".close").click(function() {
			$(".myElement").css("display", "none"); // Change color to red
		});
	});

</script>';
	return $__finalCompiled;
}
);