<?php
// FROM HASH: 071cdbf47852172463cf30513a7940dd
return array(
'macros' => array('resource' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'filterPrefix' => false,
		'resource' => '!',
		'category' => null,
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
	); },
'extensions' => array('icon_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

			<div class="structItem-cell structItem-cell--icon" style="width: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_width']) : $__templater->escape($__vars['xf']['options']['thumbnail_width'])) . '; height: ' . ($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height'] ? $__templater->escape($__vars['thread']['Forum']['Node']['node_thread_thumbnail_height']) : $__templater->escape($__vars['xf']['options']['thumb_size_hemant'])) . ';">

				<div class="structItem-iconContainer">
					';
	if ($__templater->func('count', array($__vars['resource']['Description']['Attachments'], ), false) == 1) {
		$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" class="" data-tp-primary="on">

							';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['resource']['Description']['Attachments'])) {
			foreach ($__vars['resource']['Description']['Attachments'] AS $__vars['attachment']) {
				if ($__vars['attachment']['has_thumbnail']) {
					$__vars['i']++;
					$__finalCompiled .= '
								<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_width_percen']) . '%; height: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_height_pixcels']) . 'px; object-fit: cover; border-bottom: solid 2px #fa7d24" loading="lazy">
							';
				}
			}
		}
		$__finalCompiled .= '
						</a>
						';
	} else if ($__templater->func('count', array($__vars['resource']['Description']['Attachments'], ), false) > 1) {
		$__finalCompiled .= '
						<div class="slider-container">
							<div class="slider">
								';
		$__vars['i'] = 0;
		if ($__templater->isTraversable($__vars['resource']['Description']['Attachments'])) {
			foreach ($__vars['resource']['Description']['Attachments'] AS $__vars['attachment']) {
				if ($__vars['attachment']['has_thumbnail']) {
					$__vars['i']++;
					$__finalCompiled .= '
									<img src="' . $__templater->escape($__vars['attachment']['thumbnail_url']) . '" class="' . (($__vars['i'] == 1) ? 'active' : ' ') . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_width_percen']) . '%; height: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_height_pixcels']) . 'px; object-fit: cover; border-bottom: solid 2px #fa7d24" loading="lazy">
								';
				}
			}
		}
		$__finalCompiled .= '
							</div>
							<button class="nav-button left">&lt;</button>
							<button class="nav-button right">&gt;</button>
						</div>
						';
	} else {
		$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" class="" data-tp-primary="on">
							<img src="' . $__templater->escape($__vars['xf']['options']['fs_rm_m_bg_img']) . '" alt="' . $__templater->escape($__vars['attachment']['filename']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_width_percen']) . '%; height: ' . $__templater->escape($__vars['xf']['options']['fs_rm_resource_height_pixcels']) . 'px; object-fit: cover; border-bottom: solid 2px #fa7d24" loading="lazy">
						</a>
					';
	}
	$__finalCompiled .= '
				</div>
			</div>
		';
	return $__finalCompiled;
},
'statuses' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '

								';
	if ($__vars['showWatched'] AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
									';
		if ($__vars['thread']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__finalCompiled .= '
										<li>
											<i class="structItem-status structItem-status--watched" aria-hidden="true" title="' . $__templater->filter('Thread watched', array(array('for_attr', array()),), true) . '"></i>
											<span class="u-srOnly">' . 'Thread watched' . '</span>
										</li>
									';
		}
		$__finalCompiled .= '
								';
	}
	$__finalCompiled .= '

							';
	return $__finalCompiled;
},
'main_cell' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
			<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

				';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
							' . $__templater->renderExtension('statuses', $__vars, $__extensions) . '
						';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
					<ul class="structItem-statuses">
						' . $__compilerTemp1 . '
					</ul>
				';
	}
	$__finalCompiled .= '

				<div class="structItem-title">
					';
	if ($__vars['resource']['prefix_id']) {
		$__finalCompiled .= '
						';
		if ($__vars['category']) {
			$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('resources/categories', $__vars['category'], array('prefix_id' => $__vars['resource']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '</a>
							';
		} else {
			$__finalCompiled .= '
							';
			if ($__vars['filterPrefix']) {
				$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('resources', null, array('prefix_id' => $__vars['resource']['prefix_id'], ), ), true) . '" class="labelLink" rel="nofollow">' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '</a>
								';
			} else {
				$__finalCompiled .= '
								' . $__templater->func('prefix', array('resource', $__vars['resource'], 'html', '', ), true) . '
							';
			}
			$__finalCompiled .= '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('resources', $__vars['resource'], ), true) . '" class="" data-tp-primary="on">' . $__templater->escape($__vars['resource']['title']) . '</a>
					';
	if ($__templater->method($__vars['resource'], 'isVersioned', array())) {
		$__finalCompiled .= '
						<span class="u-muted">' . $__templater->escape($__vars['resource']['CurrentVersion']['version_string']) . '</span>
					';
	}
	$__finalCompiled .= '
					';
	if ($__templater->method($__vars['resource'], 'isExternalPurchasable', array())) {
		$__finalCompiled .= '
						<span class="label label--primary label--smallest">' . $__templater->filter($__vars['resource']['price'], array(array('currency', array($__vars['resource']['currency'], )),), true) . '</span>
					';
	}
	$__finalCompiled .= '
				</div>

				<div class="structItem-minor">
					' . '

					';
	if ($__vars['resource']['resource_state'] == 'deleted') {
		$__finalCompiled .= '
						' . $__templater->callMacro('deletion_macros', 'notice', array(
			'log' => $__vars['resource']['DeletionLog'],
		), $__vars) . '
						';
	} else {
		$__finalCompiled .= '
						<ul class="structItem-parts">
							<li>' . $__templater->func('username_link', array($__vars['resource']['User'], false, array(
			'defaultname' => $__vars['resource']['username'],
		))) . '</li>
							';
		if ((!$__vars['category']) OR $__templater->method($__vars['category'], 'hasChildren', array())) {
			$__finalCompiled .= '
								<li><a href="' . $__templater->func('link', array('resources/categories', $__vars['resource']['Category'], ), true) . '">' . $__templater->escape($__vars['resource']['Category']['title']) . '</a></li>
							';
		}
		$__finalCompiled .= '
						</ul>
						<br/>
						' . $__templater->func('snippet', array($__vars['resource']['Description']['message'], 50, array('stripBbCode' => true, ), ), true) . '
					';
	}
	$__finalCompiled .= '
					<br/>
					<br/>
					<div class="structItem-cell--resourceMeta">
						<div class="structItem-metaItem  structItem-metaItem--rating">
							' . $__templater->callMacro('rating_macros', 'stars_text', array(
		'rating' => $__vars['resource']['rating_avg'],
		'count' => $__vars['resource']['rating_count'],
		'rowClass' => 'ratingStarsRow--justified',
		'starsClass' => 'ratingStars--larger',
	), $__vars) . '
						</div>

					</div>
				</div>
			</div>
		';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<style>
		.slider-container {
			width: 100%;
			max-width: 600px;
			overflow: hidden;
			position: relative;
			margin: 0px auto;
		}

		.slider {
			display: flex;
			transition: transform 0.5s ease-in-out;
		}

		.slider img {
			width: 100%;
			flex-shrink: 0;
			height: 300px;
			object-fit: cover;
			display: none;
		}

		.slider img.active {
			display: block;
		}

		/* Left and right navigation buttons */
		.nav-button {
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			background-color: #fff;
			color: #575f6d;
			border: none;
			cursor: pointer;
			font-size: 18px;
			z-index: 10;
		}

		.nav-button.left {
			left: 0px;
			border-radius: 0 10px 10px 0;
			padding: 2px 10px 2px 15px;
		}

		.nav-button.right {
			right: 0px;
			border-radius: 10px 0 0 10px;
			padding: 2px 15px 2px 10px;
		}
	</style>

	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

	<div class="structItem structItem--thread' . ($__vars['resource']['prefix_id'] ? ('is-prefix' . $__templater->escape($__vars['resource']['prefix_id'])) : '') . ' ' . ($__templater->method($__vars['resource'], 'isIgnored', array()) ? 'is-ignored' : '') . (($__vars['resource']['resource_state'] == 'moderated') ? 'is-moderated' : '') . (($__vars['resource']['resource_state'] == 'deleted') ? 'is-deleted' : '') . ' js-inlineModContainer js-resourceListItem-' . $__templater->escape($__vars['resource']['resource_id']) . '" data-author="' . ($__templater->escape($__vars['resource']['User']['username']) ?: $__templater->escape($__vars['resource']['username'])) . '">

		' . $__templater->renderExtension('icon_cell', $__vars, $__extensions) . '

		' . $__templater->renderExtension('main_cell', $__vars, $__extensions) . '

	</div>

	<script>
		// Function to initialize sliders
		function initializeSliders() {
			const sliders = document.querySelectorAll(\'.slider-container\');

			sliders.forEach((sliderContainer) => {
				const slider = sliderContainer.querySelector(\'.slider\');
				const images = slider.getElementsByTagName(\'img\');
				const imageCount = images.length;
				let currentIndex = 0;

				const leftButton = sliderContainer.querySelector(\'.nav-button.left\');
				const rightButton = sliderContainer.querySelector(\'.nav-button.right\');

				function changeSlide(index) {
					for (let img of images) {
						img.classList.remove(\'active\');
					}
					images[index].classList.add(\'active\');
				}

				// Left button click event
				leftButton.addEventListener(\'click\', () => {
					currentIndex--;
					if (currentIndex < 0) {
						currentIndex = imageCount - 1;
					}
					changeSlide(currentIndex);
				});

				// Right button click event
				rightButton.addEventListener(\'click\', () => {
					currentIndex++;
					if (currentIndex >= imageCount) {
						currentIndex = 0;
					}
					changeSlide(currentIndex);
				});

				// Initialize first slide
				changeSlide(currentIndex);
			});
		}

		// Initialize all sliders on the page
		window.onload = initializeSliders;
	</script>

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);