<?php
// FROM HASH: ddd9048440b2ddd62437235931214dbd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('fs_quiz_result');
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
		'label' => 'Questions',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['attemptQuestion']) . '
		', array(
		'label' => 'fs_quiz_attempt_questions',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['correctAnswers']) . '
		', array(
		'label' => 'fs_quiz_correct_answer',
	)) . '

		' . $__templater->formRow('
			' . $__templater->escape($__vars['wrongAnswers']) . '
		', array(
		'label' => 'fs_quiz_wrong_answers',
	)) . '

		<center>' . $__templater->formRow('
			' . $__templater->button('fs_quiz_check_result', array(
		'href' => $__templater->func('link', array('quiz/more-details', $__vars['quiz'], ), false),
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