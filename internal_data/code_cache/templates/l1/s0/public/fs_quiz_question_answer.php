<?php
// FROM HASH: be3d01b75d0f3860f5ac330796ffb895
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Question # ' . $__templater->escape($__vars['quesNo']) . ' out of ' . $__templater->escape($__vars['totalQuestions']) . '');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['finish']) {
		$__compilerTemp1 .= '
			' . $__templater->formSubmitRow(array(
			'submit' => 'Finish',
			'icon' => 'confirm',
			'sticky' => 'true',
		), array(
			'rowtype' => 'simple',
		)) . '
			';
	} else {
		$__compilerTemp1 .= '
			' . $__templater->formSubmitRow(array(
			'submit' => 'Next',
			'icon' => 'confirm',
			'sticky' => 'true',
		), array(
			'rowtype' => 'simple',
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__templater->escape($__vars['question']['question_title']) . '
			', array(
		'label' => 'Question',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBox(array(
		'name' => 'answer',
		'placeholder' => 'Enter your answer here...!',
		'required' => 'required',
		'minlength' => '2',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Answer',
		'hint' => 'Required',
	)) . '

		</div>

		' . $__compilerTemp1 . '
	</div>
	' . $__templater->formHiddenVal('id', $__vars['quizId'], array(
	)) . '
', array(
		'action' => $__templater->func('link', array('question/next', $__vars['question'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);