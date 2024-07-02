<?php
// FROM HASH: b609ccfda7b749d223e46954543bca85
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['room'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Create room');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit room' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['room']['tag']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['room'], 'isUpdate', array())) {
		$__compilerTemp1 = '';
		if ($__templater->method($__vars['room'], 'isMemberType', array())) {
			$__compilerTemp1 .= '
		' . $__templater->button('
			' . 'New link' . '
		', array(
				'href' => $__templater->func('link', array('chat/rooms/get-new-link', $__vars['room'], ), false),
				'overlay' => 'true',
			), '', array(
			)) . '
	';
		}
		$__compilerTemp2 = '';
		if ($__templater->method($__vars['room'], 'canDelete', array())) {
			$__compilerTemp2 .= '
		' . $__templater->button('', array(
				'href' => $__templater->func('link', array('chat/rooms/delete', $__vars['room'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
	';
		}
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
	' . $__compilerTemp2 . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp3 = '';
	if ($__vars['room']['avatar_date']) {
		$__compilerTemp3 .= '
				' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'delete_avatar',
			'label' => 'Delete current avatar',
			'_type' => 'option',
		)), array(
		)) . '
			';
	}
	$__compilerTemp4 = '';
	if ($__templater->method($__vars['room'], 'canEditType', array())) {
		$__compilerTemp4 .= '
				' . $__templater->formSelectRow(array(
			'name' => 'type',
			'value' => $__vars['room']['type'],
		), array(array(
			'value' => 'public',
			'label' => 'public',
			'_type' => 'option',
		),
		array(
			'value' => 'member',
			'label' => 'member',
			'_type' => 'option',
		)), array(
			'label' => 'Type',
			'explain' => '<em>public</em> – will be visible to all users.<br>
<em>member</em> – access will be by link only.',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'tag',
		'value' => $__vars['room']['tag'],
	), array(
		'label' => 'Tag',
		'explain' => 'Users currently chatting in the room will be disconnected after changing the tag.',
	)) . '
	
			' . $__templater->formTextAreaRow(array(
		'rows' => '5',
		'name' => 'description',
		'maxlength' => $__templater->func('max_length', array('BS\\RealTimeChat:Room', 'description', ), false),
		'value' => $__vars['room']['description'],
	), array(
		'label' => 'Description',
	)) . '
			
			' . $__compilerTemp3 . '
			
			' . $__templater->formUploadRow(array(
		'name' => 'avatar',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Upload an avatar',
	)) . '
			
			' . $__compilerTemp4 . '
			
			' . $__templater->formHiddenVal('pinned', '0', array(
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'pinned',
		'checked' => $__vars['room']['pinned'],
		'label' => 'Pinned',
		'_type' => 'option',
	)), array(
	)) . '
			
			' . $__templater->formNumberBoxRow(array(
		'name' => 'pin_order',
		'value' => $__vars['room']['pin_order'],
	), array(
		'label' => 'Pin order',
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('chat/rooms/save', $__vars['room'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);