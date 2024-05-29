<?php
// FROM HASH: 3c86cd2abda983df41530b73bea80ff1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Start Quiz');
	$__finalCompiled .= '

' . $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__templater->escape($__vars['quiz']['quiz_name']) . '
			', array(
		'label' => 'Title',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['quiz']['quiz_des']) . '
			', array(
		'label' => 'Description',
	)) . '

			' . $__templater->formRow('
				' . $__templater->func('count', array($__vars['quiz']['quiz_questions'], ), true) . '
			', array(
		'label' => 'Questions',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__vars['quiz']['time_per_question']) . ' ' . 'Seconds' . '
			', array(
		'label' => 'Time Per Question',
	)) . '

			' . $__templater->formRow('
				' . $__templater->escape($__templater->method($__vars['quiz'], 'getQuizDuration', array())) . '
			', array(
		'label' => 'Quiz Duration',
	)) . '

		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Start',
		'icon' => 'confirm',
		'sticky' => 'true',
	), array(
		'rowtype' => 'simple',
		'html' => '
				' . $__templater->button('Cancel', array(
		'href' => $__templater->func('link', array('quiz', ), false),
		'icon' => 'cancel',
	), '', array(
	)) . '
				' . $__templater->button('fs_quiz_check_result', array(
		'href' => $__templater->func('link', array('quiz/check-result', $__vars['quiz'], ), false),
		'icon' => 'cancel',
	), '', array(
	)) . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('quiz/quiz-start', $__vars['quiz'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);