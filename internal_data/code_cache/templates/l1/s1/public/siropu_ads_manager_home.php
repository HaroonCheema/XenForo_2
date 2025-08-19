<?php
// FROM HASH: a21834077cf740e4dcc5bb5ee8b034cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ads Manager');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			<div class="block-row">
				' . $__templater->func('bb_code', array($__vars['xf']['options']['siropuAdsManagerHomeMessage'], 'siropu_ads_manager', $__vars['xf']['visitor'], ), true) . '
			</div>
		</div>
		<div class="block-footer">
			' . $__templater->button('View packages', array(
		'href' => $__templater->func('link', array('ads-manager/packages', ), false),
		'icon' => 'list',
		'class' => 'button--link',
	), '', array(
	)) . '
			';
	if ($__vars['xf']['visitor']['is_admin']) {
		$__finalCompiled .= '
				' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/edit', ), false),
			'icon' => 'edit',
			'overlay' => 'true',
		), '', array(
		)) . '
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);