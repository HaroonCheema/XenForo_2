<?php
// FROM HASH: b3e1e710f0ec9e2f4dfe2402a13b2112
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['id']) {
		$__compilerTemp1 .= ' ' . 'Edit' . ' : ' . $__templater->escape($__vars['data']['word']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add New' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add New'), '#', array(
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
		'name' => 'word',
		'value' => $__vars['data']['word'],
		'autosize' => 'true',
		'row' => '5',
		'required' => 'required',
		'minlength' => '4',
	), array(
		'label' => 'Enter Word',
		'hint' => 'Required',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'link',
		'value' => $__vars['data']['link'],
		'autosize' => 'true',
		'row' => '5',
		'required' => 'required',
		'minlength' => '10',
	), array(
		'label' => 'Enter Link',
		'hint' => 'Required',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('info-text/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);