<?php
// FROM HASH: 1f3307acf567c653c9ea6cba5b61b5a1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '$(document).ready(function(){	
			
			$(\'#fs_auction_fullwidth_slider\').everslider({
				mode: \'carousel\',
				effect: \'\',
				fadeEasing: \'linear\',
				fadeDuration: \'\',
				fadeDelay: \'\',
				fadeDirection: \'\',
				moveSlides: ' . $__templater->escape($__vars['xf']['options']['FTSlider_skip_thread']) . ',
				slideEasing: \'easeInOutCubic\',
				slideDuration: ' . $__templater->escape($__vars['xf']['options']['FTSlider_transit_speed']) . ',
				navigation: true,
				touchSwipe: false,
				keyboard: true,
				swipeThreshold: 10,
				nextNav: \'<span class="alt-arrow"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>\',
				prevNav: \'<span class="alt-arrow"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>\',
				ticker: ' . $__templater->escape($__vars['xf']['options']['FTSlider_auto']) . ',
				tickerAutoStart: true,
				tickerHover: true,
				tickerTimeout: ' . $__templater->escape($__vars['xf']['options']['FTSlider_ticker_timeout']) . '
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