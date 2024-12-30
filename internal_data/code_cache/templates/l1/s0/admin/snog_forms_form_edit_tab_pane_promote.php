<?php
// FROM HASH: 4fcb53d6039bd41f433eecb6e5eeccb9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Promotions are only applied to registered users. You can not promote an unregistered/not logged in user.',
	)) . '

' . '

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'Instant promote' . '</span>
	</span>
</h3>

<div class="block-body block-body--collapsible">
	
	' . $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Instantly promotes a user when they submit this form',
	)) . '

	<hr class="block-separator" />
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'apppromote',
		'value' => '1',
		'selected' => $__vars['form']['apppromote'],
		'_type' => 'option',
	)), array(
		'label' => 'Change primary user group',
		'explain' => 'If you wish to promote the member to a different primary usergroup after they submit this form, check this box.',
	)) . '
	
	' . '
	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'Do not change',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'promoteto',
		'value' => $__vars['form']['promoteto'],
	), $__compilerTemp1, array(
		'label' => 'Primary user group',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'appadd',
		'value' => '1',
		'selected' => $__vars['form']['appadd'],
		'_type' => 'option',
	)), array(
		'label' => 'Add secondary user groups',
		'explain' => 'If you wish to add secondary user groups to the member\'s account after they submit this form, check this box.',
	)) . '
	
	' . '
	';
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['key'] => $__vars['userGroup']) {
			$__compilerTemp2[] = array(
				'name' => 'addto[' . $__vars['userGroup']['user_group_id'] . ']',
				'value' => $__vars['userGroup']['user_group_id'],
				'checked' => ($__vars['form']['addto'][$__vars['userGroup']['user_group_id']] ? 'checked' : ''),
				'label' => '
				' . $__templater->escape($__vars['userGroup']['title']) . '
			',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp2, array(
		'label' => 'Add to selected groups',
	)) . '
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'Decision or poll promote' . '</span>
	</span>
</h3>

<div class="block-body block-body--collapsible">
	
	' . $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Places decision links in thread and/or creates a voting poll',
	)) . '

	<hr class="block-separator" />
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'instant',
		'value' => '1',
		'selected' => $__vars['form']['instant'],
		'_type' => 'option',
	)), array(
		'label' => 'Include decision links',
		'explain' => 'Places both an approve and deny link in the thread where the form is posted.<br /><font style="color:blue;"><b>NOTE:</b></font> You MUST select \'Report in New Thread\' or \'Report in existing thread\' in Report Type/Thread report options if you use this option.',
	)) . '

	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'postpoll',
		'value' => '1',
		'selected' => $__vars['form']['postpoll'],
		'data-xf-init' => 'disabler',
		'data-container' => '#polls',
		'data-hide' => 'true',
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Create promotion voting poll',
		'explain' => 'If you want members to vote on this form, check this box.<br />This will create a Yes/No poll in the thread.<br />The user will be automatically promoted (or not) based on the outcome of the poll.<br /><font style="color:blue;"><b>NOTE:</b></font> You MUST select \'Report in New Thread\' in Report Type/Thread report options if you use this option.',
	)) . '
	
	<div id="polls">
		
		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'pollpublic',
		'value' => '1',
		'selected' => $__vars['form']['pollpublic'],
		'_type' => 'option',
	)), array(
		'label' => 'Display votes publicly',
	)) . '
	
		' . '
		' . $__templater->formHiddenVal('pollchange', '0', array(
	)) . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'pollchange',
		'value' => '1',
		'selected' => $__vars['form']['pollchange'],
		'_type' => 'option',
	)), array(
		'label' => 'Allow voters to change their votes',
	)) . '
		
		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'pollview',
		'value' => '1',
		'selected' => $__vars['form']['pollview'],
		'_type' => 'option',
	)), array(
		'label' => 'Allow the results to be viewed without voting',
	)) . '

		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'pollquestion',
		'value' => $__vars['form']['pollquestion'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'pollquestion', ), false),
	), array(
		'label' => 'Question',
		'explain' => 'Enter the question that should be asked with this poll.',
	)) . '

		' . '
		' . $__templater->formRow('
			<div class="inputGroup">
				<div class="inputGroup inputGroup--numbers inputNumber" data-xf-init="number-box">
					' . $__templater->formTextBox(array(
		'name' => 'pollclose',
		'value' => (($__vars['form']['pollclose'] >= 1) ? $__vars['form']['pollclose'] : 1),
		'type' => 'number',
		'min' => '1',
		'class' => 'input input--number js-numberBoxTextInput js-permissionIntInput',
	)) . '
				</div>
			</div>
		', array(
		'label' => 'Close poll',
		'explain' => 'Enter the number of days the poll poll should run.',
		'rowtype' => 'input',
	)) . '

		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'pmerror',
		'value' => $__vars['form']['pmerror'],
		'type' => 'search',
		'ac' => 'single',
		'class' => 'input--autoSize',
		'size' => '50',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'pmerror', ), false),
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	), array(
		'label' => 'Send ties to',
		'explain' => 'Enter the user name of the person that should receive notification in the event of a tie.',
	)) . '
	</div>
	
	' . '
	' . $__templater->formRadioRow(array(
		'name' => 'promote_type',
		'value' => ($__vars['form']['promote_type'] ? $__vars['form']['promote_type'] : 2),
	), array(array(
		'value' => '1',
		'data-xf-init' => 'disabler',
		'data-container' => '#prim',
		'data-hide' => 'true',
		'label' => 'Change primary user group',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'data-xf-init' => 'disabler',
		'data-container' => '#secs',
		'data-hide' => 'true',
		'label' => 'Add secondary user groups',
		'_type' => 'option',
	)), array(
		'label' => 'User group option',
	)) . '
	
	<div id="prim">
		' . '
		';
	$__compilerTemp3 = array(array(
		'value' => '0',
		'label' => 'Do not change',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'decidepromote',
		'value' => $__vars['form']['decidepromote'],
	), $__compilerTemp3, array(
		'label' => 'Change to',
	)) . '
	</div>
	
	<div id="secs">
		';
	$__compilerTemp4 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['key'] => $__vars['userGroup']) {
			$__compilerTemp4[] = array(
				'name' => 'pollpromote[' . $__vars['userGroup']['user_group_id'] . ']',
				'value' => $__vars['userGroup']['user_group_id'],
				'checked' => ($__vars['form']['pollpromote'][$__vars['userGroup']['user_group_id']] ? 'checked' : ''),
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), $__compilerTemp4, array(
		'label' => 'Add to selected groups',
	)) . '
	</div>
	
	' . '
	' . $__templater->formRadioRow(array(
		'name' => 'make_moderator',
		'value' => ($__vars['form']['make_moderator'] ? $__vars['form']['make_moderator'] : 1),
	), array(array(
		'value' => '1',
		'label' => 'No',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'data-xf-init' => 'disabler',
		'data-container' => '#forummod',
		'data-hide' => 'true',
		'label' => 'Forum moderator',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'data-xf-init' => 'disabler',
		'data-container' => '#supermod',
		'data-hide' => 'true',
		'label' => 'Super moderator',
		'_type' => 'option',
	)), array(
		'label' => 'Make moderator',
		'explain' => 'To make the user a moderator if the poll result is Yes, select the type of moderator you want them to be.<br /><font style="color:blue;"><b>NOTE:</b></font> If Forum Moderator is selected, the form MUST contain a question with the answer type \'Single Selection (Dropdown Forum List)\' and the user will be made a moderator in the selected forum.',
	)) . '

	<div id="forummod">
		
		' . '
		' . $__templater->formHiddenVal('forummod[displaystaff]', '0', array(
	)) . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'forummod[displaystaff]',
		'value' => '1',
		'selected' => $__vars['form']['forummod']['displaystaff'],
		'_type' => 'option',
	)), array(
		'label' => 'Display user as staff',
	)) . '
		
		' . '
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__templater->isTraversable($__vars['globalPermissions'][$__vars['interfaceGroupId']])) {
				foreach ($__vars['globalPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
					$__finalCompiled .= '
				' . $__templater->formHiddenVal('forummod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']', 'unset', array(
					)) . '
			';
				}
			}
			$__finalCompiled .= '
			';
			if ($__templater->isTraversable($__vars['contentPermissions'][$__vars['interfaceGroupId']])) {
				foreach ($__vars['contentPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
					$__finalCompiled .= '
				' . $__templater->formHiddenVal('forummod[contentPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']', 'unset', array(
					)) . '
			';
				}
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
		
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__vars['globalPermissions'][$__vars['interfaceGroupId']] AND ($__vars['interfaceGroup']['interface_group_id'] == 'generalModeratorPermissions')) {
				$__finalCompiled .= '
				';
				$__compilerTemp5 = array();
				if ($__templater->isTraversable($__vars['globalPermissions'][$__vars['interfaceGroupId']])) {
					foreach ($__vars['globalPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
						$__compilerTemp5[] = array(
							'label' => $__templater->escape($__vars['permission']['title']),
							'name' => 'forummod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']',
							'value' => 'allow',
							'selected' => ($__vars['form']['forummod']['globalPermissions'][$__vars['permission']['permission_group_id']][$__vars['permission']['permission_id']] == 'allow'),
							'_type' => 'option',
						);
					}
				}
				$__finalCompiled .= $__templater->formCheckBoxRow(array(
					'listclass' => 'listColumns',
				), $__compilerTemp5, array(
					'label' => $__templater->escape($__vars['interfaceGroup']['title']),
					'hint' => '<label><input type="checkbox" data-xf-init="check-all" data-container="< .formRow" /> ' . 'Select all' . '</label>',
				)) . '
			';
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
		
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__vars['contentPermissions'][$__vars['interfaceGroupId']]) {
				$__finalCompiled .= '
				';
				$__compilerTemp6 = array();
				if ($__templater->isTraversable($__vars['contentPermissions'][$__vars['interfaceGroupId']])) {
					foreach ($__vars['contentPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
						$__compilerTemp6[] = array(
							'label' => $__templater->escape($__vars['permission']['title']),
							'name' => 'forummod[contentPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']',
							'value' => 'content_allow',
							'selected' => ($__vars['form']['forummod']['contentPermissions'][$__vars['permission']['permission_group_id']][$__vars['permission']['permission_id']] == 'content_allow'),
							'_type' => 'option',
						);
					}
				}
				$__finalCompiled .= $__templater->formCheckBoxRow(array(
					'listclass' => 'listColumns',
				), $__compilerTemp6, array(
					'label' => $__templater->escape($__vars['interfaceGroup']['title']),
					'hint' => '<label><input type="checkbox" data-xf-init="check-all" data-container="< .formRow" /> ' . 'Select all' . '</label>',
				)) . '
			';
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
	</div>

	<div id="supermod">
		
		' . '
		' . $__templater->formHiddenVal('supermod[displaystaff]', '0', array(
	)) . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'supermod[displaystaff]',
		'value' => '1',
		'selected' => $__vars['form']['supermod']['displaystaff'],
		'_type' => 'option',
	)), array(
		'label' => 'Display user as staff',
	)) . '
		
		' . '
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__templater->isTraversable($__vars['globalPermissions'][$__vars['interfaceGroupId']])) {
				foreach ($__vars['globalPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
					$__finalCompiled .= '
				' . $__templater->formHiddenVal('supermod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']', 'unset', array(
					)) . '
			';
				}
			}
			$__finalCompiled .= '
			';
			if ($__templater->isTraversable($__vars['contentPermissions'][$__vars['interfaceGroupId']])) {
				foreach ($__vars['contentPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
					$__finalCompiled .= '
				' . $__templater->formHiddenVal('supermod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']', 'unset', array(
					)) . '
			';
				}
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
		
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__vars['globalPermissions'][$__vars['interfaceGroupId']]) {
				$__finalCompiled .= '
				';
				$__compilerTemp7 = array();
				if ($__templater->isTraversable($__vars['globalPermissions'][$__vars['interfaceGroupId']])) {
					foreach ($__vars['globalPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
						$__compilerTemp7[] = array(
							'label' => $__templater->escape($__vars['permission']['title']),
							'name' => 'supermod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']',
							'value' => 'allow',
							'selected' => ($__vars['form']['supermod']['globalPermissions'][$__vars['permission']['permission_group_id']][$__vars['permission']['permission_id']] == 'allow'),
							'_type' => 'option',
						);
					}
				}
				$__finalCompiled .= $__templater->formCheckBoxRow(array(
					'listclass' => 'listColumns',
				), $__compilerTemp7, array(
					'label' => $__templater->escape($__vars['interfaceGroup']['title']),
					'hint' => '<label><input type="checkbox" data-xf-init="check-all" data-container="< .formRow" /> ' . 'Select all' . '</label>',
				)) . '
			';
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
		
		';
	if ($__templater->isTraversable($__vars['interfaceGroups'])) {
		foreach ($__vars['interfaceGroups'] AS $__vars['interfaceGroupId'] => $__vars['interfaceGroup']) {
			$__finalCompiled .= '
			';
			if ($__vars['contentPermissions'][$__vars['interfaceGroupId']]) {
				$__finalCompiled .= '
				';
				$__compilerTemp8 = array();
				if ($__templater->isTraversable($__vars['contentPermissions'][$__vars['interfaceGroupId']])) {
					foreach ($__vars['contentPermissions'][$__vars['interfaceGroupId']] AS $__vars['permission']) {
						$__compilerTemp8[] = array(
							'label' => $__templater->escape($__vars['permission']['title']),
							'name' => 'supermod[globalPermissions][' . $__vars['permission']['permission_group_id'] . '][' . $__vars['permission']['permission_id'] . ']',
							'value' => 'allow',
							'selected' => ($__vars['form']['supermod']['globalPermissions'][$__vars['permission']['permission_group_id']][$__vars['permission']['permission_id']] == 'allow'),
							'_type' => 'option',
						);
					}
				}
				$__finalCompiled .= $__templater->formCheckBoxRow(array(
					'listclass' => 'listColumns',
				), $__compilerTemp8, array(
					'label' => $__templater->escape($__vars['interfaceGroup']['title']),
					'hint' => '<label><input type="checkbox" data-xf-init="check-all" data-container="< .formRow" /> ' . 'Select all' . '</label>',
				)) . '
			';
			}
			$__finalCompiled .= '
		';
		}
	}
	$__finalCompiled .= '
	</div>
	
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'removeinstant',
		'value' => '1',
		'selected' => $__vars['form']['removeinstant'],
		'_type' => 'option',
	)), array(
		'label' => 'Reverse instant promote',
		'explain' => 'If you wish to reverse all actions taken by Instant Promote, check this box.<br /><font style="color:blue;"><b>NOTE:</b></font> This reverses the action of Instant Promote no matter what the outcome of the promotion is.',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'approved_title',
		'value' => $__vars['form']['approved_title'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'approved_title', ), false),
	), array(
		'label' => 'Approved PC title',
		'explain' => 'Enter the title for the approved form PC. Leave blank if you do not want to send an approved PC.',
	)) . '
	
	' . '
	' . $__templater->formEditorRow(array(
		'name' => 'approved_text',
		'value' => $__vars['form']['approved_text'],
	), array(
		'label' => 'Approved PC text',
		'explain' => 'Enter the text for the approved application PC.<br />Replacement Variable: {1} = Form Name',
	)) . '
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'approved_file',
		'value' => $__vars['form']['approved_file'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'approved_file', ), false),
	), array(
		'label' => 'Include PHP File When Approved',
		'explain' => 'This is for an external file to process anything that may be needed.<br />LEAVE BLANK IF NOT USED.<br />Enter the relative path to a PHP file to be included when this form is approved. (example: includes/includefile.php)<br />This file will be run before returning to the thread when decision links are used, or during the poll cron task. It should NOT return any values to the forms system, return to any page in Xenforo or display any information.<br />This is a simple PHP include. No variables are passed to the file. <b>No support will be provided for included files.</b>',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'denied_title',
		'value' => $__vars['form']['denied_title'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'denied_title', ), false),
	), array(
		'label' => 'Denied PC title',
		'explain' => 'Enter the title for the denied form PC. Leave blank if you do not want to send an denied PC.',
	)) . '
	
	' . '
	' . $__templater->formEditorRow(array(
		'name' => 'denied_text',
		'value' => $__vars['form']['denied_text'],
	), array(
		'label' => 'Denied PC text',
		'explain' => 'Enter the text for the denied application PC.<br />Replacement Variable: {1} = Form Name',
	)) . '

</div>

';
	return $__finalCompiled;
}
);