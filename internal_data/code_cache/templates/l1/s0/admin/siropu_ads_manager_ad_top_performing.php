<?php
// FROM HASH: b9c38ea08ca5d38815af686a948481d9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Top performing ads');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Here you can see which ads perform the best based on click-through rate.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			<div class="inputGroup inputGroup--auto">
				<span>' . 'Order by' . $__vars['xf']['language']['label_separator'] . '
					' . $__templater->formSelect(array(
		'name' => 'order_field',
		'class' => 'input--inline',
		'value' => ($__vars['order']['field'] ?: 'ctr'),
	), array(array(
		'value' => 'name',
		'label' => 'Name',
		'_type' => 'option',
	),
	array(
		'value' => 'view_count',
		'label' => $__templater->func('sam_views_impressions_phrase', array(), true),
		'_type' => 'option',
	),
	array(
		'value' => 'click_count',
		'label' => 'Clicks',
		'_type' => 'option',
	),
	array(
		'value' => 'ctr',
		'label' => 'CTR',
		'_type' => 'option',
	))) . '

					' . $__templater->formSelect(array(
		'name' => 'order_direction',
		'class' => 'input--inline',
		'value' => ($__vars['order']['direction'] ?: 'desc'),
	), array(array(
		'value' => 'asc',
		'label' => 'Ascending',
		'_type' => 'option',
	),
	array(
		'value' => 'desc',
		'label' => 'Descending',
		'_type' => 'option',
	))) . '

					' . $__templater->button('', array(
		'type' => 'submit',
		'button' => 'Go',
	), '', array(
	)) . '
				</span>
			</div>
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/top-performing', ), false),
		'class' => 'block',
	)) . '

<h2 class="block-tabHeader tabs hScroller" data-xf-init="h-scroller">
	<span class="hScroller-scroll">
		<a href="' . $__templater->func('link', array('ads-manager/ads/top-performing', ), true) . '" class="tabs-tab' . (($__vars['status'] == '') ? ' is-active' : '') . '">' . 'Any status' . '</a>
		<a href="' . $__templater->func('link', array('ads-manager/ads/top-performing', '', array('status' => 'active', ), ), true) . '" class="tabs-tab' . (($__vars['status'] == 'active') ? ' is-active' : '') . '">' . 'Active' . '</a>
		<a href="' . $__templater->func('link', array('ads-manager/ads/top-performing', '', array('status' => 'inactive', ), ), true) . '" class="tabs-tab' . (($__vars['status'] == 'inactive') ? ' is-active' : '') . '">' . 'Inactive' . '</a>
	</span>
</h2>

' . $__templater->callMacro('siropu_ads_manager_ad_stats_macros', 'ad_stats', array(
		'ads' => $__vars['ads'],
		'header' => '',
	), $__vars) . '

' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ads-manager/ads/top-performing',
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	)));
	return $__finalCompiled;
}
);