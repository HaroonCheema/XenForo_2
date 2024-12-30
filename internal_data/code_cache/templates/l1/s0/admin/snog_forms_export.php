<?php
// FROM HASH: b5360cc6fb9df194c157a4441c926cb0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export forms');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formSelectRow(array(
		'name' => 'mode',
		'value' => 'xml',
	), array(array(
		'label' => 'XML',
		'value' => 'xml',
		'hint' => 'Use this option to import an XML file containing your form definitions.',
		'_type' => 'option',
	),
	array(
		'label' => 'CSV*',
		'value' => 'csv',
		'hint' => 'Use this option to scan a web-accessible directory containing your form definitions.',
		'_type' => 'option',
	)), array(
		'label' => 'Export file format',
	)) . '
			' . $__templater->formCheckBoxRow(array(
		'name' => 'data',
	), array(array(
		'label' => 'Form',
		'value' => 'forms',
		'checked' => '1',
		'_type' => 'option',
	),
	array(
		'label' => 'Types',
		'value' => 'types',
		'checked' => '1',
		'_type' => 'option',
	),
	array(
		'label' => 'Questions',
		'value' => 'questions',
		'checked' => '1',
		'_type' => 'option',
	),
	array(
		'label' => 'Logs' . '*',
		'value' => 'logs',
		'_type' => 'option',
	),
	array(
		'label' => 'Answers' . '*',
		'value' => 'answers',
		'_type' => 'option',
	)), array(
		'label' => 'Export file format',
	)) . '
			' . $__templater->formRow('
				' . '* Cannot be used to import.' . '
			', array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('form-export', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);