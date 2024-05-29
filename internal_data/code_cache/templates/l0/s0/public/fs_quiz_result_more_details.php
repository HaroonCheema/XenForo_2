<?php
// FROM HASH: 4c6368d4a5374dce6745e34918107e57
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quiz Result Details :' . ' ' . $__templater->escape($__vars['quiz']['quiz_name']));
	$__finalCompiled .= '

<div class="block-container">
	<div class="block-body">

		';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['questions'])) {
		foreach ($__vars['questions'] AS $__vars['question']) {
			$__vars['i']++;
			$__finalCompiled .= '
			<center>' . $__templater->formRow('<h3>
				' . 'Question # ' . $__templater->escape($__vars['i']) . '' . '
				</h3>', array(
			)) . '</center>
			' . $__templater->formRow('
				' . $__templater->escape($__vars['question']['Question']['question_title']) . '
			', array(
				'label' => 'Question Title',
			)) . '

			';
			if ($__vars['question']['Question']['question_type'] == 'textbox') {
				$__finalCompiled .= '

				' . $__templater->formRow('
					' . $__templater->escape($__vars['question']['Question']['question_correct_answer']) . '
				', array(
					'label' => 'Question Answer',
				)) . '

				';
			} else {
				$__finalCompiled .= '
				
				';
				$__compilerTemp1 = array();
				if ($__templater->isTraversable($__vars['question']['Question']['options'])) {
					foreach ($__vars['question']['Question']['options'] AS $__vars['key'] => $__vars['val']) {
						$__compilerTemp1[] = array(
							'value' => $__vars['key'],
							'label' => $__templater->escape($__vars['val']),
							'selected' => ($__vars['key'] == $__vars['question']['at_index']),
							'_type' => 'option',
						);
					}
				}
				$__finalCompiled .= $__templater->formRadioRow(array(
					'name' => '',
				), $__compilerTemp1, array(
					'label' => 'Question Answer',
				)) . '
				
				


			';
			}
			$__finalCompiled .= '

			' . $__templater->formRow('
				' . $__templater->formTextBox(array(
				'name' => '',
				'value' => $__vars['question']['answer'],
				'readOnly' => 'readOnly',
			)) . '
			', array(
				'label' => 'Your Answer',
			)) . '

			' . $__templater->formRow('
				' . ($__vars['question']['correct'] ? 'Yes' : 'No') . '
			', array(
				'label' => 'Is Correct',
			)) . '


		';
		}
	}
	$__finalCompiled .= '

		<center>' . $__templater->formRow('
			' . $__templater->button('Back', array(
		'href' => $__templater->func('link', array('quiz', ), false),
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