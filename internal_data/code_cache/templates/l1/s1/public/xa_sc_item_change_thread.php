<?php
// FROM HASH: 3f0130064f39721e13a3f13bb51df283
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Change discussion thread');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['item'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['item']['discussion_thread_id']) {
		$__compilerTemp1 .= '
				' . $__templater->formRadioRow(array(
			'name' => 'thread_action',
			'value' => 'update',
		), array(array(
			'value' => 'update',
			'label' => 'Update discussion thread' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'thread_url',
			'value' => ($__templater->method($__vars['item'], 'hasViewableDiscussion', array()) ? $__templater->func('link', array('full:threads', $__vars['item']['Discussion'], ), false) : ''),
			'placeholder' => 'Thread URL',
		))),
			'_type' => 'option',
		),
		array(
			'value' => 'disconnect',
			'label' => 'Disconnect existing discussion',
			'_type' => 'option',
		)), array(
			'label' => 'Action',
		)) . '
			';
	} else {
		$__compilerTemp1 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => 'thread_url',
		), array(
			'label' => 'Discussion thread URL',
		)) . '
				' . $__templater->formHiddenVal('thread_action', 'update', array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('showcase/change-thread', $__vars['item'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);