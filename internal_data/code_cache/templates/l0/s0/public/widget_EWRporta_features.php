<?php
// FROM HASH: 61475f9161846a711b33b12b7f6b43b7
return array(
'macros' => array('feature_item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'feature' => '!',
		'key' => '!',
		'options' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="porta-features-item feature-' . $__templater->escape($__vars['key']) . '" style="background-image: url(\'' . $__templater->func('base_url', array($__vars['feature']['image'], ), true) . '\');">
		<a class="porta-features-fix" href="' . $__templater->func('link', array('threads', $__vars['feature']['Thread'], ), true) . '">
			<div class="porta-features-summary">
				<div class="title">' . ($__vars['feature']['feature_title'] ? $__templater->escape($__vars['feature']['feature_title']) : $__templater->escape($__vars['feature']['Thread']['title'])) . '</div>
				<div class="description">
					' . $__templater->func('snippet', array($__vars['feature']['feature_excerpt'], ($__vars['options']['trim'] ?: $__vars['xf']['options']['EWRporta_articles_trim']), array('stripBbCode' => true, ), ), true) . '
				</div>
			</div>
		</a>

		';
	if ($__vars['feature']['feature_media']) {
		$__finalCompiled .= '
			<div class="porta-features-media" data-slide="' . $__templater->escape($__vars['key']) . '" data-media="' . $__templater->escape($__vars['feature']['feature_media']) . '">
				<div id="youTube' . $__templater->escape($__vars['key']) . '"></div>
			</div>
			<div class="bx-controls-volume">
				<a class="bx-unmute" href="">Unmute</a>
				<a class="bx-mute active" href="">Mute</a>
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['features'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('widget_EWRporta_features.less');
		$__finalCompiled .= '

	';
		$__templater->includeJs(array(
			'src' => '8wayrun/porta/slider.js',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => '8wayrun/porta/portal.js',
		));
		$__finalCompiled .= '

	<div class="block porta-features porta-features-fix"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '
		 data-xf-init="porta-features" data-relocate="' . $__templater->escape($__vars['options']['relocate']) . '"
		 data-mode="' . $__templater->escape($__vars['options']['mode']) . '" data-speed="' . $__templater->escape($__vars['options']['speed']) . '" data-auto="' . $__templater->escape($__vars['options']['auto']) . '"
		 data-pager="' . $__templater->escape($__vars['options']['pager']) . '" data-controls="' . $__templater->escape($__vars['options']['controls']) . '"
		 data-autoControls="' . $__templater->escape($__vars['options']['autoControls']) . '" data-progress="' . $__templater->escape($__vars['options']['progress']) . '">
		<div class="porta-features-container">
			';
		$__vars['key'] = 0;
		if ($__templater->isTraversable($__vars['features'])) {
			foreach ($__vars['features'] AS $__vars['feature']) {
				$__vars['key']++;
				$__finalCompiled .= '
				' . $__templater->callMacro(null, 'feature_item', array(
					'feature' => $__vars['feature'],
					'key' => $__vars['key'],
					'options' => $__vars['options'],
				), $__vars) . '
			';
			}
		}
		$__finalCompiled .= '
		</div>

		';
		if ($__vars['options']['progress']) {
			$__finalCompiled .= '
			<div class="bx-progress">&nbsp;</div>
		';
		}
		$__finalCompiled .= '
	</div>
';
	}
	$__finalCompiled .= '


';
	return $__finalCompiled;
}
);