<?php
// FROM HASH: 2c4eb8d6466d4009e5a6e18bfb89876c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Upload custom invoice' . $__vars['xf']['language']['label_separator'] . ' #' . $__templater->escape($__vars['invoice']['invoice_id']));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['invoice']['invoice_file']) {
		$__compilerTemp1 .= '
				' . $__templater->formRow('', array(
			'label' => 'Current upload',
			'html' => $__templater->escape($__vars['invoice']['invoice_file']),
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => '.pdf,.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Upload invoice',
		'explain' => 'This option allows you to use your own custom business invoice.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'upload',
		'submit' => 'Upload',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/invoices/upload', $__vars['invoice'], ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);