<?php
// FROM HASH: 30bef32f3bf0363ce44bc907a2dbc827
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit article promotion' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['article']['Thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Articles'), $__templater->func('link', array('ewr-porta/articles', ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
		'href' => $__templater->func('link', array('ewr-porta/articles/delete', $__vars['thread'], ), false),
		'icon' => 'delete',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		
		' . $__templater->callMacro('public:EWRporta_article_edit', 'edit_block', array(
		'article' => $__vars['article'],
		'thread' => $__vars['thread'],
		'categories' => $__vars['categories'],
		'nonCategories' => $__vars['nonCategories'],
		'attachData' => $__vars['attachData'],
		'images' => $__vars['images'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/articles/save', $__vars['thread'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);