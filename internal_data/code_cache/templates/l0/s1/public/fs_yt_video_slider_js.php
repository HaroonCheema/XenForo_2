<?php
// FROM HASH: e4bda998786a85bf0afec4f5c004cd32
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '$(document).ready(function(){	
			
			$(\'#fs_yt_video_fullwidth_slider\').everslider({
				mode: \'carousel\',
				effect: \'\',
				fadeEasing: \'linear\',
				fadeDuration: \'\',
				fadeDelay: \'\',
				fadeDirection: \'\',
				moveSlides: ' . $__templater->escape($__vars['xf']['options']['fs_yt_Slider_skip']) . ',
				slideEasing: \'easeInOutCubic\',
				slideDuration: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_transit_speed']) . ',
				navigation: true,
				touchSwipe: false,
				keyboard: true,
				swipeThreshold: 10,
				nextNav: \'' . $__templater->fontAwesome('fas fa-chevron-right', array(
	)) . '\',
				prevNav: \'' . $__templater->fontAwesome('fas fa-chevron-left', array(
	)) . '\',
				ticker: ' . $__templater->escape($__vars['xf']['options']['fs_yt_Slider_auto']) . ',
				tickerAutoStart: true,
				tickerHover: true,
				tickerTimeout: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_ticker_timeout']) . '
			});
			
			$(\'#fullwidth_slider_fade\').everslider({
				mode: \'carousel\',
				effect: \'fade\',
				moveSlides: 1,
				fadeEasing: \'linear\',
				fadeDuration: 500,
				fadeDelay: 200,
				fadeDirection: 1,
				navigation: true,
				touchSwipe: false,
				keyboard: true,
				swipeThreshold: 10,
				nextNav: \'<span class="alt-arrow"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>\',
				prevNav: \'<span class="alt-arrow"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>\',
				ticker: true,
				tickerAutoStart: false,
				tickerTimeout: 2000
			});
   });';
	return $__finalCompiled;
}
);