<?php
// FROM HASH: 7903055c1b21425e597266ba2d2281f5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['author']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add author');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit author' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['author']['author_name']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Authors'), $__templater->func('link', array('ewr-porta/authors', ), false), array(
	));
	$__finalCompiled .= '

';
	if ($__vars['author']) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ewr-porta/authors/delete', $__vars['author'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">

		' . $__templater->callMacro('public:EWRporta_author_edit', 'edit_block', array(
		'author' => $__vars['author'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/authors/save', $__vars['author'], ), false),
		'upload' => 'true',
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);