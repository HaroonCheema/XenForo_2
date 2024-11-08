<?php
// FROM HASH: 69264c86e5b01389189796065a0ef1e0
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
		$__templater->includeCss('lightslider.less');
		$__finalCompiled .= '

	';
		$__templater->includeJs(array(
			'src' => 'vendor/lightslider/lightslider.js',
			'min' => '1',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'LogoSlider/slider.js',
			'min' => '1',
		));
		$__finalCompiled .= '

	<div class="block" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">
				<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . ($__templater->escape($__vars['title']) ?: '[FS] Logo Slider') . '</a>
			</h3>
			<div class="block-body block-row">
				<div class="itemList itemList--slider"
					 data-xf-init="item-slider"
					 data-xf-item-slider=\'{"item":' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logos']) . ',"itemWide":3,"itemMedium":2,"itemNarrow":1,"auto":true,"loop":true}\'>
					
					';
		if ($__templater->isTraversable($__vars['data'])) {
			foreach ($__vars['data'] AS $__vars['key'] => $__vars['value']) {
				$__finalCompiled .= '
						<div class="itemList-item itemList-item--slider">
							<a href="' . $__templater->escape($__vars['value']['logo_url']) . '" target="_blank">
								<span class="xfmgThumbnail xfmgThumbnail--image xfmgThumbnail--fluid">
									<img class="xfmgThumbnail-image" src="' . $__templater->func('base_url', array($__templater->method($__vars['value'], 'getImgUrl', array()), ), true) . '" alt="xyz' . $__templater->escape($__vars['key']) . '.jpeg" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logo_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_logo_slider_logo_dimensions']['height']) . 'px;">
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