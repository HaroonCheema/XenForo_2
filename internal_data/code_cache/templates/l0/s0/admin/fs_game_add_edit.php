<?php
// FROM HASH: 448d09abe70b6c43622028dd00b0e315
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['game_id']) {
		$__compilerTemp1 .= ' ' . 'Edit Game' . ' : ' . $__templater->escape($__vars['data']['title']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit Game'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add Game' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add Game'), '#', array(
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
		'row' => '5',
	), array(
		'label' => 'Title',
		'hint' => 'required',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'description',
		'value' => $__vars['data']['description'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Description',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('game/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);