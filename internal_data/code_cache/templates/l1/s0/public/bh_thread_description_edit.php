<?php
// FROM HASH: efa2d3fa3fc42bfddafbac403aac7480
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['thread']['thread_description']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit description' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['thread']['title']));
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add description' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['thread']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '


' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formEditorRow(array(
		'name' => 'thread_description',
		'value' => $__vars['thread']['thread_description'],
		'data-min-height' => '200',
	), array(
		'label' => 'Discussion Description',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/save-description', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);