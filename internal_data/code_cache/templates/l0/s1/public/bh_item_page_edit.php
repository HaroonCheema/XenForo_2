<?php
// FROM HASH: 3ceb641223ac93db102b70c3a674b9c0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['Page'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('bh_add_owner_page');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('bh_edit_owner_page:');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['Page'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('bh_item/ownerpage/delete', $__vars['Page'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
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
			
		' . $__templater->formEditorRow(array(
		'name' => 'about',
		'value' => $__vars['Page']['Detail']['about'],
	), array(
		'label' => 'bh_page_about',
	)) . '
			
		' . $__templater->formEditorRow(array(
		'name' => 'attachment',
		'value' => $__vars['Page']['Detail']['attachment'],
	), array(
		'label' => 'bh_page_attachment',
	)) . '
		
		' . $__templater->formEditorRow(array(
		'name' => 'customizations',
		'value' => $__vars['Page']['Detail']['customizations'],
	), array(
		'label' => 'bh_page_customizations',
	)) . '
		
			
	
			
		</div>
	</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
			
	</div>

', array(
		'action' => $__templater->func('link', array('bh_item/ownerpage/save', $__vars['Page'], ), false),
		'ajax' => 'true',
		'data-xf-init' => 'attachment-manager',
	));
	return $__finalCompiled;
}
);