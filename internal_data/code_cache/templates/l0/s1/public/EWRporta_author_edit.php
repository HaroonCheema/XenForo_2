<?php
// FROM HASH: 1a8aacdc89343705d3924fc061ee468f
return array(
'macros' => array('edit_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'author' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-body" data-xf-init="porta-upload">

		' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'ac' => 'single',
		'value' => $__vars['author']['User']['username'],
		'readonly' => ($__vars['author'] ? 'readonly' : ''),
	), array(
		'label' => 'User',
	)) . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'author[author_name]',
		'value' => $__vars['author']['author_name'],
	), array(
		'label' => 'Name',
	)) . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'author[author_status]',
		'value' => $__vars['author']['author_status'],
	), array(
		'label' => 'Status',
	)) . '

		' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Image',
		'explain' => 'It is recommended that you use an image that is at least ' . '150' . 'x' . '200' . ' pixels.',
	)) . '

		';
	if ($__vars['author']['image']) {
		$__finalCompiled .= '
			' . $__templater->formRow('
				<img src="' . $__templater->func('base_url', array($__vars['author']['image'], ), true) . '" />
			', array(
			'rowtype' => 'noLabel',
		)) . '
		';
	}
	$__finalCompiled .= '

		' . $__templater->formEditorRow(array(
		'name' => 'byline',
		'value' => $__vars['author']['author_byline'],
	), array(
		'label' => 'Byline',
	)) . '
		' . $__templater->formNumberBoxRow(array(
		'name' => 'author[author_order]',
		'value' => $__vars['author']['author_order'],
		'min' => '1',
	), array(
		'label' => 'Display order',
	)) . '

	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit author');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['author']['author_name'])), $__templater->func('link', array('ewr-porta/authors', $__vars['author'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		
		' . $__templater->callMacro(null, 'edit_block', array(
		'author' => $__vars['author'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/authors/edit', $__vars['author'], ), false),
		'class' => 'block',
		'upload' => 'true',
		'ajax' => 'true',
	)) . '




';
	return $__finalCompiled;
}
);