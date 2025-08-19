<?php
// FROM HASH: 3874dca6378ecd118d00f31fbf3e9047
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('General statistics' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['ad'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['ad']['view_count']) {
		$__compilerTemp1 .= '
			' . $__templater->formSubmitRow(array(
		), array(
			'html' => '
					' . $__templater->button('Reset', array(
			'href' => $__templater->func('link', array('ads-manager/ads/reset-stats', $__vars['ad'], array('type' => 'general', ), ), false),
			'overlay' => 'true',
			'icon' => 'refresh',
		), '', array(
		)) . '
				',
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('', array(
		'label' => $__templater->func('sam_views_impressions_phrase', array(), true),
		'html' => $__templater->escape($__vars['ad']['view_count']),
	)) . '
			' . $__templater->formRow('', array(
		'label' => 'Clicks',
		'html' => $__templater->escape($__vars['ad']['click_count']),
	)) . '
			' . $__templater->formRow('', array(
		'label' => 'CTR',
		'hint' => 'Click-through rate',
		'html' => $__templater->escape($__vars['ad']['ctr']) . '%',
	)) . '
		</div>
		' . $__compilerTemp1 . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/general-stats', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);