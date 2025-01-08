<?php
// FROM HASH: 1c0144324015cbc63c5a575a8ef813a8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['model']['model_id']) {
		$__compilerTemp1 .= ' ' . 'Edit model' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Edit model'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= ' ' . 'Add model' . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Add model'), '#', array(
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
		'name' => 'model',
		'value' => $__vars['model']['model'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Name',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'save',
		'fa' => 'fa-save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('car-model/save', $__vars['model'], ), false),
		'class' => 'block',
		'ajax' => '1',
	));
	return $__finalCompiled;
}
);