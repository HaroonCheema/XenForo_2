<?php
// FROM HASH: 2506d867d7974936a769979eaaa9db9a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Import forms');
	$__finalCompiled .= '

';
	if ($__vars['success']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">' . 'Forms import was completed successfully' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'mode',
		'value' => 'upload',
	), array(array(
		'label' => 'Import from uploaded XML file',
		'value' => 'upload',
		'hint' => 'Use this option to import an XML file containing your form definitions.',
		'_dependent' => array($__templater->formUpload(array(
		'name' => 'upload',
		'accept' => '.xml',
	))),
		'_type' => 'option',
	),
	array(
		'label' => 'Import from a directory on your server',
		'value' => 'directory',
		'hint' => 'Use this option to scan a web-accessible directory containing your form definitions.',
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'directory',
		'placeholder' => 'data/forms-export.xml',
	))),
		'_type' => 'option',
	)), array(
	)) . '
			
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'merge',
		'value' => '1',
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Merge import',
		'explain' => 'The default action of an import is to replace all existing information. To keep your existing information and merge the import with the existing information, check this box.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('form-import', ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);