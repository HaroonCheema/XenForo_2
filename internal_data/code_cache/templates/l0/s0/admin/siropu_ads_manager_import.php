<?php
// FROM HASH: 2b8af28deda6a1d1c784048b095db435
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Import from file');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => '.xml,.zip',
	), array(
		'label' => 'Import from file',
	)) . '
			<hr class="formRowSep" />
			' . $__templater->formRadioRow(array(
		'name' => 'on_duplicate',
		'value' => 'update',
	), array(array(
		'value' => 'update',
		'label' => 'Update existing items with the data from the import',
		'_type' => 'option',
	),
	array(
		'value' => 'insert',
		'label' => 'Insert data from the import as separate items',
		'_type' => 'option',
	)), array(
		'label' => 'If duplicates are found' . $__vars['xf']['language']['ellipsis'],
		'explain' => 'Choose what do if items with the same ID exista in the database.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'import',
		'submit' => 'Import',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array(('ads-manager/' . $__vars['route']) . '/import', ), false),
		'upload' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);