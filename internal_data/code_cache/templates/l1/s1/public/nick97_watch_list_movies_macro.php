<?php
// FROM HASH: ff6915f7b3d8f925f2d046b7e84ee3d8
return array(
'macros' => array('movies' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'movies' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<style>

		.p-body-section{
			margin-bottom:0 !important;
		}
		#container
		{

			height: auto;
			overflow: hidden;
			margin: 0 auto;
			position: relative;
			margin-bottom:20px;
		}
		#list-container
		{
			overflow: hidden;
			width: 100%;
			float: left;
		}
		.list
		{

			min-width: 3400px;
			float: left;
			display: flex;
		}

		#arrowL::before,#arrowR::before{
			font-family: "Font Awesome 5 Pro";
			content: "\\f053";
			background: #fff;
			border-radius: 50%;

			color: #2196f3;
			display: block;
			font-size: 20px;
			font-weight: bold;
			height: 40px;
			line-height: 40px;
			opacity: 1;
			width: 40px;
			text-align: center;
		}



		#arrowR::before {
			font-family: "Font Awesome 5 Pro";
			content: "\\f054";
		}	


		#arrowR
		{
			background: transparent;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			float: right;
			cursor: pointer;
			top: 126px;
			text-align: center;
			font-family: Arial;
			font-size: 0px;
			color: transparent;
			padding:2px 2px;
			position: absolute;
			z-index: 100;
			right: 20px;

			display: block;
			line-height: 0px;
			font-size: 0px;
			padding: 0;
			border: none;
			outline: none;
		}
		#arrowL
		{
			top: 145px;
			left: 9px;
			background: transparent;
			width: 40px;
			height: 40px;
			float: left;
			cursor: pointer;
			text-align: center;
			font-family: Arial;
			color: transparent;
			position: absolute;
			z-index: 100;
			border-radius: 50%;
			cursor: pointer;
			display: block;
			line-height: 0px;
			font-size: 0px;
			-webkit-transform: translate(0, -50%);
			padding: 0;
			border: none;
			outline: none;
		}
		.item
		{
			margin: 0 10px 0 0;
			float: left;
			position: relative;
			text-align: center;
			font-family: Arial;
			font-size: 20px;
			color: White;
		}

		div.item iframe{
			width: 100%;
			height: 100%;
		}
		div.p-body-section div.p-body-section-header span.p-body-section-icon i.fa-gamepad-alt.screen-icon:before {
			content: "\\f108" !important;
		}


		/* MEDIA QUERIES.............
		MEDIA QUERIES.............
		MEDIA QUERIES............. */

		@media only screen and (max-width: 600px) {
			#container{
				width: 100%;
			}
			.item{
				margin: 0 15px 0 15px;
			}
		}



		/* Container to hold the two boxes */
		.container {
			display: flex; /* Use flexbox */
			justify-content: space-between; /* Add space between the two boxes */
			flex-wrap: wrap; /* Allow wrapping to the next line on smaller screens */
		}

		/* Styles for the individual boxes */
		.box {
			display: block;
			box-sizing: border-box; /* Include padding and border in the box\'s total width */
			margin-bottom: 5px; /* Add some space between the boxes */
		}

		.right_glitchvideo{
			cursor: pointer;
		}

		.right_glitchvideo:hover{
			color: blue;
		}


	</style>


	<div class="p-body-section">
		<div class="p-body-section-header">
			<div class="container">
				<div class="box">
					<h2>Movies</h2>
				</div>

				';
	if ($__templater->func('count', array($__vars['movies'], ), false) > 1) {
		$__finalCompiled .= '

					<div class="right_glitchvideo box">
						<h2><i class="fas fa-chevron-right"></i></h2>
					</div>

				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	';
	if ($__templater->func('count', array($__vars['movies'], ), false) > 0) {
		$__finalCompiled .= '


		<div id="container">

			' . '

			<div id="list-container">

				' . '

				<div class=\'list glitchvideo\' style="">

					';
		if ($__templater->isTraversable($__vars['movies'])) {
			foreach ($__vars['movies'] AS $__vars['movie']) {
				$__finalCompiled .= '

						<div class=\'item\'>
							<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '">
							<img src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '" style="width: 185px; height: 278px; border-radius: 6px;" />
							</a>
						</div>

					';
			}
		}
		$__finalCompiled .= '		

				</div>


			</div>

		</div>

		';
	} else {
		$__finalCompiled .= '

		<div class="empty">' . 'There are no movies in this Watch List.' . '</div>

	';
	}
	$__finalCompiled .= '


	';
	$__templater->inlineJs('

		$(document).ready(function(){
		$(".right_glitchvideo").click(function(){
		var item_width = $(\'#list-container div.glitchvideo div.item\').width(); 
		var left_value = item_width * (-1); 
		var left_indent = parseInt($(\'#list-container div.glitchvideo\').css(\'left\')) - item_width;
		$(\'#list-container div.glitchvideo \').animate({\'left\' : left_indent}, 100, function () {
		$(\'#list-container div.glitchvideo div.item:last\').after($(\'#list-container div.glitchvideo div.item:first\'));                  
		$(\'#list-container div.glitchvideo\').css({\'left\' : left_value});
		});
		});

		$(".left_glitchvideo").click(function(){
		var item_width = $(\'#list-container div.glitchvideo div.item\').width(); 
		var right_value = item_width * (+1); 
		var right_indent = parseInt($(\'#list-container div.glitchvideo\').css(\'right\')) + item_width;
		$(\'#list-container div.glitchvideo \').animate({\'right\' : right_indent}, 100, function () {
		$(\'#list-container div.glitchvideo div.item:first\').before($(\'#list-container div.glitchvideo div.item:last\'));                  
		$(\'#list-container div.glitchvideo\').css({\'right\' : right_value});
		});
		});
		});

	');
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'tvShow' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tvShows' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<style>

		.p-body-section1{
			margin-bottom:0 !important;
		}
		#container1
		{

			height: auto;
			overflow: hidden;
			margin: 0 auto;
			position: relative;
			margin-bottom:20px;
		}
		#list-container1
		{
			overflow: hidden;
			width: 100%;
			float: left;
		}
		.list1
		{

			min-width: 3400px;
			float: left;
			display: flex;
		}

		#arrowL1::before,#arrowR1::before{
			font-family: "Font Awesome 5 Pro";
			content: "\\f053";
			background: #fff;
			border-radius: 50%;

			color: #2196f3;
			display: block;
			font-size: 20px;
			font-weight: bold;
			height: 40px;
			line-height: 40px;
			opacity: 1;
			width: 40px;
			text-align: center;
		}



		#arrowR1::before {
			font-family: "Font Awesome 5 Pro";
			content: "\\f054";
		}	


		#arrowR1
		{
			background: transparent;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			float: right;
			cursor: pointer;
			top: 126px;
			text-align: center;
			font-family: Arial;
			font-size: 0px;
			color: transparent;
			padding:2px 2px;
			position: absolute;
			z-index: 100;
			right: 20px;

			display: block;
			line-height: 0px;
			font-size: 0px;
			padding: 0;
			border: none;
			outline: none;
		}
		#arrowL1
		{
			top: 145px;
			left: 9px;
			background: transparent;
			width: 40px;
			height: 40px;
			float: left;
			cursor: pointer;
			text-align: center;
			font-family: Arial;
			color: transparent;
			position: absolute;
			z-index: 100;
			border-radius: 50%;
			cursor: pointer;
			display: block;
			line-height: 0px;
			font-size: 0px;
			-webkit-transform: translate(0, -50%);
			padding: 0;
			border: none;
			outline: none;
		}
		.item1
		{
			margin: 0 10px 0 0;
			float: left;
			position: relative;
			text-align: center;
			font-family: Arial;
			font-size: 20px;
			color: White;
		}

		div.item1 iframe1{
			width: 100%;
			height: 100%;
		}
		div.p-body-section1 div.p-body-section-header1 span.p-body-section-icon1 i.fa-gamepad-alt1.screen-icon1:before {
			content: "\\f108" !important;
		}


		/* MEDIA QUERIES.............
		MEDIA QUERIES.............
		MEDIA QUERIES............. */

		@media only screen and (max-width: 600px) {
			#container1{
				width: 100%;
			}
			.item1{
				margin: 0 15px 0 15px;
			}
		}



		/* container1 to hold the two boxes */
		.container1 {
			display: flex; /* Use flexbox */
			justify-content: space-between; /* Add space between the two boxes */
			flex-wrap: wrap; /* Allow wrapping to the next line on smaller screens */
		}

		/* Styles for the individual boxes */
		.box1 {
			display: block;
			box-sizing: border-box; /* Include padding and border in the box\'s total width */
			margin-bottom: 5px; /* Add some space between the boxes */
		}

		.right_glitchvideo1{
			cursor: pointer;
		}

		.right_glitchvideo1:hover{
			color: blue;
		}

		.empty {
			text-align: center;
			font-size: 18px;
			color: #555;
		}


	</style>


	<div class="p-body-section1">
		<div class="p-body-section-header1">
			<div class="container1">
				<div class="box1">
					<h2>TV & Shows</h2>
				</div>

				';
	if ($__templater->func('count', array($__vars['tvShows'], ), false) > 1) {
		$__finalCompiled .= '

					<div class="right_glitchvideo1 box1">
						<h2><i class="fas fa-chevron-right"></i></h2>
					</div>

				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	';
	if ($__templater->func('count', array($__vars['tvShows'], ), false) > 0) {
		$__finalCompiled .= '

		<div id="container1">

			' . '

			<div id="list-container1">

				' . '

				<div class=\'list1 glitchvideo\' style="">

					';
		if ($__templater->isTraversable($__vars['tvShows'])) {
			foreach ($__vars['tvShows'] AS $__vars['movie']) {
				$__finalCompiled .= '

						<div class=\'item1\'>
							<a class="carousel-item-image" href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '">
							<img src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '" style="width: 185px; height: 278px; border-radius: 6px;" />
							</a>
						</div>

					';
			}
		}
		$__finalCompiled .= '		

				</div>


			</div>

		</div>

		';
	} else {
		$__finalCompiled .= '

		<div class="empty">' . 'There are no Tv Shows in this Watch List.' . '</div>

	';
	}
	$__finalCompiled .= '


	';
	$__templater->inlineJs('

		$(document).ready(function(){
		$(".right_glitchvideo1").click(function(){
		var item_width = $(\'#list-container1 div.glitchvideo div.item1\').width(); 
		var left_value = item_width * (-1); 
		var left_indent = parseInt($(\'#list-container1 div.glitchvideo\').css(\'left\')) - item_width;
		$(\'#list-container1 div.glitchvideo \').animate({\'left\' : left_indent}, 100, function () {
		$(\'#list-container1 div.glitchvideo div.item1:last\').after($(\'#list-container1 div.glitchvideo div.item1:first\'));                  
		$(\'#list-container1 div.glitchvideo\').css({\'left\' : left_value});
		});
		});

		$(".left_glitchvideo1").click(function(){
		var item_width = $(\'#list-container1 div.glitchvideo div.item1\').width(); 
		var right_value = item_width * (+1); 
		var right_indent = parseInt($(\'#list-container1 div.glitchvideo\').css(\'right\')) + item_width;
		$(\'#list-container1 div.glitchvideo \').animate({\'right\' : right_indent}, 100, function () {
		$(\'#list-container1 div.glitchvideo div.item1:first\').before($(\'#list-container1 div.glitchvideo div.item1:last\'));                  
		$(\'#list-container1 div.glitchvideo\').css({\'right\' : right_value});
		});
		});
		});

	');
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '


';
	return $__finalCompiled;
}
);