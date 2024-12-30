<?php
// FROM HASH: d7fbea20bbdda21d3e86f327f033b49a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Main Form Settings',
	)) . '

' . '

<div class="block-body">

	';
	if ($__vars['form']['posid']) {
		$__finalCompiled .= '
		';
		$__vars['formUrl'] = $__templater->func('link_type', array('public', 'canonical:form/select', $__vars['form'], ), false);
		$__finalCompiled .= $__templater->formRow('
			<div class="inputGroup">
				' . '' . '
				<div class="inputGroup-text">
					<a href="' . $__templater->escape($__vars['formUrl']) . '" target="_blank">
						' . $__templater->escape($__vars['formUrl']) . '
					</a>
				</div>
				<span class="inputGroup-splitter"></span>
				' . $__templater->button('', array(
			'icon' => 'copy',
			'data-xf-init' => 'copy-to-clipboard',
			'data-copy-text' => $__vars['formUrl'],
			'class' => 'button--link',
		), '', array(
		)) . '
			</div>
		', array(
			'label' => 'Direct access URL',
			'rowtype' => 'input',
		)) . '
	';
	}
	$__finalCompiled .= '
	
	' . $__templater->formRow('
		' . $__templater->filter($__vars['form']['submit_count'], array(array('number', array()),), true) . '
	', array(
		'label' => 'Submit count',
	)) . '

	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'position',
		'value' => $__vars['form']['position'],
		'maxlength' => '200',
	), array(
		'label' => 'Form name',
		'explain' => 'Enter the name of this form.',
	)) . '

	' . '
	' . $__templater->formRow('
		<div class="inputGroup">
			<div class="inputGroup inputGroup--numbers inputNumber" data-xf-init="number-box">
				' . $__templater->formTextBox(array(
		'name' => 'display',
		'value' => (($__vars['form']['display'] >= 1) ? $__vars['form']['display'] : 1),
		'type' => 'number',
		'min' => '1',
		'class' => 'input input--number js-numberBoxTextInput js-permissionIntInput',
	)) . '
			</div>
		</div>
	', array(
		'label' => 'Display order',
		'rowtype' => 'input',
	)) . '

	' . '
	' . $__templater->formNumberBoxRow(array(
		'name' => 'minimum_attachments',
		'min' => '0',
		'step' => '1',
		'value' => $__vars['form']['minimum_attachments'],
	), array(
		'label' => 'Minimum attachments',
		'explain' => 'Minimum limit of attachments for a form, if you have used Attachment feild in form.',
	)) . '

	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'name' => 'active',
		'selected' => $__vars['form']['active'],
		'_type' => 'option',
	)), array(
		'label' => 'This form is active',
		'explain' => 'Check this box to show this form to members.<br />This box does not need to be checked if using this form as a quick reply in a thread.',
	)) . '

	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'name' => 'is_public_visible',
		'selected' => $__vars['form']['is_public_visible'],
		'_type' => 'option',
	)), array(
		'label' => 'Publicly visible',
		'explain' => 'If selected, this form will be visible for everyone regardless user criteria settings.',
	)) . '
	
	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['types'])) {
		foreach ($__vars['types'] AS $__vars['typeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['typeEntry']['appid'],
				'label' => $__templater->escape($__vars['typeEntry']['type']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'appid',
		'value' => $__vars['form']['appid'],
	), $__compilerTemp1, array(
		'label' => 'Form type',
		'explain' => 'If you select a form type, the form will be listed under that type and users must meet the criteria for <b>BOTH</b> the form type and this form to be able to fill out this form.',
	)) . '
	
	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'pmsender',
		'value' => $__vars['form']['pmsender'],
		'type' => 'search',
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'pmsender', ), false),
		'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
	), array(
		'label' => 'PC sender name',
		'explain' => 'Enter the name of the member that will send private conversations. This is used for any PCs sent by the forms system about this form.<br /><font style="color:blue;"><b>NOTE:</b></font> This must be set to a valid user name. The user name must be set to something other than a user name that may need to receive PCs from the forms system. (<b>you can\'t send PCs to yourself</b>)<br />It is strongly suggested that you set up a special user to send PCs from the forms system. (IE: a username of \'Forms System\')',
	)) . '

	' . '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'pmdelete',
		'value' => '1',
		'selected' => $__vars['form']['pmdelete'],
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Delete PCs',
		'explain' => 'Check this box to automatically delete sent PCs from the Private Conversation sender\'s conversation list. This will prevent the database from increasing in size if the PC sender never logs in to read and delete their PCs. This will also close the PC to replies.',
	)) . '
	
	' . '
	' . $__templater->formTextAreaRow(array(
		'name' => 'thanks',
		'value' => $__vars['form']['thanks'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'thanks', ), false),
	), array(
		'label' => 'Success message',
		'explain' => 'Enter what you would like displayed when a user successfully submits this form.',
	)) . '
	
	' . '
	';
	$__compilerTemp2 = array();
	$__compilerTemp3 = $__templater->method($__vars['styleTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp3)) {
		foreach ($__compilerTemp3 AS $__vars['treeEntry']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['treeEntry']['record']['style_id'],
				'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'style_override',
		'selected' => $__vars['form']['app_style'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'app_style',
		'value' => $__vars['form']['app_style'],
	), $__compilerTemp2)),
		'_type' => 'option',
	)), array(
		'label' => 'Override user style choice',
		'explain' => 'If specified, all users will view this form using the selected style, regardless of their personal style preference.',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'store',
		'value' => '1',
		'selected' => $__vars['form']['store'],
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Save answers to database',
		'explain' => 'By checking this box all answers to questions for this form (except file upload and header answer types) will be saved to the xf_snog_forms_answers table in the database.<br /><span style="color:red;">Under normal use this should not be checked.</span><br /><span style="color:blue;"><b>NOTE:</b></span> No processing is, or will be done with the data that is saved. The option is provided for those that would like to process the information on their own. People using this option should already know how to use, and extract information from, multiple database tables.<br />No support will be given for processing the xf_snog_forms_answers table.',
	)) . '

	' . '
	' . $__templater->formNumberBoxRow(array(
		'name' => 'cooldown',
		'value' => $__vars['form']['cooldown'],
		'units' => 'Seconds',
		'min' => '-1',
	), array(
		'label' => 'Form cooldown',
		'explain' => 'Minimum time between user can submit this form again.<br/>
Set 0 to no limit.<br/>
Set -1 to limit with one submit to user (or IP if guest).',
	)) . '
	
</div>

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'Date range' . '</span>
	</span>
</h3>

<div class="block-body block-body--collapsible">
	
	' . '
	';
	$__compilerTemp4 = array();
	if ($__templater->isTraversable($__vars['data']['hours'])) {
		foreach ($__vars['data']['hours'] AS $__vars['hour']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['hour'],
				'label' => $__templater->escape($__vars['hour']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp5 = array();
	if ($__templater->isTraversable($__vars['data']['minutes'])) {
		foreach ($__vars['data']['minutes'] AS $__vars['minute']) {
			$__compilerTemp5[] = array(
				'value' => $__vars['minute'],
				'label' => $__templater->escape($__vars['minute']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('
		<div class="inputGroup">
			' . $__templater->formDateInput(array(
		'name' => 'start',
		'value' => ($__vars['form']['start'] ? $__templater->func('date', array($__vars['form']['start'], 'picker', ), false) : ''),
	)) . '
			<span class="inputGroup-text">' . 'Time' . $__vars['xf']['language']['label_separator'] . '</span>
			<span class="inputGroup" dir="ltr">
				' . $__templater->formSelect(array(
		'name' => 'starthour',
		'value' => $__vars['data']['starthour'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp4) . '
				<span class="inputGroup-text">:</span>
				' . $__templater->formSelect(array(
		'name' => 'startminute',
		'value' => $__vars['data']['startminute'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp5) . '
			</span>
		</div>
		<dfn class="inputChoices-explain inputChoices-explain--after">' . 'If you want this form to become available on a certain date, select it here.<br />Uses site guest timezone.<br />Leave date blank if not used.<br />This has no effect if using this form as a quick reply in a thread.' . '</dfn>
	', array(
		'label' => 'Start date',
	)) . '

	' . '
	';
	$__compilerTemp6 = array();
	if ($__templater->isTraversable($__vars['data']['hours'])) {
		foreach ($__vars['data']['hours'] AS $__vars['hour']) {
			$__compilerTemp6[] = array(
				'value' => $__vars['hour'],
				'label' => $__templater->escape($__vars['hour']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp7 = array();
	if ($__templater->isTraversable($__vars['data']['minutes'])) {
		foreach ($__vars['data']['minutes'] AS $__vars['minute']) {
			$__compilerTemp7[] = array(
				'value' => $__vars['minute'],
				'label' => $__templater->escape($__vars['minute']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('
		<div class="inputGroup">
			' . $__templater->formDateInput(array(
		'name' => 'end',
		'value' => ($__vars['form']['end'] ? $__templater->func('date', array($__vars['form']['end'], 'picker', ), false) : ''),
	)) . '
			<span class="inputGroup-text">' . 'Time' . $__vars['xf']['language']['label_separator'] . '</span>
			<span class="inputGroup" dir="ltr">
				' . $__templater->formSelect(array(
		'name' => 'endhour',
		'value' => $__vars['data']['endhour'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp6) . '
				<span class="inputGroup-text">:</span>
				' . $__templater->formSelect(array(
		'name' => 'endminute',
		'value' => $__vars['data']['endminute'],
		'class' => 'input--inline input--autoSize',
	), $__compilerTemp7) . '
			</span>
		</div>
		<dfn class="inputChoices-explain inputChoices-explain--after">' . 'If you want this form to stop being available on a certain date, select it here.<br />Uses site guest timezone.<br />Leave date blank if not used.<br />This has no effect if using this form as a quick reply in a thread.' . '</dfn>
	', array(
		'label' => 'End date',
	)) . '

	' . '
	' . $__templater->formTextBoxRow(array(
		'name' => 'aftererror',
		'value' => $__vars['form']['aftererror'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'aftererror', ), false),
	), array(
		'label' => 'End date error',
		'explain' => 'You may enter the error displayed if this form is used after the end date. Leave blank to use the standard no permission error.',
	)) . '						

</div>

';
	return $__finalCompiled;
}
);