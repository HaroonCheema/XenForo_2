<?php
// FROM HASH: d9eda7f61961b69e6e31ff9c8ce2e2aa
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/** 
 * Featured threads slider designed by XenTR.Net.
*/

.ftslider 
{	
	.block-header 
	{
		margin-bottom: 3px;		
	}
}

.ftslider_content > a 
{	
	text-transform: ' . $__templater->func('property', array('FTSlider_text_transform', ), true) . ';
}
.fullwidth-title 
{
	.xf-xtr_featured_slider();
	
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	line-height: 15px;
	
	.ftslider_excerpt 
	{
		display: none;
	}
	
	.ftslider_content .ftslider_excerpt a 
	{
		.xf-xtr_excerpts_color();
		font-family: ' . $__templater->func('property', array('FTSlider_excerptsfont', ), true) . ';
	}
}

.ftslider_content 
{
	padding: 0 @xf-paddingLarge;
	margin: (@xf-paddingMedium - 1px) 0;
	
	>a 
	{
		display: block;
		text-transform: ' . $__templater->func('property', array('FTSlider_text_transform', ), true) . ';
		font-family: ' . $__templater->func('property', array('FTSlider_titlefont', ), true) . ';
		.xf-xtr_slider_content_title();
		cursor: pointer;

		&:hover 
		{
			.xf-xtr_slider_content_title_hover();
		}

		&:after 
		{
			content: "\\2192";
			margin-left: (@xf-paddingMedium - 1px);
		}
	}
}

.ftslider_title_detail 
{
	.xf-xtr_featured_slider_avatar_bar();
	
	.ftslider-date 
	{
		padding: @xf-paddingSmall;
		display: inline-block;
		cursor: default;
	}
}

.ftslider_statistics 
{
	float: right;
	display: inline-block;
	position: relative;
	padding: @xf-paddingSmall;
	cursor: default;
	
	i {
		.xf-xtr_statistic_icon_style();
		margin: (@xf-paddingMedium - 3px);
	}
}

.fullwidth-slider .es-slides > li:hover .fullwidth-title .ftslider_excerpt 
{
	display: inline-block;
	cursor: default;
}


// Featured threads slider mobile device
';
	if ($__templater->func('property', array('FTSlider_hide_mobile', ), false)) {
		$__finalCompiled .= '
@media (max-width: (@xf-FTSlider_hide_mobile_responsive - 1))
{
	.ftslider { display: none; }
}
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('FTSlider_avatar', ), false) == 'cycle') {
		$__finalCompiled .= '
.FTSlider_Avatar { border-radius: 50%; }
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('FTSlider_avatar', ), false) == 'square') {
		$__finalCompiled .= '
.FTSlider_Avatar { border-radius: 5%; }
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('FTSlider_title_infoblock', ), false)) {
		$__finalCompiled .= '
.ftslider_title_detail { display: none; }
';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('FTSlider_hide_thread_title', ), false)) {
		$__finalCompiled .= '
.ftslider_content > a { display: none; }
';
	}
	$__finalCompiled .= '

// Ever Slider
.everslider 
{
    position: relative;
    width: 100%;
    overflow: hidden;
}

.everslider .es-slides 
{
	position: relative;
	width: 100000px;
	margin: 0;
	padding: 0;
	list-style: none;
	-webkit-transform: translate3d(0,0,0);
}

.everslider .es-slides > li 
{
	position: relative;
	float: left;
	padding: 0!important;
    border: 0!important;
    margin: 0 ' . $__templater->func('property', array('xtr_featured_slider_margin', ), true) . 'px 0 0;
    cursor: default; 
	 -webkit-transform: translate3d(0,0,0);
}

.everslider.es-swipe-grab .es-slides > li 
{
	cursor: default; 
    cursor: -webkit-grabbing; 
    cursor: -moz-grabbing; 
}

.everslider .es-slides img 
{
	width: 100%;
	height: auto;
	max-width: none;
}

/* Preload */

.everslider 
{
	background: url(' . $__templater->func('base_url', array('styles/FTSlider/preload.gif', ), true) . ');
	background-position: center;
	background-repeat: no-repeat;
}

.everslider.es-slides-ready { background: none; }

.es-slides { visibility: hidden; }

.es-slides-ready .es-slides { visibility: visible; }

/* Navigation */
.es-navigation a 
{
    position: absolute;
    top: 50%;
    margin-top: -17px;
    padding: (@xf-paddingMedium + 1px);
}

.es-navigation .es-prev { left: 0 }
.es-navigation .es-next { right: 0 }

.es-navigation .es-first,
.es-navigation .es-last 
{
    opacity: 0.5;
    filter: alpha(opacity=50);
    cursor: default;
}

.es-navigation a .ftslider_excerpt 
{
	display: block;
	width: auto;
	height: 20px;
}

/* fullwidth slider */

.fullwidth-slider .es-slides > li 
{
	/* 1.6 ~ image width/height */
	width: 300px;	
	height: 189px !important;
	min-height: 187px;
	background: @xf-xtr_featured_slider--background-color;
	overflow: hidden;
}

.fullwidth-slider .es-navigation a 
{
	.xf-xtr_navigation_button_color();
}

.fullwidth-slider .es-ticker 
{
	bottom: auto;
	top: 0;
	margin-right: 34px;
}

.fullwidth-slider .es-slides > li img  
{
	opacity: 1;
	-webkit-transition: opacity .3s;
	-moz-transition: opacity .3s;
	-o-transition: opacity .3s;
	transition: opacity .3s;
}

.fullwidth-slider .es-slides > li:hover img { opacity: 0.8; }

[data-template="FTSlider_page"] .dataList-cell i { color: @xf-textColorDimmed; }';
	return $__finalCompiled;
}
);