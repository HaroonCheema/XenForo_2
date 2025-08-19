<?php
// FROM HASH: 2f1f61648cd42476b7a882191b2d458f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('template', 'SIROPU_ADS_MANAGER_EMBED');
	$__finalCompiled .= '

';
	$__vars['xf']['samLoadJsCarousel'] = $__vars['loadCarousel'];
	$__finalCompiled .= '

';
	if ($__vars['loadCarousel']) {
		$__finalCompiled .= '
	<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
';
	}
	$__finalCompiled .= '

' . $__templater->includeTemplate('siropu_ads_manager_ad_js', $__vars) . '

' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
		'position' => 'embed',
		'ads' => $__vars['ads'],
	), $__vars);
	return $__finalCompiled;
}
);