<?php
// FROM HASH: fef063a3626c534dfe49eee2c8a49c82
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Clone ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('This option allows you to create a new ad with the same data as "' . $__templater->escape($__vars['ad']['name']) . '" ad.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This option allows you to create a new ad with the same data as "' . $__templater->escape($__vars['ad']['name']) . '" ad.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'basic_info', array(
		'ad' => $__vars['ad'],
		'packages' => $__vars['packages'],
	), $__vars) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'submit' => 'Clone',
		'sticky' => 'true',
	), array(
		'rowtype' => 'simple',
	)) . '
 	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/clone', $__vars['ad'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);