<?php
// FROM HASH: c215a0e53d33bd7d74599f4cdaf65d71
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.xb_gallery_container {
	max-height:250px;
	overflow:auto;
}
div#xb_avatar_select {
	border-radius: 5px;
	display: inline-block;
	border: solid @xf-inputBgColor ;
    border-radius: 100%;
	padding: 0;
	margin: 0;
	-moz-appearance: none;
	margin-bottom: @xf-paddingSmall;
	position: relative;
	overflow:hidden;
	:hover {
		opacity: 0.7;
		cursor: pointer;
	}
	&.checked {
		border: solid #185886;
		border-radius: 100%;
	}
	&.checked .fa{
		display: block;
	}
	.fa {
		display: none;
		position: absolute;
		font-size: 60px;
		color: #185886;
		padding: 20px;
	}
}
ul.xb_avatar_list {
	margin: 0px !important;
	padding: 0px !important;
	list-style-type: none;
}
.img-ai-error{
	color:red;
}
.is-disabled-generate{
	    opacity: 0.5;  /* Make the button appear faded */
    pointer-events: none;  /* Prevent click events */
    cursor: not-allowed;  
}';
	return $__finalCompiled;
}
);