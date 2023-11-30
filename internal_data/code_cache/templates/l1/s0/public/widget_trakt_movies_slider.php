<?php
// FROM HASH: 92f0c1957b22ae8b3bf0dbe6530bbe77
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['movies'], 'empty', array())) {
		$__finalCompiled .= '

	';
		$__templater->includeCss('carousel.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('lightslider.less');
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'prod' => 'xf/carousel-compiled.js',
			'dev' => 'vendor/lightslider/lightslider.min.js, xf/carousel.js',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'dev' => 'nick97/TraktMovies/slider.js',
			'prod' => 'nick97/TraktMovies/slider.min.js',
			'addon' => 'nick97/TraktMovies',
		));
		$__finalCompiled .= '

	<div class="carousel carousel--withFooter" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<ul class="carousel-body carousel-body--show2" data-xf-init="trakt-movies-slider"
			data-xf-trakt-movies-slider="' . $__templater->filter($__vars['options']['slider'], array(array('json', array()),), true) . '">
			';
		if ($__templater->isTraversable($__vars['movies'])) {
			foreach ($__vars['movies'] AS $__vars['movie']) {
				$__finalCompiled .= '
				<li>
					<div class="carousel-item">
						<div class="contentRow">
							<div class="contentRow-figure">
								<span class="contentRow-figureIcon"><img src="' . $__templater->escape($__templater->method($__vars['movie'], 'getImageUrl', array())) . '" /></span>
							</div>

							<div class="contentRow-main">
								<div class="contentRow-title">
									<a href="' . $__templater->func('link', array('threads', $__vars['movie']['Thread'], ), true) . '">' . $__templater->escape($__vars['movie']['Thread']['title']) . '</a>
									<span class="label">' . $__templater->fontAwesome('star', array(
				)) . ' ' . $__templater->escape($__vars['movie']['trakt_rating']) . '</span>
								</div>

								';
				if ($__vars['options']['show_plot'] AND $__vars['movie']['trakt_plot']) {
					$__finalCompiled .= '
									<div class="contentRow-lesser">
										' . $__templater->func('snippet', array($__vars['movie']['trakt_plot'], 150, ), true) . '
									</div>
								';
				}
				$__finalCompiled .= '

								<div class="contentRow-minor contentRow-minor--smaller">
									<ul class="listInline listInline--bullet">
										';
				if ($__vars['options']['show_tagline'] AND $__vars['movie']['trakt_tagline']) {
					$__finalCompiled .= '<li><b>' . 'Tagline' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_tagline']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_genres'] AND $__vars['movie']['trakt_genres']) {
					$__finalCompiled .= '<li><b>' . 'Genre' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_genres']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_director'] AND $__vars['movie']['trakt_director']) {
					$__finalCompiled .= '<li><b>' . 'Director' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_director']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_cast'] AND $__vars['movie']['trakt_cast']) {
					$__finalCompiled .= '<li><b>' . 'Cast' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_cast']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_status'] AND $__vars['movie']['trakt_status']) {
					$__finalCompiled .= '<li><b>' . 'Status' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_status']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_release_date'] AND $__vars['movie']['trakt_release']) {
					$__finalCompiled .= '<li><b>' . 'Release' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_release']) . '</li>';
				}
				$__finalCompiled .= '
										';
				if ($__vars['options']['show_runtime'] AND $__vars['movie']['trakt_runtime']) {
					$__finalCompiled .= '<li><b>' . 'Runtime' . ':</b> ' . $__templater->escape($__vars['movie']['trakt_runtime']) . '</li>';
				}
				$__finalCompiled .= '
									</ul>
								</div>
							</div>
						</div>
					</div>
				</li>
			';
			}
		}
		$__finalCompiled .= '
		</ul>
	</div>
';
	}
	return $__finalCompiled;
}
);