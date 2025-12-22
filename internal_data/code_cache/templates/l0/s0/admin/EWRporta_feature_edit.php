<?php
// FROM HASH: c34f79d67933f6db9c7ae4b23f6a809f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit feature promotion' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['feature']['Thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Features'), $__templater->func('link', array('ewr-porta/features', ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
		'href' => $__templater->func('link', array('ewr-porta/features/delete', $__vars['thread'], ), false),
		'icon' => 'delete',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => '8wayrun/porta/portal.js',
	));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		
		' . $__templater->callMacro('public:EWRporta_feature_edit', 'edit_block', array(
		'feature' => $__vars['feature'],
		'thread' => $__vars['thread'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/features/save', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);