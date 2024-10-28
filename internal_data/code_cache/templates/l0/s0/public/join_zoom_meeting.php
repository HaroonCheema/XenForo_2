<?php
// FROM HASH: e058ab491448e2498f6478b912cc6e33
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
				' . 'After the Register You will get the Join Url.' . '
				
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
	' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('meetings/join', $__vars['meeting'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);