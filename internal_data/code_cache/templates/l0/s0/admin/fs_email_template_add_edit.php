<?php
// FROM HASH: 927986a3f515355a9724edcf86f037f7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['tempData']['id']) {
		$__compilerTemp1 .= ' ' . 'Edit' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Edit'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= ' ' . 'Add' . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Add'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['tempData']['title'],
		'autosize' => 'true',
		'row' => '5',
		'required' => 'required',
	), array(
		'label' => 'Title',
		'hint' => 'Required',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'email_body',
		'value' => $__vars['tempData']['email_body'],
		'rows' => '2',
		'autosize' => 'true',
		'required' => 'required',
	), array(
		'label' => 'Body',
		'hint' => 'Required',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'save',
		'fa' => 'fa-save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('email-template/save', $__vars['tempData'], ), false),
		'class' => 'block',
		'ajax' => '1',
	));
	return $__finalCompiled;
}
);