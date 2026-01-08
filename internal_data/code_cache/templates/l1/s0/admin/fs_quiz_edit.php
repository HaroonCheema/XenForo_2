<?php
// FROM HASH: f1c1c8f91bdd8d1d8a31be44655cd26b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['quiz'] != null) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Quiz' . $__vars['xf']['language']['label_separator']);
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Quiz' . $__vars['xf']['language']['label_separator']);
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__compilerTemp1 .= '
				';
		}
	}
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['category']['category_id'],
				'selected' => $__vars['category']['category_id'] == $__vars['quiz']['category_id'],
				'label' => $__templater->escape($__vars['category']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			' . $__templater->formSelectRow(array(
		'name' => 'quiz_category',
		'value' => '$categories',
	), $__compilerTemp2, array(
		'label' => 'Quiz Categories',
	)) . '
			' . $__templater->formTextAreaRow(array(
		'name' => 'quiz_name',
		'value' => ($__vars['quiz'] ? $__vars['quiz']['quiz_name'] : ''),
		'placeholder' => 'Quiz Name',
		'dir' => 'ltr',
	), array(
		'label' => 'Quiz Name',
	)) . '
			' . $__templater->formTextAreaRow(array(
		'name' => 'quiz_des',
		'value' => ($__vars['quiz'] ? $__vars['quiz']['quiz_des'] : ''),
		'placeholder' => 'fs_quiz_des',
		'dir' => 'ltr',
	), array(
		'label' => 'fs_quiz_des',
	)) . '
				' . $__templater->formTokenInputRow(array(
		'name' => 'quiz_questions',
		'value' => $__vars['pre_qsn'],
		'href' => $__templater->func('link', array('quiz/find', ), false),
		'min-length' => '1',
		'max-tokens' => (($__templater->func('count', array($__vars['question'], ), false) > 0) ? ($__templater->func('count', array($__vars['question'], ), false) + 1) : null),
	), array(
		'label' => 'Quiz Questions',
		'explain' => ($__vars['quiz'] ? 'The questions being display are dummy add them again.' : ''),
	)) . '
	
			' . $__templater->formRow('
				' . $__templater->formRadio(array(
		'name' => 'quiz_state',
		'value' => $__vars['quiz']['quiz_state'],
	), array(array(
		'label' => 'Open',
		'class' => 'mycheckbox',
		'name' => 'quiz_state',
		'value' => 'open',
		'_type' => 'option',
	),
	array(
		'label' => 'Closed',
		'class' => 'mycheckbox',
		'name' => 'quiz_state',
		'value' => 'closed',
		'_type' => 'option',
	))) . '
			', array(
		'label' => 'Quiz State',
	)) . '
			' . $__templater->formRow('
				 ' . $__templater->formTextBox(array(
		'type' => 'time',
		'name' => 'start_time',
		'value' => $__vars['st_time'],
		'style' => 'width: 28%;',
	)) . '<br>
				' . $__templater->formDateInput(array(
		'name' => 'quiz_start_date',
		'value' => $__vars['st_date'],
		'required' => 'true',
		'autocomplete' => 'off',
	)) . '
			', array(
		'label' => 'Quiz Start Date & Time',
	)) . '
			' . $__templater->formRow('
				 ' . $__templater->formTextBox(array(
		'type' => 'time',
		'name' => 'end_time',
		'value' => $__vars['end_time'],
		'style' => 'width: 28%;',
	)) . '<br>
				' . $__templater->formDateInput(array(
		'name' => 'quiz_end_date',
		'value' => $__vars['end_date'],
		'required' => 'true',
		'autocomplete' => 'off',
	)) . '
			', array(
		'label' => 'Quiz End Date & Time',
	)) . '
			' . $__templater->formNumberBoxRow(array(
		'name' => 'qsn_time',
		'min' => '60',
		'value' => $__vars['quiz']['time_per_question'],
	), array(
		'label' => 'Question Time',
		'explain' => 'in Seconds',
	)) . '
			
			' . $__templater->formCheckBoxRow(array(
		'name' => 'user_groups[]',
		'value' => $__vars['quiz']['user_group'],
	), $__compilerTemp3, array(
		'label' => 'Allowed Users',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('quiz/save', $__vars['quiz'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);