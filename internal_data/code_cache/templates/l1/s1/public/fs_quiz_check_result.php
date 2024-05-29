<?php
// FROM HASH: d0d7e80c55bc42e7417f7ab3ae652e68
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quiz Result');
	$__finalCompiled .= '

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
		'label' => 'Total Questions',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['attemptQuestion']) . '
		', array(
		'label' => 'Attempt Questions',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['correctAnswers']) . '
		', array(
		'label' => 'Correct Answers',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['wrongAnswers']) . '
		', array(
		'label' => 'Wrong Answers',
	)) . '

		<center>' . $__templater->formRow('
			' . $__templater->button('More Details', array(
		'href' => $__templater->func('link', array('quiz/more-details', $__vars['quiz'], ), false),
		'icon' => 'cancel',
	), '', array(
	)) . '
			' . $__templater->button('Back', array(
		'href' => $__templater->func('link', array('quiz/quiz-confirm', $__vars['quiz'], ), false),
		'icon' => 'cancel',
	), '', array(
	)) . '
			', array(
	)) . '</center>

	</div>
</div>';
	return $__finalCompiled;
}
);