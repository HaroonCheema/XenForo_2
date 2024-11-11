<?php
// FROM HASH: ed0fdcc2590a13fe194e93fe43f8944c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('fs_logo_slider_list.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('fs_logo_slider_carousel.less');
		$__finalCompiled .= '

	';
		$__templater->includeJs(array(
			'prod' => 'LogoSlider/carousel-compiled.js',
			'dev' => 'vendor/fancyapps/carousel/carousel.umd.js, vendor/fancyapps/carousel/carousel.autoplay.umd.js',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'LogoSlider/slider.js',
			'min' => '1',
		));
		$__finalCompiled .= '

	';
		$__templater->inlineJs('
		XF.extendObject(XF.phrases, {
		next_slide: "' . $__templater->filter('next_slide', array(array('escape', array('js', )),), false) . '",
		previous_slide: "' . $__templater->filter('previous_slide', array(array('escape', array('js', )),), false) . '",
		go_to_slide_x: "' . $__templater->filter('go_to_slide_x', array(array('escape', array('js', )),), false) . '"
		});
	');
		$__finalCompiled .= '

	';
		$__templater->inlineCss('
		[data-widget-key="' . $__vars['widget']['key'] . '"]
		{
		--xfmg-slidesPerPage: ' . $__vars['xf']['options']['fs_logo_slider_logos'] . ';
		}

		@media (max-width: 900px)
		{
		[data-widget-key="' . $__vars['widget']['key'] . '"]
		{
		--xfmg-slidesPerPage: 4;
		}
		}

		@media (max-width: 650px)
		{
		[data-widget-key="' . $__vars['widget']['key'] . '"]
		{
		--xfmg-slidesPerPage: 3;
		}
		}

		@media (max-width: 480px)
		{
		[data-widget-key="' . $__vars['widget']['key'] . '"]
		{
		--xfmg-slidesPerPage: 2;
		}
		}
	');
		$__finalCompiled .= '

	<div class="block" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">
				<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . ($__templater->escape($__vars['title']) ?: '[FS] Logo Slider') . '</a>
			</h3>
			<div class="block-body block-row">
				<div class="itemList itemList--slider"
					 data-xf-init="item-slider"
					 data-xf-item-slider=\'{"item":' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logos']) . ',"itemWide":4,"itemMedium":3,"itemNarrow":2,"auto":true,"pauseOnHover":true,"loop":true,"pager":false}\'>

					';
		if ($__templater->isTraversable($__vars['data'])) {
			foreach ($__vars['data'] AS $__vars['key'] => $__vars['value']) {
				$__finalCompiled .= '
						<div class="itemList-item itemList-item--slider">
							<a href="' . $__templater->escape($__vars['value']['logo_url']) . '" target="_blank">

								<span class="xfmgThumbnail xfmgThumbnail--image xfmgThumbnail--fluid">
									<img class="xfmgThumbnail-image" src="' . $__templater->func('base_url', array($__templater->method($__vars['value'], 'getImgUrl', array()), ), true) . '" alt="xyz' . $__templater->escape($__vars['key']) . '.jpeg" loading="lazy" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logo_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logo_dimensions']['height']) . 'px;">
									<span class="xfmgThumbnail-icon"></span>
								</span>

							</a>
						</div>
					';
			}
		}
		$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);