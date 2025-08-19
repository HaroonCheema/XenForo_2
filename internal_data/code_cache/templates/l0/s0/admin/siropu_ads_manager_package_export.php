<?php
// FROM HASH: 72c188d6f98440bf9e77a9c50af4407c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export package' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['title']));
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.samExport .iconic
	{
		width: auto;
	}
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['package']['ad_count']) {
		$__compilerTemp1 .= '
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'export_ads',
			'value' => '1',
			'checked' => 'true',
			'label' => 'Export ads' . ' (' . $__templater->escape($__vars['package']['ad_count']) . ')',
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<p>' . 'This option allows you to export the package data as an XML file.' . '</p>
				' . $__compilerTemp1 . '
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
		'action' => $__templater->func('link', array('ads-manager/packages/export', $__vars['package'], ), false),
		'class' => 'block samExport',
	));
	return $__finalCompiled;
}
);