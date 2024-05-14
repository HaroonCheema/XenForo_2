<?php
// FROM HASH: 08df2d50cd6985e78cc986945eb7bed6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['Page'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Owner Page');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Owner Page' . $__vars['xf']['language']['label_separator']);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . '

';
	$__templater->includeJs(array(
		'src' => 'xf/thread.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'prod' => 'xf/attachment_manager-compiled.js',
		'dev' => 'vendor/flow.js/flow-compiled.js, xf/attachment_manager.js',
	));
	$__finalCompiled .= '

' . $__templater->form('
 
	' . $__templater->formHiddenVal('attachment_time', $__vars['attachment_time'], array(
	)) . '
	
	' . $__templater->formHiddenVal('item_id', $__vars['item']['item_id'], array(
	)) . '
	<div class="block-container">
		<div class="block-body">
			
		
		<div class="js-inlineNewPostFields">
			
		' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['Page']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['Page'], 'title', ), false),
		'autofocus' => 'true',
	), array(
		'label' => 'Title',
	)) . '
			
		' . $__templater->formEditorRow(array(
		'name' => 'about',
		'value' => $__vars['Page']['Detail']['about'],
	), array(
		'label' => 'About',
	)) . '
		
		' . '
			
		</div>
			
			' . $__templater->formRow('
				' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
		'attachmentData' => $__vars['attachmentData'],
	), $__vars) . '
			', array(
	)) . '
	</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
			
	</div>

', array(
		'action' => $__templater->func('link', array('owners/save', $__vars['Page'], ), false),
		'ajax' => 'true',
		'data-xf-init' => 'attachment-manager thread-edit-form',
		'data-item-selector' => '.js-itemPage-' . $__vars['item']['item_id'] . ($__templater->method($__vars['Page'], 'isUpdate', array()) ? ('-' . $__vars['Page']->{'page_id'}) : ('-' . $__vars['xf']['visitor']['user_id'])),
	));
	return $__finalCompiled;
}
);