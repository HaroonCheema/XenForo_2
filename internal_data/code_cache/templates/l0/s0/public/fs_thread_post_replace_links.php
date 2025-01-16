<?php
// FROM HASH: 0eb0651b6786d051e6ba8ab156ac0287
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Replace Links' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped('Replace Links' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'old_link',
		'required' => 'required',
	), array(
		'label' => 'Old link',
		'explain' => 'Enter old link here...!',
		'hint' => 'Required',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'new_link',
		'required' => 'required',
	), array(
		'label' => 'New link',
		'explain' => 'Enter new link here...!',
		'hint' => 'Required',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/replace-links', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);