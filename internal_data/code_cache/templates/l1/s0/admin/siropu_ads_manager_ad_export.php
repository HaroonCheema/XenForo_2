<?php
// FROM HASH: 5b0df7360418375047e2bd96072f15b3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This option allows you to export the ad data as an XML file.
<br>
Please note that daily and click statistics are not included in the export.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'export',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/export', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);