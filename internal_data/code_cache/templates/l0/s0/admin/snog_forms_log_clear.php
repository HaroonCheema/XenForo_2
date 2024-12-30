<?php
// FROM HASH: c9ef2f6a908aa0ab168e5043695d4688
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Are you sure you want to clear the form submit log?' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			
			' . $__templater->formInfoRow('
				' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'clear_answers',
		'selected' => 1,
		'label' => 'Clear answers',
		'_type' => 'option',
	))) . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Clear',
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
 ', array(
		'action' => $__templater->func('link', array('logs/forms-logs/clear', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);