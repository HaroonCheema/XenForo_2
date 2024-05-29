<?php
// FROM HASH: 35f2f4e41a87e3496f68b242aa1a0042
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Question # ' . $__templater->escape($__vars['quesNo']) . ' out of ' . $__templater->escape($__vars['totalQuestions']) . '');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['question']['options'])) {
		foreach ($__vars['question']['options'] AS $__vars['key'] => $__vars['val']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['key'],
				'label' => $__templater->escape($__vars['val']),
				'selected' => ($__vars['key'] == 0),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = '';
	if ($__vars['finish']) {
		$__compilerTemp2 .= '
			' . $__templater->formSubmitRow(array(
			'submit' => 'Finish',
			'icon' => 'confirm',
			'sticky' => 'true',
		), array(
			'rowtype' => 'simple',
		)) . '
			';
	} else {
		$__compilerTemp2 .= '
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

			' . $__templater->formRadioRow(array(
		'name' => 'answer',
	), $__compilerTemp1, array(
		'label' => 'Select',
		'explain' => 'Select any option...!',
	)) . '

		</div>

		' . $__compilerTemp2 . '
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