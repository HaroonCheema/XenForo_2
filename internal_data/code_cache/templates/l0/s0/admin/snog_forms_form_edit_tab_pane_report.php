<?php
// FROM HASH: b284907076bdcaa2a258201496e2eb0d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Select and define how you would like this form to be reported on your site.',
	)) . '

' . '

<div class="block-body">

	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'subject',
		'value' => $__vars['form']['subject'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'subject', ), false),
	), array(
		'label' => 'Report title',
		'explain' => 'Enter the title that will be used on reports when members fill out this application.<br />Replacement variables:<br />{1} = Name of Member Submitting Form<br />{A#} = Answer to question number (example: {A4})<br />This is limited to these answer types:<br />Date picker<br />Single line text<br />Single selection dropdown<br />Single selection forum list<br />Single selection radio<br />Yes/No<br /><font style="color:red;"><b>NOTE:</b></font> The question used for an {A#} must be required to be answered.<br /><font style="color:blue;"><b>NOTE:</b></font> Use caution when using these options. A thread title is limited to 150 characters. Use that as a guide when considering using replacement variables in the title.',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'parseyesno',
		'value' => '1',
		'selected' => $__vars['form']['parseyesno'],
		'_type' => 'option',
	)), array(
		'label' => 'Parse URLs',
		'explain' => 'If you want to parse URLs so they are live in posts and PCs, check this box.',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'incname',
		'value' => '1',
		'selected' => $__vars['form']['incname'],
		'data-xf-init' => 'disabler',
		'data-container' => '#ipheader',
		'data-hide' => 'true',
		'_type' => 'option',
	)), array(
		'label' => 'Include member name/IP address',
		'explain' => 'If you want to include the member name on the first line of reports, check this box. If the user is unregistered, their IP address will be included instead of their member name.',
	)) . '
	
	<div id="ipheader">
		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'bbstart',
		'value' => $__vars['form']['bbstart'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'bbstart', ), false),
	), array(
		'label' => 'Wrap IP in BBCode start',
		'explain' => 'Enter the BBCode start code to wrap an unregistered user\'s IP in. LEAVE BLANK if not used.<br />Example: [SIZE=7]',
	)) . '
		
		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'bbend',
		'value' => $__vars['form']['bbend'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'bbend', ), false),
	), array(
		'label' => 'Wrap IP in BBCode end',
		'explain' => 'Enter the BBCode end code to wrap an unregistered user\'s IP in. LEAVE BLANK if not used.<br />Example: [/SIZE]',
	)) . '
	</div>
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'Email report options' . '</span>
	</span>
</h3>
<div class="block-body block-body--collapsible">
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'email',
		'value' => $__vars['form']['email'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'email', ), false),
	), array(
		'label' => 'Email recipients',
		'explain' => 'Email address(es) to send reports to. Use a comma to separate the values.<br />(ie: youremail@website.com,youremail@yoursite.com)<br />If you do not want to send email when a form is submitted, leave this field blank.<br /><span style="color:blue;"><b>NOTE:</b></span> Attachments to forms are not sent in emailed reports.',
	)) . '
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'Thread report options' . '</span>
	</span>
</h3>
<div class="block-body block-body--collapsible">
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'posterid',
		'value' => $__vars['form']['posterid'],
		'type' => 'search',
		'ac' => 'single',
		'class' => 'input--autoSize',
		'size' => '50',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'posterid', ), false),
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	), array(
		'label' => 'Poster user name',
		'explain' => 'Enter the user name for the member that will be used to post the reports for this form.<br /><font style="color:blue"><b>NOTE:</b></font> If not set, the user name of user submitting the form will be used. If the user submitting the form is unregistered, the user name of the first super-admin will be used.',
	)) . '

	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'oldthread',
		'class' => 'input--autoSize',
		'size' => '10',
		'maxlength' => '30',
		'value' => $__vars['form']['oldthread'],
	), array(
		'label' => 'Report in existing thread',
		'explain' => 'If you would like the report posted in an existing thread, enter the thread ID number for that thread here. Set to zero if you do not want to use this option.',
	)) . '

	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'postapproval',
		'value' => '1',
		'selected' => $__vars['form']['postapproval'],
		'_type' => 'option',
	)), array(
		'label' => 'Require approval',
		'explain' => 'If you want the thread or post created when a member submits this form to be moderated and require approval, check this box.',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'quickreply',
		'value' => '1',
		'selected' => $__vars['form']['quickreply'],
		'_type' => 'option',
	)), array(
		'label' => 'Use form as thread quick reply',
		'explain' => 'If you entered an existing thread above, you can use this form as a substitute for the quick reply box in the thread.<br /><span style="color:blue;">NOTE: </span>Form user criteria is ignored when this option is selected and normal XenForo reply permissions are used.',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'qroption',
		'value' => '1',
		'selected' => $__vars['form']['qroption'],
		'data-xf-init' => 'disabler',
		'data-container' => '#qroption',
		'data-hide' => 'true',
		'_type' => 'option',
	)), array(
		'label' => 'Quick reply option button',
		'explain' => 'Check this box to put a button in the quick reply box to optionally use this form as a reply to a thread.<br />This differs from "Use form as thread quick reply" in that it does not replace the quick reply box in the thread. And it applies to all threads in a forum, not individual threads.',
	)) . '
	
	<div id="qroption">
		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'qrbutton',
		'value' => ($__vars['form']['qrbutton'] ? $__vars['form']['qrbutton'] : 'Use update form'),
		'class' => 'input--autoSize',
		'size' => '30',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'qrbutton', ), false),
	), array(
		'label' => 'Button phrase',
		'explain' => 'Enter the phrase that will be displayed in the button',
	)) . '

		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'qrstarter',
		'value' => '1',
		'selected' => $__vars['form']['qrstarter'],
		'_type' => 'option',
	)), array(
		'label' => 'Only thread starter',
		'explain' => 'Check this box to only allow the thread starter to use the form button',
	)) . '

		' . '
		';
	$__compilerTemp1 = array(array(
		'value' => '-1',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			if ($__vars['treeEntry']['record']['node_type_id'] == 'Forum') {
				$__compilerTemp1[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			} else {
				$__compilerTemp1[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'disabled' => 'disabled',
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			}
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'qrforums',
		'multiple' => 'true',
		'value' => $__vars['form']['qrforums'],
	), $__compilerTemp1, array(
		'label' => 'Forums for option button',
		'explain' => 'Select the forums where the quick reply option button will be shown in threads',
	)) . '
	</div>
	
	<hr class="formRowSep" />

	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'inthread',
		'value' => '1',
		'selected' => $__vars['form']['inthread'],
		'data-xf-init' => 'disabler',
		'data-container' => '#forumoption',
		'data-hide' => 'true',
		'_type' => 'option',
	)), array(
		'label' => 'Report in new thread',
		'explain' => 'Check this box if you would like to create a new thread when this form is submitted.',
	)) . '
	
	<div id="forumoption">
		
		' . '
		';
	$__compilerTemp3 = array(array(
		'value' => '-1',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp4 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp4)) {
		foreach ($__compilerTemp4 AS $__vars['treeEntry']) {
			if ($__vars['treeEntry']['record']['node_type_id'] == 'Forum') {
				$__compilerTemp3[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			} else {
				$__compilerTemp3[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'disabled' => 'disabled',
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			}
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'node_id',
		'value' => $__vars['form']['node_id'],
	), $__compilerTemp3, array(
		'label' => 'Forum for new thread',
		'explain' => 'The user entered in Poster User Name MUST have permission to post in the forum selected.',
	)) . '
	
		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'threadapp',
		'value' => '1',
		'selected' => $__vars['form']['threadapp'],
		'data-xf-init' => 'disabler',
		'data-container' => '#threadbutton',
		'data-hide' => 'true',
		'_type' => 'option',
	)), array(
		'label' => 'Post thread button to form',
		'explain' => 'Check this box to have the Post Thread button in the forum node selected above go directly to this form.<br /><font style="color:red"><b>WARNING:</b></font> This option should only be used once per forum node. Multiple forms in the same forum node with this option selected will result in unexpected results.',
	)) . '

		<div id="threadbutton">
			' . '
			' . $__templater->formTextBoxRow(array(
		'name' => 'threadbutton',
		'value' => $__vars['form']['threadbutton'],
		'class' => 'input--autoSize',
		'size' => '30',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'threadbutton', ), false),
	), array(
		'label' => 'Post thread button phrase',
		'explain' => 'If Post Thread Button to Form is checked above, enter a new phrase for the button here. Leave blank to use the default Post Thread phrase.',
	)) . '
		</div>

		';
	if (!$__templater->test($__vars['availablePrefixes'], 'empty', array())) {
		$__finalCompiled .= '
			' . '
			
			';
		if ($__templater->func('is_addon_active', array('SV/MultiPrefix', ), false)) {
			$__finalCompiled .= '
				';
			$__compilerTemp5 = array(array(
				'value' => '-1',
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			));
			$__compilerTemp5 = $__templater->mergeChoiceOptions($__compilerTemp5, $__vars['availablePrefixes']);
			$__finalCompiled .= $__templater->formSelectRow(array(
				'name' => 'prefix_ids',
				'value' => $__vars['form']['prefix_ids'],
				'multiple' => 'true',
				'rows' => '5',
			), $__compilerTemp5, array(
				'label' => 'Thread prefixes (No more than 1 per form)',
				'explain' => 'If you would like to use a thread prefix for the report, select the prefix here.<br /><font style="color:blue"><b>NOTE:</b></font> ALL PREFIXES ARE LISTED HERE. The prefix you select MUST BE A VALID PREFIX for the forum the thread will be created in. Also the user group the member filling out the form belongs to must be able to use the prefix in the forum the thread will be created in.',
			)) . '
			';
		} else {
			$__finalCompiled .= '
				';
			$__compilerTemp6 = array(array(
				'value' => '-1',
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			));
			$__compilerTemp6 = $__templater->mergeChoiceOptions($__compilerTemp6, $__vars['availablePrefixes']);
			$__finalCompiled .= $__templater->formSelectRow(array(
				'name' => 'prefix_id',
				'value' => $__templater->filter($__vars['form']['prefix_ids'], array(array('first', array()),), false),
			), $__compilerTemp6, array(
				'label' => 'Thread prefix',
				'explain' => 'If you would like to use a thread prefix for the report, select the prefix here.<br /><font style="color:blue"><b>NOTE:</b></font> ALL PREFIXES ARE LISTED HERE. The prefix you select MUST BE A VALID PREFIX for the forum the thread will be created in. Also the user group the member filling out the form belongs to must be able to use the prefix in the forum the thread will be created in.',
			)) . '
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '

		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'watchthread',
		'value' => '1',
		'selected' => $__vars['form']['watchthread'],
		'_type' => 'option',
	)), array(
		'label' => 'Watch new thread',
		'explain' => 'If this form is being posted in a new thread and you DO NOT have a user name set in Poster User Name above and want the user that fills out the form to receive notices of posts in the new thread, check this box.',
	)) . '
	
		<hr class="formRowSep" />
	
		' . '
		' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'insecthread',
		'value' => '1',
		'selected' => $__vars['form']['insecthread'],
		'_type' => 'option',
	)), array(
		'label' => 'Report in second new thread',
		'explain' => 'Check this box if you would like to create a second new thread in a different forum when this form is submitted.<br /><font style="color:blue;"><b>NOTE:</b></font> All settings above are used to post the second thread with the exception of Watch Thread, User Name and Forum settings. No promotion poll will be created in this thread.',
	)) . '
	
		' . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'secposterid',
		'value' => $__vars['form']['secposterid'],
		'type' => 'search',
		'ac' => 'single',
		'class' => 'input--autoSize',
		'size' => '50',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'secposterid', ), false),
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	), array(
		'label' => 'Second thread poster user name',
		'explain' => 'Enter the user name for the member that will be used to post the reports in the second thread for this form.<br /><font style="color:blue"><b>NOTE:</b></font> If not set, the user name of user submitting the form will be used. If the user submitting the form is unregistered, the user name of the first super-admin will be used.',
	)) . '

		' . '
		';
	$__compilerTemp7 = array(array(
		'value' => '-1',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp8 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp8)) {
		foreach ($__compilerTemp8 AS $__vars['treeEntry']) {
			if ($__vars['treeEntry']['record']['node_type_id'] == 'Forum') {
				$__compilerTemp7[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			} else {
				$__compilerTemp7[] = array(
					'value' => $__vars['treeEntry']['record']['node_id'],
					'disabled' => 'disabled',
					'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
					'_type' => 'option',
				);
			}
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'secnode_id',
		'value' => $__vars['form']['secnode_id'],
	), $__compilerTemp7, array(
		'label' => 'Forum for second thread',
		'explain' => 'The user entered in Second Thread Poster User Name MUST have permission to post in the forum selected.',
	)) . '
	</div>
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'PC report options' . '</span>
	</span>
</h3>
<div class="block-body block-body--collapsible">
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'bypm',
		'value' => '1',
		'selected' => $__vars['form']['bypm'],
		'_type' => 'option',
	)), array(
		'label' => 'Report by PC',
		'explain' => 'Check this box if you would like to send a new PC when this form is submitted.',
	)) . '
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'pmto',
		'value' => $__vars['form']['pmto'],
		'type' => 'search',
		'ac' => 'multiple',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'pmto', ), false),
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	), array(
		'label' => 'Private conversation recipients',
	)) . '
	
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'User PC options' . '</span>
	</span>
</h3>
<div class="block-body block-body--collapsible">
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'pmapp',
		'value' => '1',
		'selected' => $__vars['form']['pmapp'],
		'_type' => 'option',
	)), array(
		'label' => 'Send PC to user',
		'explain' => 'If you wish to send a PC to the user after they submit this form, check this box.',
	)) . '
	
	' . '
	' . $__templater->formEditorRow(array(
		'name' => 'pmtext',
		'value' => $__vars['form']['pmtext'],
	), array(
		'label' => 'PC text',
		'explain' => 'Enter the text for the PC here.<br />Replacement Variables:<br />{1} = Name of Member Submitting Form<br />{2} = Your Site Name<br />{3} = PC Sender Name',
	)) . '
</div>

';
	return $__finalCompiled;
}
);