<?php
// FROM HASH: 6cd3cb81d77060b05f29861fc2755c74
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.samDeleteAll .iconic
	{
		width: auto;
	}
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<p>' . 'Are you sure you want to delete all the ads?' . '</p>
				' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'delete_invoices',
		'value' => '1',
		'label' => 'Delete invoices',
		'_type' => 'option',
	))) . '
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
		'action' => $__templater->func('link', array('ads-manager/ads/delete-all', ), false),
		'ajax' => 'true',
		'class' => 'block samDeleteAll',
	));
	return $__finalCompiled;
}
);