<?php
// FROM HASH: e2bea465de7107a9b1e9668a086dbdce
return array(
'macros' => array('ban_form' => array(
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
	$__compilerTemp1 = '';
	if (!$__vars['message']['extra_data']['lift']) {
		$__compilerTemp1 .= '
					' . $__templater->formTextArea(array(
			'name' => 'reason',
			'rows' => '1',
			'maxlength' => $__templater->func('max_length', array('BS\\RealTimeChat:Ban', 'reason', ), false),
			'placeholder' => 'Reason for banning',
		)) . '
					
					' . $__templater->formRadio(array(
			'name' => 'ban_length',
			'value' => ((!$__vars['user']['ChatBan']['unban_date']) ? 'permanent' : 'temporary'),
		), array(array(
			'label' => 'Permanent',
			'value' => 'permanent',
			'_type' => 'option',
		),
		array(
			'label' => 'For a while',
			'value' => 'while',
			'data-hide' => 'true',
			'_dependent' => array('
								<div class="inputGroup">
									' . $__templater->formNumberBox(array(
			'name' => 'length_value',
			'min' => '1',
		)) . '
									<span class="inputGroup-splitter"></span>
									' . $__templater->formSelect(array(
			'name' => 'length_unit',
			'class' => 'input--autoSize',
		), array(array(
			'value' => 'hours',
			'label' => 'Hours',
			'_type' => 'option',
		),
		array(
			'value' => 'days',
			'label' => 'Days',
			'_type' => 'option',
		),
		array(
			'value' => 'months',
			'label' => 'Months',
			'_type' => 'option',
		))) . '
								</div>
							'),
			'_type' => 'option',
		),
		array(
			'label' => 'Until',
			'value' => 'temporary',
			'data-hide' => 'true',
			'_dependent' => array('
								' . $__templater->formDateInput(array(
			'name' => 'unban_date',
			'value' => ($__vars['user']['ChatBan']['unban_date'] ? $__templater->func('date', array($__vars['user']['ChatBan']['unban_date'], 'Y-m-d', ), false) : ''),
			'data-min-date' => $__templater->func('date', array($__vars['xf']['time'], 'Y-m-d', ), false),
		)) . '
							'),
			'_type' => 'option',
		))) . '
				';
	}
	$__vars['form'] = $__templater->preEscaped('
		' . $__templater->form('
			<div class="form-header">
				' . $__templater->func('phrase_dynamic', array(($__vars['message']['extra_data']['lift'] ? 'lift_ban' : 'ban_user'), ), true) . '
			</div>
			<div class="form-body">
				' . $__templater->formTextBox(array(
		'placeholder' => 'Name',
		'name' => 'username',
		'ac' => 'single',
		'data-autosubmit' => 'false',
		'data-url' => $__templater->func('link', array('members', ), false),
		'autocomplete' => 'off',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
		'value' => $__vars['username'],
	)) . '
				
				' . $__compilerTemp1 . '
			</div>
		', array(
		'action' => ($__vars['message']['extra_data']['lift'] ? $__templater->func('link', array('chat/messages/lift-ban', $__vars['message'], ), false) : $__templater->func('link', array('chat/messages/ban', $__vars['message'], ), false)),
		'class' => 'chat-message-form',
		'id' => $__vars['formId'],
		'ajax' => 'true',
		'data-redirect' => 'off',
	)) . '
	');
	$__finalCompiled .= '
	
	';
	$__vars['actions'] = $__templater->preEscaped('
		' . $__templater->button(($__vars['message']['extra_data']['lift'] ? 'Lift ban' : 'Ban'), array(
		'type' => 'submit',
		'form' => $__vars['formId'],
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
),
'ban_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bans' => '!',
		'page' => '!',
		'perPage' => '!',
		'total' => '!',
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/page-nav-submit.js',
		'min' => '1',
	));
	$__finalCompiled .= '
	
	';
	$__vars['author'] = $__templater->preEscaped('
		' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
	))) . '
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['bans'], 'empty', array())) {
		$__compilerTemp1 .= '
					';
		if ($__templater->isTraversable($__vars['bans'])) {
			foreach ($__vars['bans'] AS $__vars['ban']) {
				$__compilerTemp1 .= '
						<div class="space-line space-line--md">
							' . $__templater->func('avatar', array($__vars['ban']['User'], 'xxs', false, array(
				))) . '
							' . $__templater->func('username_link', array($__vars['ban']['User'], false, array(
				))) . '<br>
							<span class="text-details">' . 'Unban date' . ':</span> ' . $__templater->escape($__vars['ban']['formatted_unban_date']) . '
							<br>
							';
				if ($__templater->method($__vars['ban'], 'hasReason', array())) {
					$__compilerTemp1 .= '
								<span class="text-details">' . 'Reason for the ban' . ':</span> ' . $__templater->escape($__vars['ban']['reason']) . '
							';
				}
				$__compilerTemp1 .= '
						</div>
					';
			}
		}
		$__compilerTemp1 .= '
					';
	} else {
		$__compilerTemp1 .= '
					' . 'No one is banned in this room.' . '
				';
	}
	$__vars['form'] = $__templater->preEscaped('
		<div class="chat-message-form">
			<div class="form-header">
				' . 'Banned users' . '
			</div>
			<div class="form-body">
				' . $__compilerTemp1 . '
			</div>
		</div>
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
					' . $__templater->func('page_nav', array(array(
		'link' => 'chat/messages/switch-ban-list-page',
		'data' => $__vars['message'],
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'perPage' => $__vars['perPage'],
	))) . '
				';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
			<div class="page-nav-submit" data-xf-init="page-nav-submit">
				' . $__compilerTemp3 . '						
			</div>
		';
	}
	$__vars['actions'] = $__templater->preEscaped(trim('
		' . $__compilerTemp2 . '
	'));
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
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);