<?php
// FROM HASH: b7aa6ff028427af0f57d7b91c12842e8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Advertisers');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['ads'], 'empty', array())) {
		$__finalCompiled .= '
	';
		if ($__vars['xf']['options']['siropuAdsManagerJsFilePath']) {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => $__vars['xf']['options']['siropuAdsManagerJsFilePath'],
			));
			$__finalCompiled .= '
	';
		} else {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => 'siropu/am/core.js',
				'min' => '1',
			));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '
	';
		$__templater->includeCss('siropu_ads_manager_ad.less');
		$__templater->inlineCss('
		.samTextUnit
		{
			display: block;
			border: 0;
			margin: 0;
		}
		.samTextUnit .samItem
		{
			margin-bottom: 20px;
		}
		.samTextUnit .samItem:last-child
		{
			margin-bottom: 0;
		}
	');
		$__finalCompiled .= '

	';
		if ($__templater->isTraversable($__vars['ads'])) {
			foreach ($__vars['ads'] AS $__vars['type'] => $__vars['adGroup']) {
				$__finalCompiled .= '
		<div class="block">
			<div class="block-container">
				<div class="block-body block-row">
					' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_' . $__vars['type'], array(
					'position' => 'advertisers',
					'ads' => $__templater->func('sam_order_ads', array($__vars['adGroup'], ), false),
					'firstAd' => $__templater->filter($__vars['adGroup'], array(array('first', array()),), false),
					'unitAttributes' => 'class=\'sam' . $__templater->filter($__vars['type'], array(array('to_upper', array('ucwords', )),), false) . 'Unit\' data-position=\'advertisers\'',
					'carousel' => true,
				), $__vars) . '
				</div>
			</div>
		</div>
	';
			}
		}
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'We do not have active advertisers at the moment.' . '</div>
';
	}
	return $__finalCompiled;
}
);