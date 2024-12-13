<?php
// FROM HASH: 3f30a9dae4620ad0385878fb2b20f6c3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
';
	$__templater->includeJs(array(
		'src' => 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
	));
	$__finalCompiled .= '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

';
	$__templater->inlineJs('

	$(document).ready(function(){

	jQuery(\'a[id^="yt-url-"]\').magnificPopup({
	type: \'iframe\'
	});

	jQuery(\'a[id^="video-file-"]\').magnificPopup({
	type: \'iframe\'
	});

	});
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('fs_yt_video_slider.less');
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'FS/YtVideos/jquery.fts.1.0.js',
		));
		$__templater->includeJs(array(
			'src' => 'FS/YtVideos/jquery.fts.wheel.js',
		));
		$__templater->includeJs(array(
			'src' => 'FS/YtVideos/jquery.fts.min.js',
		));
		$__templater->inlineJs('
		' . '' . '
		' . '' . '
		' . $__templater->includeTemplate('fs_yt_video_slider_js', $__vars) . '
	');
		$__finalCompiled .= '
	<div class="block ftslider">
		<div class="block-container">
			<h3 class="block-header">' . ($__templater->escape($__vars['title']) ?: '[FS] Yt Videos') . '</h3>	

			<div class="block-body">	
				<div id="fs_yt_video_fullwidth_slider" class="everslider fullwidth-slider">
					<ul class="es-slides">
						';
		$__vars['key'] = 0;
		if ($__templater->isTraversable($__vars['data'])) {
			foreach ($__vars['data'] AS $__vars['value']) {
				$__vars['key']++;
				$__finalCompiled .= '
							<li>

								';
				if ($__vars['value']['thumbnail']) {
					$__finalCompiled .= '
									<a class="yt-url" id="yt-url-' . $__templater->escape($__vars['value']['video_id']) . '" href="' . $__templater->escape($__templater->method($__vars['value'], 'getYtWatchUrl', array())) . '">

										<img src="' . $__templater->escape($__vars['value']['thumbnail']) . '" 
											 alt="xyz' . $__templater->escape($__vars['key']) . '.jpeg"
											 loading="lazy"
											 style="width: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_image_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_image_dimensions']['height']) . 'px;"
											 title="' . $__templater->escape($__vars['value']['title']) . '"
											 />
									</a>
									';
				} else {
					$__finalCompiled .= '
									<a class="video-file" id="video-file-' . $__templater->escape($__vars['value']['video_id']) . '" href="' . $__templater->escape($__vars['value']['Attachment']['direct_url']) . '">

										<video data-xf-init="video-init" 
											   style="width: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_image_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_yt_slider_image_dimensions']['height']) . 'px;"
											   >
											<source src="' . $__templater->escape($__vars['value']['Attachment']['direct_url']) . '" />
										</video>
									</a>
								';
				}
				$__finalCompiled .= '		

							</li>
						';
			}
		}
		$__finalCompiled .= '
					</ul>
				</div>
			</div>
		</div>
	</div>	
';
	}
	return $__finalCompiled;
}
);