<?php
// FROM HASH: a70375f8b70453107c1d9870b1b81dee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Terms and conditions');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="block-row">
				' . $__templater->func('bb_code', array($__vars['xf']['options']['siropuAdsManagerTermsAndConditions'], 'siropu_ads_manager', $__vars['xf']['visitor'], ), true) . '
			</div>
		</div>
		';
	if ($__vars['xf']['visitor']['is_admin']) {
		$__finalCompiled .= '
			<div class="block-footer">
					' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/terms-and-conditions/edit', ), false),
			'icon' => 'edit',
			'overlay' => 'true',
		), '', array(
		)) . '
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
</div>';
	return $__finalCompiled;
}
);