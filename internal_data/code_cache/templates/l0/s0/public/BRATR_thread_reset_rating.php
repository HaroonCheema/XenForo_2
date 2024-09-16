<?php
// FROM HASH: 4c2710acd7cca067c5505a6fd098a25b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reset rating of thread' . ' - ' . $__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . 'You sure you want to reset rating of this thread: ' . ((('<strong>' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true)) . $__templater->escape($__vars['thread']['title'])) . '</strong>') . '' . '
			', array(
		'rowtype' => 'noLabel',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'reason',
		'placeholder' => 'Reason',
	), array(
		'label' => 'Reason reset rating',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'refresh',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('threads/br-reset-rating', $__vars['thread'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);