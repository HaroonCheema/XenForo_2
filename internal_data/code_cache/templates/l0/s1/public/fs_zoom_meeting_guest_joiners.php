<?php
// FROM HASH: 60003b402f896bc9add78fe6fd35bf5f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['meeting']['topic']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->formTextBox(array(
		'name' => 'guest_username',
		'required' => 'true',
	)) . '
			', array(
		'label' => 'username',
		'explain' => 'Username required to join meeting.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('video-chat/', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);