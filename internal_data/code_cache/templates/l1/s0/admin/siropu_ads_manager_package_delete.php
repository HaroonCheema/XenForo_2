<?php
// FROM HASH: 933b5788f61a01b6d8940ee15be56908
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.samDeletePackage .iconic
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
			'name' => 'delete_ads',
			'value' => '1',
			'label' => 'Delete ads' . ' (' . $__templater->escape($__vars['package']['ad_count']) . ')',
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<p>' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '</p>
				<strong><a href="' . $__templater->func('link', array('ads-manager/packages/edit', $__vars['package'], ), true) . '">' . $__templater->escape($__vars['package']['title']) . '</a></strong>
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/packages/delete', $__vars['package'], array('redirect' => $__vars['redirect'], ), ), false),
		'ajax' => 'true',
		'class' => 'block samDeletePackage',
	));
	return $__finalCompiled;
}
);