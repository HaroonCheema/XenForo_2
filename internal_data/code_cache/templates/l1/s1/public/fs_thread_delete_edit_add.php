<?php
// FROM HASH: c5e5280b8cd68ee9c4f89bd2c449bed0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Thread Delete Edit Users');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'users',
		'value' => $__vars['thread']['users'],
		'ac' => 'true',
		'required' => 'required',
	), array(
		'hint' => 'Required',
		'label' => 'Usernames',
		'explain' => 'You may enter multiple names here.',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/delete-edit', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);