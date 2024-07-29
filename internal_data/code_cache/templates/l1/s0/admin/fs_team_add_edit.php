<?php
// FROM HASH: cc51b1123f7cd3ce4dcffa95e390ebe3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['id']) {
		$__compilerTemp1 .= ' ' . 'Edit Team' . ' : ' . $__templater->escape($__vars['data']['title']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit Team'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add Team' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add Team'), '#', array(
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
		'value' => $__vars['data']['title'],
		'autosize' => 'true',
		'required' => 'required',
		'row' => '5',
	), array(
		'label' => 'Title',
		'hint' => 'Required',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'image',
		'accept' => '.jpeg,.jpg,.jpe,.png',
		'required' => 'required',
	), array(
		'label' => 'Image',
		'hint' => 'Required',
		'explain' => 'Add image here...!',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('team/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);