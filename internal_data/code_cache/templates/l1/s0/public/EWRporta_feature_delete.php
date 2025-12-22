<?php
// FROM HASH: f5cf284612ad2cbf818eeb50881a499a
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
				' . 'Please confirm that you want to delete the feature promotion for' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->func('link', array('threads', $__vars['feature']['Thread'], ), true) . '">' . $__templater->escape($__vars['feature']['Thread']['title']) . '</a></strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/feature-delete', $__vars['feature']['Thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);