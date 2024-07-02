<?php
// FROM HASH: ef843b71b574d631f46a92c923a79349
return array(
'macros' => array('type_edit_room' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['author'] = $__templater->preEscaped('
		' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
	))) . '
	');
	$__finalCompiled .= '
	
	';
	$__vars['formId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '

	';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/room-form.js',
		'min' => '1',
	));
	$__vars['form'] = $__templater->preEscaped('
		' . '' . '
		' . $__templater->form('
			<div class="form-header">
				' . 'Edit room' . '
			</div>
			<div class="form-body">
				<div class="input chat-header-input">
					<div class="avatar-box avatar-box--bordered" data-xf-init="rtc-avatar-box">
						' . $__templater->func('rtc_room_avatar', array($__vars['message']['Room'], 's', ), true) . '
						<input type="file" 
							   class="upload-input" 
							   name="avatar" 
							   accept=".gif,.jpeg,.jpg,.jpe,.png">
					</div>

					<div class="input tag-input chat-input">
						<div class="tag-prefix">' . $__templater->escape($__vars['message']['Room']['tag_prefix']) . '/</div>
						' . $__templater->formTextBox(array(
		'name' => 'tag',
		'readonly' => 'true',
		'placeholder' => 'Love',
		'value' => $__vars['message']['Room']['tag_name'],
	)) . '
					</div>
				</div>
				' . $__templater->formTextArea(array(
		'rows' => '5',
		'name' => 'description',
		'placeholder' => 'Description',
		'maxlength' => $__templater->func('max_length', array('BS\\RealTimeChat:Room', 'description', ), false),
		'value' => $__vars['message']['Room']['description'],
	)) . '

				' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'allow_messages_from_others',
		'checked' => $__vars['message']['Room']['allowed_replies'],
		'label' => 'Allow messages from other users',
		'_type' => 'option',
	))) . '
				
				' . $__templater->formCheckBox(array(
		'style' => 'display:none',
	), array(array(
		'name' => 'delete_avatar',
		'_type' => 'option',
	))) . '
			</div>
		', array(
		'action' => $__templater->func('link', array('chat/messages/update-room', $__vars['message'], ), false),
		'id' => $__vars['formId'],
		'class' => 'chat-message-form',
		'ajax' => 'true',
		'data-redirect' => 'off',
		'data-reset-complete' => 'on',
	)) . '
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	if ($__vars['message']['Room']['avatar_date']) {
		$__compilerTemp1 .= '
			' . $__templater->button('Delete current avatar', array(
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< .js-message | input[name=\'delete_avatar\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
		';
	}
	$__vars['actions'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '
		' . $__templater->button('Confirm', array(
		'form' => $__vars['formId'],
		'type' => 'submit',
	), '', array(
	)) . '
	');
	$__finalCompiled .= '
	
	' . $__templater->callMacro(null, 'rtc_message_macros::type_bubble', array(
		'message' => $__vars['message'],
		'text' => $__vars['form'],
		'filter' => $__vars['filter'],
		'actions' => $__vars['actions'],
		'form' => true,
	), $__vars) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);