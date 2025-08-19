<?php
// FROM HASH: 7fa45886f9fc55d5f892a0a7e010324c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Package statistics' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['package'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->dataList('
				' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'Total ads',
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->func('sam_total_views_impressions_phrase', array(), true),
	),
	array(
		'_type' => 'cell',
		'html' => 'Total clicks',
	),
	array(
		'_type' => 'cell',
		'html' => 'Average CTR',
	))) . '
				' . $__templater->dataRow(array(
	), array(array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['stats']['total_ads']),
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['stats']['total_views']),
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['stats']['total_clicks']),
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['stats']['avg_ctr']) . '%',
	))) . '
			', array(
	)) . '
		</div>
	</div>
</div>

';
	if (!$__templater->test($__vars['ads'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->callMacro('siropu_ads_manager_ad_stats_macros', 'ad_stats', array(
			'ads' => $__vars['ads'],
			'total' => $__vars['total'],
		), $__vars) . '

	' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ads-manager/packages/statistics',
			'data' => $__vars['package'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
';
	}
	return $__finalCompiled;
}
);