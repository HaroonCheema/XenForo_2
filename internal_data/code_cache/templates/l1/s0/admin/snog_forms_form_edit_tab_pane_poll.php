<?php
// FROM HASH: 42a634634d9f92022e1815091a712bb9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'Creates a normal poll when this form is submitted. It DOES NOT affect promotion options and should not be used if Poll promotion is used.',
	)) . '

<div class="block-body">
	
	' . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'normalpoll',
		'value' => '1',
		'selected' => $__vars['form']['normalpoll'],
		'_type' => 'option',
	)), array(
		'label' => 'Create normal poll',
		'explain' => 'Check this box if you would like to create a normal poll when this form is submitted.<br /><font style="color:blue"><b>NOTE:</b></font> You MUST select \'Report in New Thread\' in Report Type/Thread report options if you use this option.',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'normalpublic',
		'value' => '1',
		'selected' => $__vars['form']['normalpublic'],
		'_type' => 'option',
	)), array(
		'label' => 'Display votes publicly',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'normalchange',
		'value' => '1',
		'selected' => $__vars['form']['normalchange'],
		'_type' => 'option',
	)), array(
		'label' => 'Allow voters to change their votes',
	)) . '
	
	' . '
	' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'normalview',
		'value' => '1',
		'selected' => $__vars['form']['normalview'],
		'_type' => 'option',
	)), array(
		'label' => 'Allow the results to be viewed without voting',
	)) . '
	
	' . '
	' . $__templater->formRow('
		<div class="inputGroup">
			<div class="inputGroup inputGroup--numbers inputNumber" data-xf-init="number-box">
				' . $__templater->formTextBox(array(
		'name' => 'normalclose',
		'value' => (($__vars['form']['normalclose'] >= 1) ? $__vars['form']['normalclose'] : 1),
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
		'name' => 'normalquestion',
		'value' => $__vars['form']['normalquestion'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'normalquestion', ), false),
	), array(
		'label' => 'Question',
		'explain' => 'Enter the question that should be asked with this poll.',
	)) . '

	' . '
	';
	$__compilerTemp1 = '';
	if ($__vars['form']['response']) {
		$__compilerTemp1 .= '
				';
		if ($__templater->isTraversable($__vars['form']['response'])) {
			foreach ($__vars['form']['response'] AS $__vars['key'] => $__vars['response']) {
				$__compilerTemp1 .= '
					';
				if ($__vars['response']) {
					$__compilerTemp1 .= '
						<li>
							' . $__templater->formTextBox(array(
						'name' => 'response[' . $__vars['key'] . ']',
						'value' => $__vars['response'],
						'placeholder' => 'Poll choice' . $__vars['xf']['language']['ellipsis'],
						'maxlength' => '100',
					)) . '
						</li>
					';
				}
				$__compilerTemp1 .= '
				';
			}
		}
		$__compilerTemp1 .= '
			';
	}
	$__vars['remainingResponses'] = ($__vars['xf']['options']['pollMaximumResponses'] - ($__vars['responses'] ? $__templater->func('count', array($__vars['responses'], ), false) : 0));
	$__compilerTemp2 = '';
	if ($__vars['remainingResponses'] > 0) {
		$__compilerTemp2 .= '
				<li data-xf-init="field-adder" data-remaining="' . ($__vars['remainingResponses'] - 1) . '">
					' . $__templater->formTextBox(array(
			'name' => 'response[]',
			'value' => '',
			'placeholder' => 'Poll choice' . $__vars['xf']['language']['ellipsis'],
			'maxlength' => '100',
		)) . '
				</li>
			';
	}
	$__finalCompiled .= $__templater->formRow('
		<ul class="inputList">
			' . $__compilerTemp1 . '
			' . '' . '
			' . $__compilerTemp2 . '
		</ul>
	', array(
		'label' => 'Possible responses',
		'rowtype' => 'input',
	)) . '
	
	' . '
	
</div>';
	return $__finalCompiled;
}
);