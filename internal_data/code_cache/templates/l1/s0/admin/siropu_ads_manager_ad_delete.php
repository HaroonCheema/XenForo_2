<?php
// FROM HASH: 72e7181d40ae03bf97afede3759c2aee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['ad'], 'getInvoiceCount', array())) {
		$__compilerTemp1 .= '
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'delete_invoices',
			'value' => '1',
			'label' => 'Delete invoices' . ' (' . $__templater->escape($__templater->method($__vars['ad'], 'getInvoiceCount', array())) . ')',
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), true) . '">' . $__templater->escape($__vars['ad']['name']) . '</a></strong>
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
		'action' => $__templater->func('link', array('ads-manager/ads/delete', $__vars['ad'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);