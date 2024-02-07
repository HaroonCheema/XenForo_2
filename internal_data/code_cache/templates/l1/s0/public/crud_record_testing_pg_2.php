<?php
// FROM HASH: a19b75cf8f3dcf58d98cd70cbb785259
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<style>

	#blockoPayModal.modal {
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 14px;
		line-height: 1.42857143;
	}

	#blockoPayModal.modal {
		display: none;
		/* overflow: hidden; */
		position: fixed !important;
		top: 0 !important;
		right: 0 !important;
		bottom: 0 !important;
		left: 0 !important;
		z-index: 105000 !important;
		-webkit-overflow-scrolling: touch;
		outline: 0;
	}

	#blockoPayModal.modal {
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 14px;
		line-height: 1.42857143;
	}

	#blockoPayModal.modal {
		font-size: 10px;
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}

	.overlay-container.is-active {
		display: block;
		opacity: 1;
	}

	.overlay-container {
		display: none;
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 900;
		background: rgba(0, 0, 0, 0.35);
		-webkit-overflow-scrolling: touch;
		opacity: 0;
		-webkit-transition: opacity 0.25s ease;
		transition: opacity 0.25s ease;
	}





	#blockoPayModal.modal.in .modal-dialog {
		-webkit-transform: translate(0, 0);
		-ms-transform: translate(0, 0);
		-o-transform: translate(0, 0);
		transform: translate(0, 0);
	}
	#blockoPayModal.modal.fade .modal-dialog {
		-webkit-transform: translate(0, -25%);
		-ms-transform: translate(0, -25%);
		-o-transform: translate(0, -25%);
		transform: translate(0, -25%);
		-webkit-transition: -webkit-transform 0.3s ease-out;
		-o-transition: -o-transform 0.3s ease-out;
		transition: transform 0.3s ease-out;
	}
	#blockoPayModal.modal .modal-dialog {
		max-width: 300px !important;
		top: initial !important;
		bottom: initial !important;
		left: 0px !important;
		right: 0px !important;
		margin: 15px auto !important;
	}
	#blockoPayModal.modal .modal-dialog {
		max-width: 300px !important;
		top: initial !important;
		bottom: initial !important;
		left: 0px !important;
		right: 0px !important;
		margin: 15px auto !important;
	}
	@media (min-width: 768px)
		#blockoPayModal.modal .modal-sm {
			width: 300px;
	}
	@media (min-width: 768px)
		#blockoPayModal.modal .modal-dialog {
			width: 600px;
			margin: 30px auto;
	}
	#blockoPayModal.modal .modal-dialog {
		position: relative;
		width: auto;
		margin: 10px;
	}




	#blockoPayModal.modal .modal-content {
		background: #f4f4f4;
		display: block;
		color: #000;
	}
	@media (min-width: 768px)
		#blockoPayModal.modal .modal-content {
			-webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	}
	#blockoPayModal.modal .modal-content {
		background: #f4f4f4;
		display: block;
		color: #000;
	}
	#blockoPayModal.modal .modal-content {
		background: #f4f4f4;
		display: block;
		color: #000;
	}
	#blockoPayModal.modal .modal-content {
		background: #f4f4f4;
		display: block;
		color: #000;
	}
	@media (min-width: 768px)
		#blockoPayModal.modal .modal-content {
			-webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	}




	#blockoPayModal.modal .modal-header {
		padding: 15px;
		border-bottom: 1px solid #e5e5e5;
	}
	#blockoPayModal.modal .modal-header {
		text-align: left;
		border: none;
		padding-bottom: 7px;
		display: block;
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






	#blockoPayModal.modal .modal-header .close {
		margin-top: -2px;
		width: auto;
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
	#blockoPayModal.modal input, #blockoPayModal.modal button, #blockoPayModal.modal select, #blockoPayModal.modal textarea {
		font-family: inherit;
		font-size: inherit;
		line-height: inherit;
	}
	#blockoPayModal.modal button, #blockoPayModal.modal input[type="button"], #blockoPayModal.modal input[type="reset"], #blockoPayModal.modal input[type="submit"] {
		-webkit-appearance: button;
		cursor: pointer;
	}
	#blockoPayModal.modal button, #blockoPayModal.modal select {
		text-transform: none;
	}
	#blockoPayModal.modal button {
		overflow: visible;
	}
	#blockoPayModal.modal button, #blockoPayModal.modal input, #blockoPayModal.modal optgroup, #blockoPayModal.modal select, #blockoPayModal.modal textarea {
		color: inherit;
		font: inherit;
		margin: 0;
	}
	[type=reset], [type=submit], button, html [type=button] {
		-webkit-appearance: button;
	}
	button, input, optgroup, select, textarea {
		font-family: \'Segoe UI\', \'Helvetica Neue\', Helvetica, Roboto, Oxygen, Ubuntu, Cantarell, \'Fira Sans\', \'Droid Sans\', sans-serif;
		line-height: 1.4;
	}
	button, select {
		text-transform: none;
	}
	button, input, optgroup, select, textarea {
		font-family: sans-serif;
		font-size: 100%;
		line-height: 1.15;
		margin: 0;
	}
	button, hr, input {
		overflow: visible;
	}






	#blockoPayModal.modal .modal-header h4 {
		padding: 30px 15px 0px !important;
		font-size: 14px;
		font-weight: bold;
		text-transform: none !important;
		margin: 0px 0px 7px !important;
		line-height: 1.5;
		color: #333333;
	}
	#blockoPayModal.modal .modal-title {
		margin: 0;
		line-height: 1.42857143;
	}






	#blockoPayModal.modal .modal-header .modal-desc {
		padding: 0px 15px 0px;
		font-weight: normal;
		margin: 0px 0px 7px;
		font-size: 13px;
		line-height: 1.5;
		color: #333333;
		white-space: pre-wrap;
	}

</style>

<div class="overlay-container is-active modal fade in show myElement" style="display: block;padding-right: 15px;" id="blockoPayModal" tabindex="-1" role="dialog" aria-labelledby="blockoPayModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Admirer 1 year membership</h4>
				<p class="modal-desc">Upgrade your existing package to avail new features. This upgrade is valid for one year.</p>
			</div>

		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);