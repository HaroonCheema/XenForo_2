<?php
// FROM HASH: 8ea046e2e8eeaa2fc0d0fd30a45d4e0e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['communication'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add communication');
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit communication' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['communication']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['communication'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('thmonetize-communications/delete', $__vars['communication'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="general-options">
					' . 'General options' . '
				</a>
				' . $__templater->callMacro('thmonetize_helper_criteria', 'user_upgrade_tabs', array(), $__vars) . '
				' . $__templater->callMacro('helper_criteria', 'user_tabs', array(), $__vars) . '
			</span>
		</h2>

		<ul class="tabPanes block-body">
			<li class="is-active" role="tabpanel" id="general-options">

				' . $__templater->callMacro('thmonetize_communication_edit_macros', 'time', array(
		'sendRules' => $__vars['communication']['send_rules'],
	), $__vars) . '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					<div class="inputGroup inputGroup--numbers">
						' . $__templater->formNumberBox(array(
		'name' => 'limit',
		'value' => $__vars['communication']['limit'],
		'placeholder' => 'Alerts',
		'min' => '0',
	)) . '
						<span class="inputGroup-text">' . 'per' . '</span>
						' . $__templater->formNumberBox(array(
		'name' => 'limit_days',
		'value' => $__vars['communication']['limit_days'],
		'placeholder' => 'Days',
		'min' => '0',
		'max' => ($__vars['xf']['options']['thmonetize_alertLogLength'] ?: ''),
	)) . '
						<span class="inputGroup-text">' . 'Days' . '</span>
					</div>
				', array(
		'rowtype' => 'input',
		'label' => 'Per user limit',
		'explain' => 'This controls the maximum number of this alert that can be sent to a user during a specified period. The length of the period should not exceed the log retention period or the global/total alerts per user limit. Set to 0 to allow unlimited alerts.',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['communication']['title'],
		'maxlength' => $__templater->func('max_length', array($__vars['communication'], 'title', ), false),
		'required' => 'true',
	), array(
		'label' => 'Title',
		'explain' => 'The alert title is not visible to the user.',
	)) . '

				' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'value' => ($__vars['communication']['User'] ? $__vars['communication']['User']['username'] : ($__templater->method($__vars['communication'], 'isInsert', array()) ? $__vars['xf']['visitor']['username'] : '')),
		'ac' => 'single',
	), array(
		'label' => 'From user',
		'explain' => '<strong>Alerts:</strong> If you would like this alert to appear from a specific user, enter their name above. If no name is specified, the alert will be sent anonymously.
<br />
<strong>Messages:</strong> A user is required for Message communications.',
	)) . '

				' . $__templater->formCodeEditorRow(array(
		'name' => 'body',
		'value' => $__vars['communication']['body'],
		'mode' => 'html',
		'data-line-wrapping' => 'true',
		'class' => 'codeEditor--autoSize codeEditor--proportional',
	), array(
		'label' => 'Communication body',
		'hint' => 'You may use HTML',
		'explain' => 'You may use {phrase:phrase_title} which will be replaced with the phrase text in the recipient\'s language.',
	)) . '


				<hr class="formRowSep" />

				' . $__templater->formRadioRow(array(
		'name' => 'type',
	), array(array(
		'value' => 'alert',
		'label' => 'Alert',
		'selected' => ($__vars['communication']['type'] == 'alert'),
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'type_options[alert][link_url]',
		'type' => 'url',
		'value' => (($__vars['communication']['type'] == 'alert') ? $__vars['communication']['type_options']['link_url'] : ''),
		'dir' => 'ltr',
	)), $__templater->formTextBox(array(
		'name' => 'type_options[alert][link_title]',
		'value' => (($__vars['communication']['type'] == 'alert') ? $__vars['communication']['type_options']['link_title'] : ''),
	))),
		'_type' => 'option',
	),
	array(
		'value' => 'email',
		'label' => 'Email',
		'selected' => ($__vars['communication']['type'] == 'email'),
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => 'type_options[email][wrapped]',
		'selected' => (($__vars['communication']['type'] == 'email') ? $__vars['communication']['type_options']['wrapped'] : 0),
		'label' => 'Include default email wrapper',
		'hint' => 'If selected, your email content will be wrapped in the standard header and footer used in emails sent elsewhere in XenForo.',
		'_type' => 'option',
	),
	array(
		'name' => 'type_options[email][unsub]',
		'selected' => (($__vars['communication']['type'] == 'email') ? $__vars['communication']['type_options']['unsub'] : 0),
		'label' => 'Automatically include an unsubscribe link',
		'hint' => 'If selected, this email will automatically have an unsubscribe line added at the bottom. If you use the \'unsub\' token in the body, this option will be ignored.',
		'_type' => 'option',
	),
	array(
		'name' => 'type_options[email][receive_admin_email_only]',
		'selected' => (($__vars['communication']['type'] == 'email') ? $__vars['communication']['type_options']['receive_admin_email_only'] : 0),
		'label' => '
								' . 'Only send to users opting to receive news and update emails' . '
							',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	),
	array(
		'value' => 'message',
		'label' => 'Message',
		'selected' => ($__vars['communication']['type'] == 'message'),
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => 'type_options[message][open_invite]',
		'selected' => (($__vars['communication']['type'] == 'message') ? $__vars['communication']['type_options']['open_invite'] : 0),
		'label' => '
								' . 'Allow anyone in the conversation to invite others',
		'_type' => 'option',
	),
	array(
		'name' => 'type_options[message][conversation_locked]',
		'selected' => (($__vars['communication']['type'] == 'message') ? $__vars['communication']['type_options']['conversation_locked'] : 0),
		'label' => '
								' . 'Lock conversation (no responses will be allowed)',
		'_type' => 'option',
	))), $__templater->formRadio(array(
		'name' => 'type_options[message][delete_type]',
		'value' => (($__vars['communication']['type'] == 'message') ? $__vars['communication']['type_options']['delete_type'] : 0),
	), array(array(
		'value' => '',
		'label' => 'Do not leave conversation',
		'explain' => 'The conversation will remain in your inbox and you will be notified of responses.',
		'_type' => 'option',
	),
	array(
		'value' => 'deleted',
		'label' => 'Leave conversation and accept future messages',
		'explain' => 'Should this conversation receive further responses in the future, this conversation will be restored to your inbox.',
		'_type' => 'option',
	),
	array(
		'value' => 'deleted_ignored',
		'label' => 'Leave conversation and ignore future messages',
		'explain' => 'You will not be notified of any future responses and the conversation will remain deleted.',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'selected' => $__vars['communication']['active'],
		'label' => 'Active',
		'_type' => 'option',
	)), array(
		'label' => 'Options',
	)) . '
			</li>

			' . $__templater->callMacro('thmonetize_helper_criteria', 'user_upgrade_panes', array(
		'criteria' => $__templater->method($__vars['userUpgradeCriteria'], 'getCriteriaForTemplate', array()),
		'data' => $__templater->method($__vars['userUpgradeCriteria'], 'getExtraTemplateData', array()),
	), $__vars) . '

			' . $__templater->callMacro('helper_criteria', 'user_panes', array(
		'criteria' => $__templater->method($__vars['userCriteria'], 'getCriteriaForTemplate', array()),
		'data' => $__templater->method($__vars['userCriteria'], 'getExtraTemplateData', array()),
	), $__vars) . '

		</ul>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('thmonetize-communications/save', $__vars['communication'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);