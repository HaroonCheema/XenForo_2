<?php
// FROM HASH: fda22d8dd26fea15881c5193531534eb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<style>
	.paymnet_btc_img{
	margin-left:3px;
	display:inline-block;
	width:25px;
	height:25px;
	}
	#blockoPayModal.modal .modal-dialog {
    max-width: 300px !important;
    top: initial !important;
    bottom: initial !important;
    left: 0px !important;
    right: 0px !important;
    margin: 15px auto !important;
		
}
	#blockoPayModal.modal .modal-content {
    background: #f4f4f4;
    display: block;
    color: #000;
}
	#blockoPayModal.modal .form-group {
    margin-bottom: 15px;
}
#blockoPayModal.modal .modal-content {
    background: #f4f4f4;
    display: block;
    color: #000;
}
	@media (min-width: 768px){
		#blockoPayModal.modal .modal-content {
			-webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
		}
	}
#blockoPayModal.modal .modal-header {
    text-align: left;
    border: none;
    padding-bottom: 7px;
    display: block;
}
#blockoPayModal.modal .modal-header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
}
#blockoPayModal.modal .modal-body {
    position: relative;
    padding: 15px;
}

element.style {
}
<style>
#blockoPayModal.modal .modal-body {
    padding-top: 0px;
    padding-left: 30px;
    padding-right: 30px;
    height: auto !important;
}
<style>
#blockoPayModal.modal .modal-body {
    position: relative;
    padding: 15px;
}
<style>
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}


#blockoPayModal.modal .modal-content {
    background: #f4f4f4;
    display: block;
    color: #000;
}
#blockoPayModal.modal {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
}
#blockoPayModal.modal .form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
#blockoPayModal.modal .btn {
    font-weight: bold;
    position: initial !important;
}
#blockoPayModal.modal .btn-warning {
    color: #fff;
    background-color: #f0ad4e;
    border-color: #eea236;
}
#blockoPayModal.modal .btn {
    display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#blockoPayModal.modal .modal-header .close {
    margin-top: -2px;
    width: auto;
}
#blockoPayModal.modal button.close {
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
    -webkit-appearance: none;
}
#blockoPayModal.modal .close {
    float: right;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .2;
    filter: alpha(opacity=20);
}
	#blockoPayModal.modal a {
    color: #337ab7;
    text-decoration: none;
}
	#blockoPayModal.modal a {
    background-color: transparent;
}
#blockoPayBtnQrCode {
    display: block;
    width: 150px;
    margin: 0 auto 9px;
    border: 1px solid #888888;
    padding: 6px 6px 1px;
    background: #ffffff;
}
#blockoPayBtnResponse {
    text-align: center;
}
#blockoPayModal.modal .form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
#blockoPayBtnBTCAmount {
    text-align: center;
    color: #059e66 !important;
    font-weight: normal;
}
#blockoPayModal.modal .form-control[disabled], #blockoPayModal.modal .form-control[readonly], #blockoPayModal.modal fieldset[disabled] .form-control {
    background-color: #eee;
    opacity: 1;
}
#blockoPayModal.modal .form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
	.blockonomics_message div:first-child {
		
		    display: grid !important;
   			 place-items: center;
	}
	.blockonomics_message div:first-child > div {
		max-width: 100% !important;
	}

	#bitcoinpay{
		width:auto !important;
	}
	
</style>



<div class="overlay-container is-active modal fade in show myElement" style="display: block;padding-right: 15px;"id="blockoPayModal" tabindex="-1" role="dialog" aria-labelledby="blockoPayModalLabel" style="padding-right: 15px;">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">' . $__templater->escape($__vars['userUpgrade']['title']) . '</h4>
				<p class="modal-desc">' . $__templater->escape($__vars['userUpgrade']['description']) . '</p>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<input type="email" class="form-control" id="email" placeholder="Email Address">
				</div>
				
				<div class="form-group">
					<input type="text" class="form-control" id="name" placeholder="Name">
				</div>

				<div class="form-group centered">
					<button type="submit" class="btn btn-warning" onclick="pay(\'' . $__templater->escape($__vars['encrypt']) . '\')">Pay ' . $__templater->escape($__vars['userUpgrade']['cost_amount']) . ' ' . $__templater->escape($__vars['userUpgrade']['cost_currency']) . '</button>
				</div>

				<div id="bitcoinpay" style="width: 100%;"></div>

				<div id="blockoPayBtnSuccess" style="display: none;">
					<p class="message"> <span id="blockoPayBtnTick">✔</span> </p>
					<p>Thank you, your order has been received.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://blockonomics.co/js/pay_widget.js?\'.' . $__templater->escape($__vars['xf']['time']) . '"></script>

<script>

		
	function pay(encrypt) {

		var encrypt = encrypt;
		
		var email = document.getElementById(\'email\').value;
		
		Blockonomics.widget({
			msg_area: \'bitcoinpay\',
			uid: \'07f50d8e6a44405c\',
			email: email,
			extra_data:encrypt,
			
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