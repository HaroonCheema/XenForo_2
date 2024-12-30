<?php
// FROM HASH: 123270aff1d8966ec8cfbba79f1a83c5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['action'] == 'edit') OR (!$__templater->method($__vars['question'], 'isInsert', array()))) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Question');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped(($__vars['form']['posid'] ? '' : 'Default Questions') . ' Add conditional question');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['form']['position']) . ' ' . 'Questions'), $__templater->func('link', array('form-editquestions/formquestions', $__vars['form'], ), false), array(
	));
	$__finalCompiled .= '
';
	$__templater->setPageParam('section', ($__vars['form']['posid'] ? 'snogForms' : 'snogQuestions'));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['conditionals']) {
		$__compilerTemp1 .= '
				';
		$__compilerTemp2 = array(array(
			'value' => '-1',
			'label' => 'None',
			'_type' => 'option',
		));
		if ($__templater->isTraversable($__vars['conditionals'])) {
			foreach ($__vars['conditionals'] AS $__vars['conditional']) {
				if ($__vars['conditional']['questionId'] == $__vars['question']['conditional']) {
					$__compilerTemp3 = array();
					if ($__templater->isTraversable($__vars['conditional']['answers'])) {
						foreach ($__vars['conditional']['answers'] AS $__vars['key'] => $__vars['answer']) {
							if ($__vars['conditional']['type'] == 3) {
								$__compilerTemp3[] = array(
									'value' => $__vars['key'],
									'label' => $__templater->escape($__vars['answer']),
									'_type' => 'option',
								);
							} else {
								$__compilerTemp3[] = array(
									'value' => ($__vars['key'] + 1),
									'label' => $__templater->escape($__vars['answer']),
									'_type' => 'option',
								);
							}
						}
					}
					$__compilerTemp2[] = array(
						'value' => $__vars['conditional']['questionId'],
						'label' => $__templater->escape($__vars['conditional']['text']),
						'_dependent' => array($__templater->formSelect(array(
						'name' => 'conanswer',
						'value' => ($__vars['question']['conanswer'] ? $__vars['question']['conanswer'] : ''),
					), $__compilerTemp3)),
						'_type' => 'option',
					);
				} else {
					if ($__vars['conditional']['questionId'] !== $__vars['question']['questionid']) {
						$__compilerTemp4 = array();
						if ($__templater->isTraversable($__vars['conditional']['answers'])) {
							foreach ($__vars['conditional']['answers'] AS $__vars['key'] => $__vars['answer']) {
								if ($__vars['conditional']['type'] == 3) {
									$__compilerTemp4[] = array(
										'value' => $__vars['key'],
										'label' => $__templater->escape($__vars['answer']),
										'_type' => 'option',
									);
								} else {
									$__compilerTemp4[] = array(
										'value' => ($__vars['key'] + 1),
										'label' => $__templater->escape($__vars['answer']),
										'_type' => 'option',
									);
								}
							}
						}
						$__compilerTemp2[] = array(
							'value' => $__vars['conditional']['questionId'],
							'label' => $__templater->escape($__vars['conditional']['text']),
							'_dependent' => array($__templater->formSelect(array(
							'name' => 'conanswer',
							'value' => '',
						), $__compilerTemp4)),
							'_type' => 'option',
						);
					}
				}
			}
		}
		$__compilerTemp1 .= $__templater->formRadioRow(array(
			'name' => 'conditional',
			'value' => ($__vars['question']['conditional'] ? $__vars['question']['conditional'] : -1),
		), $__compilerTemp2, array(
			'label' => 'Question/Answer condition',
			'explain' => 'Select the question and answer that must be given for this question to be displayed',
		)) . '
				
				<input type="hidden" name="originalConditional" value="' . $__templater->escape($__vars['question']['conditional']) . '"/>
				
				<hr class="formRowSep" />
			';
	}
	$__compilerTemp5 = '';
	if ($__vars['nextquestion']) {
		$__compilerTemp5 .= '
				<input type="hidden" value="' . $__templater->escape($__vars['nextquestion']) . '" name="display" />
			';
	} else {
		$__compilerTemp5 .= '
				<input type="hidden" value="' . $__templater->escape($__vars['question']['display']) . '" name="display" />
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('', array(
		'explain' => 'Conditional questions are questions that will only be displayed if another question is answered with a specific answer.',
	)) . '

			' . $__compilerTemp1 . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'text',
		'value' => $__vars['question']['text'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'text', ), false),
	), array(
		'label' => 'Question or Header phrase',
		'explain' => 'Enter the question to ask the member or the header phrase for this section of the application. You may use BBCode here.',
	)) . '
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'description',
		'value' => $__vars['question']['description'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'description', ), false),
	), array(
		'label' => 'Description',
		'explain' => 'The description for this question.<br />(Displayed below answer area - Not displayed if blank)',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'type',
		'value' => ($__vars['question']['type'] ? $__vars['question']['type'] : 1),
	), array(array(
		'value' => '9',
		'data-xf-init' => 'disabler',
		'data-container' => '#expagree',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Agreement (Displays question text with optional checkbox below text)',
		'_type' => 'option',
	),
	array(
		'value' => '11',
		'label' => 'Date picker',
		'_type' => 'option',
	),
	array(
		'value' => '10',
		'disabled' => ($__vars['filetype'] ? 'disabled' : ''),
		'data-xf-init' => 'disabler',
		'data-container' => '#inline',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'File upload (No more than 1 per form)',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'data-xf-init' => 'disabler',
		'data-container' => '#multiline, #defmultiline, #regmultiline',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Multi-line text',
		'_type' => 'option',
	),
	array(
		'value' => '5',
		'data-xf-init' => 'disabler',
		'data-container' => '#limitholder, #expmulti, #defmulticheck',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Multiple choice (Checkboxes)' . '<span style="color:red;font-weight:bold;">*</span>',
		'_type' => 'option',
	),
	array(
		'value' => '8',
		'data-xf-init' => 'disabler',
		'data-container' => '#expmultiall, #defmulticheckall',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Multiple Choice w/ all of the above option (Checkboxes)' . '<span style="color:red;font-weight:bold;">*</span>',
		'_type' => 'option',
	),
	array(
		'value' => '6',
		'data-xf-init' => 'disabler',
		'data-container' => '#mainplaceholder',
		'data-hide' => 'true',
		'data-invert' => 'true',
		'label' => 'None - This is a header phrase',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'data-xf-init' => 'disabler',
		'data-container' => '#singleline, #defsingleline, #regsingleline',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Single line text',
		'_type' => 'option',
	),
	array(
		'value' => '7',
		'data-xf-init' => 'disabler',
		'data-container' => '#expsingle, #defsingledrop',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Single selection dropdown' . '<span style="color:red;font-weight:bold;">*</span>',
		'_type' => 'option',
	),
	array(
		'value' => '12',
		'data-xf-init' => 'disabler',
		'data-container' => '#defsingleforum',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Single selection forum list',
		'_type' => 'option',
	),
	array(
		'value' => '4',
		'data-xf-init' => 'disabler',
		'data-container' => '#expradio, #defradio',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Single selection radio button' . '<span style="color:red;font-weight:bold;">*</span>',
		'_type' => 'option',
	),
	array(
		'value' => '14',
		'data-xf-init' => 'disabler',
		'data-container' => '#expspin, #defspin, #regspin',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Spinbox (number input)',
		'_type' => 'option',
	),
	array(
		'value' => '15',
		'disabled' => ($__vars['prefixtype'] OR ($__vars['form']['oldthread'] ? 'disabled' : '')),
		'label' => 'Thread prefixes (No more than 1 per form)',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'data-xf-init' => 'disabler',
		'data-container' => '#defyesno',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'Yes/No' . '<span style="color:red;font-weight:bold;">*</span>',
		'_type' => 'option',
	),
	array(
		'value' => '13',
		'data-xf-init' => 'disabler',
		'data-container' => '#wysiwyg',
		'data-hide' => 'true',
		'data-autofocus' => 'false',
		'label' => 'WYSIWYG editor',
		'_type' => 'option',
	)), array(
		'label' => 'Answer type',
		'explain' => 'Select the type of answer you expect to receive for this question.<br />Answers types marked with <span style="color:red;font-weight:bold;">*</span> may be used as a trigger for conditional questions.<br /><span style="color:red;"><b>WARNING: </b></span>If this question has conditional questions attached to it and you change the type to a type that can not be used by conditional questions, the conditional questions attached to it will be deleted.<br /><br />If this is a header phrase select \'None - This is a Header Phrase\'.<br />If this is a date picker, the date will appear in reports in the format set in your language options.<br />The File Upload answer type displays the standard XF upload prompt and files are displayed as attachments in PC\'s, new threads and thread replies. If you use <b>BOTH</b> the PC and new thread or existing thread options at the same time, the attachments will only appear in the thread or reply. Attachments are not displayed in the second thread if that report option is selected.<br /><br />If this is a Thread prefixes answer type, all available prefixes that the user can use for the forum the thread is to be posted in will be listed. And the thread prefix will be set to the user\'s selection. <br /><b>The Thread prefixes answer type only works for new threads, it DOES NOT work with "Report in second new thread" or "Report in existing thread".</b><br /><b>The Thread prefixes answer type DOES NOT appear in the form report.</b><br /><br /><b>NOTE:</b> If this is a WYSIWYG answer type and you want people to be able to upload photos, etc. into the field, you must add a File Upload question to the form.<br /><br /><b>NOTE:</b> If this is a File Upload answer type, these permissions for the user\'s user group MUST be set to \'Yes\' for the forum the form is going to be posted in:<br />Post new thread<br />View attachments to posts<br />Upload attachments to posts',
	)) . '

			<div id="mainplaceholder">
				<div id="limitholder">
					' . $__templater->formNumberBoxRow(array(
		'name' => 'checklimit',
		'value' => ($__vars['question']['checklimit'] ? $__vars['question']['checklimit'] : 0),
		'min' => '0',
		'max' => '999',
		'step' => '1',
	), array(
		'label' => 'Checkbox answer limit',
		'explain' => 'You may limit the number of selections a user can make for a checkbox. Set to zero for no limit.',
	)) . '
				
					' . $__templater->formTextBoxRow(array(
		'name' => 'checkerror',
		'value' => ($__vars['question']['checkerror'] ? $__vars['question']['checkerror'] : ''),
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'checkerror', ), false),
	), array(
		'label' => 'Checkbox limit error',
		'explain' => 'Enter the error to be displayed if the users makes too many selections.',
	)) . '

				</div>

				<div id="singleline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'singleline',
		'value' => $__vars['question']['placeholder'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'placeholder', ), false),
	), array(
		'label' => 'Placeholder',
		'explain' => 'Text and WYSIWYG answer types can have a placeholder displayed in the field. If you wish to display a placeholder, enter it here. 200 character limit. Leave blank if not used.',
	)) . '
				</div>

				<div id="multiline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'multiline',
		'value' => $__vars['question']['placeholder'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'placeholder', ), false),
	), array(
		'label' => 'Placeholder',
		'explain' => 'Text and WYSIWYG answer types can have a placeholder displayed in the field. If you wish to display a placeholder, enter it here. 200 character limit. Leave blank if not used.',
	)) . '
				</div>

				<div id="wysiwyg">
					' . $__templater->formTextBoxRow(array(
		'name' => 'wysiwyg',
		'value' => $__vars['question']['placeholder'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'placeholder', ), false),
	), array(
		'label' => 'Placeholder',
		'explain' => 'Text and WYSIWYG answer types can have a placeholder displayed in the field. If you wish to display a placeholder, enter it here. 200 character limit. Leave blank if not used.',
	)) . '

				</div>
			
				<div id="inline">
					' . $__templater->formRadioRow(array(
		'name' => 'inline',
		'value' => ($__vars['question']['inline'] ? $__vars['question']['inline'] : 1),
	), array(array(
		'value' => '1',
		'label' => 'As attachment',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'In message - full size',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'In message - thumbnail',
		'_type' => 'option',
	)), array(
		'label' => 'File display',
		'explain' => 'Select how the file will be displayed if it is an image',
	)) . '				
				</div>

				<div id="expagree">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedagree',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>
			
				<div id="expmulti">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedmulti',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>

				<div id="expmultiall">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedmultiall',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>

				<div id="expsingle">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedsingle',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>

				<div id="expradio">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedradio',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>

				<div id="expspin">
					' . $__templater->formTextAreaRow(array(
		'name' => 'expectedspin',
		'value' => $__vars['question']['expected'],
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'expected', ), false),
	), array(
		'label' => 'Expected answers',
		'explain' => 'If you selected \'Single Selection\' or \'Multiple Choice\' for the answer type, enter the answers you want to display for this question.<br />Place each answer on a new line.<br />This is not needed for the \'Single selection forum list\' answer type.<br /><br />If you selected \'Spinbox\' for the answer type, enter the number of decimal places that will be allowed and the step or just the step for whole numbers.<br />(decimal example: 0.0001 = 4 decimal places that will step in 0001 increments)<br />(whole number example: 2 = step in increments of 2)<br /><br />If you selected \'Agreement\' for the answer type, enter the text that will be displayed next to the checkbox. If this is left blank with the \'Agreement\' answer type selected, no checkbox will be displayed.',
	)) . '
				</div>

				<div id="defmulticheck">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defmulticheck',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defmulticheckall">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defmulticheckall',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defmultiline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defmultiline',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defsingleline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defsingleline',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defsingledrop">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defsingledrop',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defsingleforum">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defsingleforum',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defradio">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defradio',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defspin">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defspin',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="defyesno">
					' . $__templater->formTextBoxRow(array(
		'name' => 'defyesno',
		'value' => $__vars['question']['defanswer'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'defanswer', ), false),
	), array(
		'label' => 'Default answer',
		'explain' => 'If you wish to provide a default answer for this question enter it here.<br />
All question types except Agreement, File Upload and Header can have a default answer.<br /><b>Text Questions:</b> Will display what you enter here.<br /><b>Single Line Text Questions:</b> Will display either what you enter here and/or the value for the following tags. You may combine text and tags.<br />&nbsp;&nbsp;&nbsp;{username} = User\'s Name<br />&nbsp;&nbsp;&nbsp;{userid} = User\'s User ID<br />&nbsp;&nbsp;&nbsp;{email} = User\'s Email<br />&nbsp;&nbsp;&nbsp;{location} = User\'s Location<br />&nbsp;&nbsp;&nbsp;{custom.CustomUserFieldID} = Custom User Field<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: {custom.skype}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Custom user fields MUST be a Single-line text box custom field<br /><b>Spinbox Questions:</b> You may enter a default value such as 0 or 0.01<br /><b>Yes/No Questions:</b> You MUST use the exact Xenforo Yes or No phrase including any capital letters. In English this is Yes or No.<br /><b>Single selection forum list:</b> Enter the name of the forum EXACTLY how it is entered in the Forums/Nodes list.<br /><b>All other question types:</b> You must enter one of the selections EXACTLY as you entered it in Expected Answers.',
	)) . '
				</div>

				<div id="regmultiline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'regexmulti',
		'value' => $__vars['question']['regex'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regex', ), false),
	), array(
		'label' => 'Match regular expression',
		'explain' => 'You may require Single Line, Multi-Line Text and Spinbox answers to match a regular expression.',
	)) . '
			
					' . $__templater->formTextBoxRow(array(
		'name' => 'regexerrormulti',
		'value' => $__vars['question']['regexerror'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regexerror', ), false),
	), array(
		'label' => 'Regular expression validation error',
		'explain' => 'What error should be displayed if the answer fails regular expression validation?',
	)) . '
				</div>

				<div id="regsingleline">
					' . $__templater->formTextBoxRow(array(
		'name' => 'regexsingle',
		'value' => $__vars['question']['regex'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regex', ), false),
	), array(
		'label' => 'Match regular expression',
		'explain' => 'You may require Single Line, Multi-Line Text and Spinbox answers to match a regular expression.',
	)) . '

					' . $__templater->formTextBoxRow(array(
		'name' => 'regexerrorsingle',
		'value' => $__vars['question']['regexerror'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regexerror', ), false),
	), array(
		'label' => 'Regular expression validation error',
		'explain' => 'What error should be displayed if the answer fails regular expression validation?',
	)) . '
				</div>

				<div id="regspin">
					' . $__templater->formTextBoxRow(array(
		'name' => 'regexspin',
		'value' => $__vars['question']['regex'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regex', ), false),
	), array(
		'label' => 'Match regular expression',
		'explain' => 'You may require Single Line, Multi-Line Text and Spinbox answers to match a regular expression.',
	)) . '
			
					' . $__templater->formTextBoxRow(array(
		'name' => 'regexerrorspin',
		'value' => $__vars['question']['regexerror'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'regexerror', ), false),
	), array(
		'label' => 'Regular expression validation error',
		'explain' => 'What error should be displayed if the answer fails regular expression validation?',
	)) . '
				</div>
			
				' . $__templater->formTextBoxRow(array(
		'name' => 'error',
		'value' => $__vars['question']['error'],
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'error', ), false),
	), array(
		'label' => 'Question error',
		'explain' => 'What error should be displayed if the user fails to answer this question?<br />
<font style="color:blue;"><b>NOTE:</b></font> If you do not include an error, the question will be optional and the user will not be required to answer it.<br />
<font style="color:blue;"><b>NOTE:</b></font> If this is a Thread prefixes question and there is a thread prefix selected in the Thread report options for this form, and you include an error here, the error will never be displayed and the default prefix for the form will be used.<br /><font style="color:red;"><b>WARNING:</b></font> If you are promoting a user to a forum moderator with Poll & Promote YOU MUST enter an error for the \'Single selection forum list\' answer type.',
	)) . '

				<hr class="formRowSep" />

				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'showquestion',
		'value' => '1',
		'selected' => $__vars['question']['showquestion'],
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Show question in report',
		'explain' => 'Check this box to show the actual question in the report post/pc. If this box is not checked, only the answer to this question will be posted.',
	)) . '
			
				' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'showunanswered',
		'value' => '1',
		'selected' => $__vars['question']['showunanswered'],
		'label' => '&nbsp;',
		'_type' => 'option',
	)), array(
		'label' => 'Show question if not answered',
		'explain' => 'Check this box to show the actual question in the report post/pc if it is not answered. If this box is not checked, the question will not be displayed if the question is not answered.<br /><b>NOTE:</b> If this box is not checked, the unanswered question will also not be saved to the database if the "Save answers to database" option is selected in the main form options.',
	)) . '
			
				<hr class="formRowSep" />

				' . $__templater->formTextAreaRow(array(
		'name' => 'format',
		'value' => ($__vars['question']['format'] ? $__vars['question']['format'] : '[B]{question}[/B] {answer}'),
		'autosize' => 'true',
		'maxlength' => $__templater->func('max_length', array($__vars['question'], 'format', ), false),
	), array(
		'label' => 'Report format',
		'explain' => 'Enter the report format for this question. Use BB Codes.<br />This MUST contain the {question} and {answer} replacement variables, even if one of them is not used.',
	)) . '
			
				' . $__templater->formSelectRow(array(
		'name' => 'questionpos',
		'value' => ($__vars['question']['questionpos'] ? $__vars['question']['questionpos'] : 1),
	), array(array(
		'value' => '1',
		'label' => 'Two lines below previous question',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'One line below previous question',
		'_type' => 'option',
	),
	array(
		'value' => '5',
		'label' => 'Same line as previous question',
		'_type' => 'option',
	)), array(
		'label' => 'Question position in report Post/PC',
		'explain' => 'Select where you want the question to appear in the report post/pc.',
	)) . '
			</div>

			' . $__compilerTemp5 . '
			
			<input type="hidden" value="' . ($__vars['question']['posid'] ? $__templater->escape($__vars['question']['posid']) : ($__vars['form']['posid'] ? $__templater->escape($__vars['form']['posid']) : 0)) . '" name="posid" />
			<input type="hidden" value="1" name="isconditional" />
			
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('form-questions/save', $__vars['question'], ), false),
		'ajax' => 'false',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);