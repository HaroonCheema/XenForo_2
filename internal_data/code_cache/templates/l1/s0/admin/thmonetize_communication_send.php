<?php
// FROM HASH: bec5164c95d281cdd8e67f5d36950b96
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
				' . $__templater->escape($__vars['confirmation']) . '
				<strong>
					<a href="' . $__templater->func('link', array('thmonetize-communications/edit', $__vars['communication'], ), true) . '">
						' . $__templater->escape($__vars['communication']['title']) . '
					</a>
				</strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Send now',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('thmonetize-communications/send', $__vars['communication'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);