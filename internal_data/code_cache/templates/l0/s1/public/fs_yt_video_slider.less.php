<?php
// FROM HASH: 05ad57d2fcb01d12619f15f2aba99e1c
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
	text-transform: uppercase;
}

.fullwidth-slider .es-navigation a {
    color: #ffffff;
    background: rgba(0, 0, 0, 0.6);
}

.ftslider_title_detail {
    font-size: 13px;
    color: #fefefe;
    background: rgba(97, 97, 97, 0.6) url(styles/FS/YtVideos/title.png);
    padding: 6px;
    box-shadow: inset rgba(255, 255, 255, 0.3) 0px 1px 0px, rgba(0, 0, 0, 0.3) 0px 1px 3px;
    margin-bottom: 3px;
}

.ftslider_content > a {
    display: block;
    text-transform: uppercase;
    font-family: \'Segoe UI\', \'Helvetica Neue\', Helvetica, Roboto, Oxygen, Ubuntu, Cantarell, \'Fira Sans\', \'Droid Sans\', sans-serif;
    font-size: 13px;
    color: #ffffff;
    text-decoration: none;
    cursor: pointer;
}

.fullwidth-title .ftslider_content .ftslider_excerpt a {
    font-size: 11px;
    color: #edf6fd;
    text-decoration: none;
    font-family: \'Segoe UI\', \'Helvetica Neue\', Helvetica, Roboto, Oxygen, Ubuntu, Cantarell, \'Fira Sans\', \'Droid Sans\', sans-serif;
}

.fullwidth-title {
    font-size: 11px;
    color: #ffffff;
    background: rgba(31, 31, 31, 0.7);
    border-bottom: 1px solid #dfdfdf;
    padding: 0;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 4px;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    line-height: 15px;
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
		font-family: "\'Segoe UI\', \'Helvetica Neue\', Helvetica, Roboto, Oxygen, Ubuntu, Cantarell, \'Fira Sans\', \'Droid Sans\', sans-serif";
	}
}

.ftslider_content 
{
	padding: 0 @xf-paddingLarge;
	margin: (@xf-paddingMedium - 1px) 0;
	
	>a 
	{
		display: block;
		text-transform: uppercase;
		font-family: "\'Segoe UI\', \'Helvetica Neue\', Helvetica, Roboto, Oxygen, Ubuntu, Cantarell, \'Fira Sans\', \'Droid Sans\', sans-serif";
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

.FTSlider_Avatar { border-radius: 50%; }

';
	if (false) {
		$__finalCompiled .= '
.fullwidth-title { display: none; }
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
    margin: 0 6px 0 0;
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
	background: url(' . $__templater->func('base_url', array('styles/FS/YtVideos/preload.gif', ), true) . ');
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
	background: rgba(97, 97, 97, 0.6);
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

.fullwidth-slider .es-slides > li:hover img { opacity: 0.8; }';
	return $__finalCompiled;
}
);