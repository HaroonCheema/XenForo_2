<?php
// FROM HASH: fd6b1a90f25ccec2395176fc42d40f8e
return array(
'macros' => array('form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'warnings' => '!',
		'questions' => '!',
		'conditionQuestions' => '!',
		'canSubmit' => '!',
		'replyThread' => null,
		'noupload' => false,
		'attachmentData' => null,
		'row' => true,
		'nodeTree' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['warnings']) {
		$__compilerTemp1 .= '
			<div class="blockMessage blockMessage--warning">
				';
		if ($__templater->isTraversable($__vars['warnings'])) {
			foreach ($__vars['warnings'] AS $__vars['warning']) {
				$__compilerTemp1 .= '
					' . $__templater->escape($__vars['warning']) . '
				';
			}
		}
		$__compilerTemp1 .= '
			</div>
		';
	}
	$__compilerTemp2 = '';
	if ($__vars['form']['aboveapp']) {
		$__compilerTemp2 .= '
					' . $__templater->formInfoRow('
						' . $__templater->func('bb_code', array($__vars['form']['aboveapp'], '', '', ), true) . '
					', array(
		)) . '
				';
	}
	$__vars['divcreated'] = '0';
	$__compilerTemp3 = '';
	if ($__templater->func('count', array($__vars['questions'], ), false) > 0) {
		$__compilerTemp3 .= '
					';
		if ($__templater->isTraversable($__vars['questions'])) {
			foreach ($__vars['questions'] AS $__vars['question']) {
				$__compilerTemp3 .= '
						';
				if (!$__vars['question']['conditional']) {
					$__compilerTemp3 .= '
							' . '
							';
					if ($__vars['question']['type'] == 1) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_text', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 2) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_text_multi', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 3) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_yes_no', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'conditionQuestions' => $__vars['conditionQuestions'][$__vars['question']['questionid']],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 4) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_radio', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'conditionQuestions' => $__vars['conditionQuestions'][$__vars['question']['questionid']],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if (($__vars['question']['type'] == 5) OR ($__vars['question']['type'] == 8)) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_checkboxes', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'conditionQuestions' => $__vars['conditionQuestions'][$__vars['question']['questionid']],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 6) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_header', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 7) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_select', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'conditionQuestions' => $__vars['conditionQuestions'][$__vars['question']['questionid']],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 9) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_agreement', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 10) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_file_upload', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'noupload' => $__vars['noupload'],
							'attachmentData' => $__vars['attachmentData'],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 11) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_date_input', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 12) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_forum_select', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
							'nodeTree' => $__vars['nodeTree'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 13) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_wisywig', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 14) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_spinbox', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							' . '
							';
					if ($__vars['question']['type'] == 15) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'type_prefix', array(
							'form' => $__vars['form'],
							'question' => $__vars['question'],
							'canSubmit' => '{canSubmit}',
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '

							';
					if ($__vars['question']['hasconditional']) {
						$__compilerTemp3 .= '
								' . $__templater->callMacro(null, 'conditional_questions', array(
							'question' => $__vars['question'],
							'questions' => $__vars['questions'],
							'attachmentData' => $__vars['attachmentData'],
							'forum' => $__vars['forum'],
							'conditionQuestions' => $__vars['conditionQuestions'],
							'row' => $__vars['row'],
						), $__vars) . '
							';
					}
					$__compilerTemp3 .= '
						';
				}
				$__compilerTemp3 .= '
					';
			}
		}
		$__compilerTemp3 .= '
				';
	} else {
		$__compilerTemp3 .= '
					';
		if ($__vars['row']) {
			$__compilerTemp3 .= '
						' . $__templater->formRow('
							' . 'There is nothing to display.' . '
						', array(
				'rowtype' => 'fullWidth noLabel',
			)) . '
					';
		} else {
			$__compilerTemp3 .= '
						<div class="menu-row">' . 'There is nothing to display.' . '</div>
					';
		}
		$__compilerTemp3 .= '
				';
	}
	$__compilerTemp4 = '';
	if ($__vars['form']['belowapp']) {
		$__compilerTemp4 .= '
					<dl class="formRow">
						<dt style="width:100%; text-align:left; border:none;">' . $__templater->func('bb_code', array($__vars['form']['belowapp'], '', '', ), true) . '</dt>
						<dd style="display:none;"></dd>
					</dl>
				';
	}
	$__compilerTemp5 = '';
	if ($__vars['canSubmit']) {
		$__compilerTemp5 .= '
					';
		$__vars['formData'] = $__templater->preEscaped($__templater->func('captcha', array(false, false)));
		$__compilerTemp5 .= '
					';
		if (!$__templater->test($__templater->filter($__vars['formData'], array(array('raw', array()),), false), 'empty', array())) {
			$__compilerTemp5 .= '
						';
			if ($__vars['row']) {
				$__compilerTemp5 .= '
							' . $__templater->formRow('
									' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
							', array(
					'rowtype' => 'input',
					'label' => 'Verification',
				)) . '
						';
			} else {
				$__compilerTemp5 .= '
							<div class="menu-row">
								<label>' . 'Verification' . '</label>
								<div class="u-inputSpacer">
									' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
								</div>
							</div>
						';
			}
			$__compilerTemp5 .= '
					';
		}
		$__compilerTemp5 .= '
				';
	}
	$__compilerTemp6 = '';
	if ($__vars['replyThread']) {
		$__compilerTemp6 .= '
				<input type="hidden" name="replythread" value="' . $__templater->escape($__vars['replyThread']) . '" />
			';
	}
	$__compilerTemp7 = '';
	if (!$__vars['called']) {
		$__compilerTemp7 .= '
				' . $__templater->formSubmitRow(array(
			'icon' => 'save',
			'submit' => 'Submit',
			'sticky' => 'false',
			'class' => ((!$__vars['canSubmit']) ? 'is-disabled' : ''),
			'disabled' => (!$__vars['canSubmit']),
		), array(
			'rowtype' => ($__vars['row'] ? '' : 'simple'),
		)) . '
			';
	} else {
		$__compilerTemp7 .= '
				' . $__templater->formSubmitRow(array(
			'icon' => 'reply',
			'submit' => 'Post reply',
			'sticky' => 'false',
			'class' => ((!$__vars['canSubmit']) ? 'is-disabled' : ''),
			'disabled' => (!$__vars['canSubmit']),
		), array(
			'rowtype' => ($__vars['row'] ? '' : 'simple'),
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('

		' . $__compilerTemp1 . '

		<div class="block-container">
			<div class="block-body">
				' . $__compilerTemp2 . '

				' . '' . '
				
				' . $__compilerTemp3 . '

				' . $__compilerTemp4 . '

				' . $__compilerTemp5 . '
			</div>

			' . $__compilerTemp6 . '

			' . $__compilerTemp7 . '
		</div>
	', array(
		'action' => $__templater->func('link', array('form/submit', $__vars['form'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'attachment-manager',
		'data-force-flash-message' => 'true',
		'data-ajax-redirect' => 'true',
	)) . '
';
	return $__finalCompiled;
}
),
'type_agreement' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__vars['question']['expected']) {
			$__compilerTemp1 .= '
				<div class="u-alignCenter">
					<input type="checkbox" name="question[' . $__templater->escape($__vars['question']['questionid']) . ']" value="' . 'Yes' . '" /> ' . $__templater->escape($__vars['question']['expected']) . '
				</div>
			';
		}
		$__finalCompiled .= $__templater->formRow('
			' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '
			' . $__compilerTemp1 . '
		', array(
			'rowtype' => 'noLabel fullWidth mergeNext',
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '<br />
			';
		if ($__vars['question']['expected']) {
			$__finalCompiled .= '
				<div class="u-alignCenter">
					<input type="checkbox" name="question[' . $__templater->escape($__vars['question']['questionid']) . ']" value="' . 'Yes' . '" /> ' . $__templater->escape($__vars['question']['expected']) . '
				</div>
			';
		}
		$__finalCompiled .= '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		<dl class="formRow">
			<dt style="width:100%; border:none;text-align:center;"><b>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</b></dt>
			<dd style="display:none;"></dd>
		</dl>
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<h4 class="menu-header">' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</h4>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_text' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['defanswer'] = $__templater->method($__vars['question'], 'getDefaultAnswer', array());
	$__finalCompiled .= '
	';
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formTextBox(array(
		'placeholder' => $__vars['question']['placeholder'],
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => ($__vars['defanswer'] ?: ''),
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	)) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_text_multi' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formTextArea(array(
		'placeholder' => $__vars['question']['placeholder'],
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => $__vars['question']['defanswer'],
		'required' => ($__vars['question']['error'] ? 'required' : ''),
		'autosize' => 'true',
		'readonly' => (!$__vars['canSubmit']),
	)) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_yes_no' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'conditionQuestions' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['answer1'] = 'Yes';
	$__finalCompiled .= '
	';
	$__vars['answer2'] = 'No';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['question']['hasconditional']) {
		$__vars['answer'] = '1';
		$__vars['allset'] = '0';
		$__vars['set'] = '0';
		$__vars['set2'] = '0';
		if ($__templater->isTraversable($__vars['conditionQuestions'])) {
			foreach ($__vars['conditionQuestions'] AS $__vars['conkey'] => $__vars['conditionQuestion']) {
				if ($__vars['answer'] == 1) {
					if (($__vars['conditionQuestion']['answer'] == 1) AND (!$__vars['set'])) {
						$__compilerTemp1[] = array(
							'value' => '1',
							'selected' => (($__vars['question']['defanswer'] == $__vars['answer1']) ? true : false),
							'data-xf-init' => 'disabler',
							'data-container' => '#conditional' . $__vars['question']['questionid'] . '-1',
							'data-hide' => 'true',
							'label' => '
								' . 'Yes' . '
							',
							'_type' => 'option',
						);
						$__vars['set'] = '1';
						$__vars['answer'] = '2';
					}
					if (!$__vars['set']) {
						$__compilerTemp1[] = array(
							'value' => '1',
							'selected' => (($__vars['question']['defanswer'] == $__vars['answer1']) ? true : false),
							'label' => 'Yes',
							'_type' => 'option',
						);
						$__vars['answer'] = '2';
					}
				}
				if ($__vars['answer'] == 2) {
					if (!$__vars['allset']) {
						if (($__vars['conditionQuestion']['answer'] == 2) AND (!$__vars['set2'])) {
							$__compilerTemp1[] = array(
								'value' => '2',
								'selected' => (($__vars['question']['defanswer'] == $__vars['answer2']) ? true : false),
								'data-xf-init' => 'disabler',
								'data-container' => '#conditional' . $__vars['question']['questionid'] . '-2',
								'data-hide' => 'true',
								'label' => '
									' . 'No' . '
								',
								'_type' => 'option',
							);
							$__vars['set2'] = '1';
							$__vars['allset'] = '1';
						}
					}
					if ((!$__vars['set2']) AND (!$__vars['allset'])) {
						$__compilerTemp1[] = array(
							'value' => '2',
							'selected' => (($__vars['question']['defanswer'] == $__vars['answer2']) ? true : false),
							'label' => 'No',
							'_type' => 'option',
						);
						$__vars['allset'] = '1';
					}
				}
			}
		}
	} else {
		$__compilerTemp1[] = array(
			'value' => '1',
			'selected' => (($__vars['question']['defanswer'] == $__vars['answer1']) ? true : false),
			'label' => 'Yes',
			'_type' => 'option',
		);
		$__compilerTemp1[] = array(
			'value' => '2',
			'selected' => (($__vars['question']['defanswer'] == $__vars['answer2']) ? true : false),
			'label' => 'No',
			'_type' => 'option',
		);
	}
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formRadio(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => '',
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_radio' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'conditionQuestions' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array();
	$__vars['allset'] = '0';
	$__compilerTemp2 = $__templater->method($__vars['question'], 'getExpectedAnswers', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['answer']) {
			if ($__vars['question']['hasconditional']) {
				$__vars['hasConditional'] = false;
				if ($__templater->isTraversable($__vars['conditionQuestions'])) {
					foreach ($__vars['conditionQuestions'] AS $__vars['conkey'] => $__vars['conditionQuestion']) {
						if ($__vars['conditionQuestion']['answer'] == ($__vars['key'] + 1)) {
							$__vars['hasConditional'] = true;
						}
					}
				}
				if ($__vars['hasConditional']) {
					$__compilerTemp1[] = array(
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'data-xf-init' => 'disabler',
						'data-container' => '#conditional' . $__vars['question']['questionid'] . '-' . ($__vars['key'] + 1),
						'data-hide' => 'true',
						'label' => '
							' . $__templater->escape($__vars['answer']) . '
						',
						'_type' => 'option',
					);
				} else {
					$__compilerTemp1[] = array(
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'label' => $__templater->escape($__vars['answer']),
						'_type' => 'option',
					);
				}
			} else {
				$__compilerTemp1[] = array(
					'value' => ($__vars['key'] + 1),
					'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
					'label' => $__templater->escape($__vars['answer']),
					'_type' => 'option',
				);
			}
		}
	}
	$__vars['formData'] = $__templater->preEscaped('

		' . $__templater->formRadio(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => '',
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_checkboxes' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'conditionQuestions' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array();
	$__vars['allset'] = '0';
	$__compilerTemp2 = $__templater->method($__vars['question'], 'getExpectedAnswers', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['answer']) {
			if ($__vars['question']['hasconditional']) {
				$__vars['hasConditional'] = false;
				if ($__templater->isTraversable($__vars['conditionQuestions'])) {
					foreach ($__vars['conditionQuestions'] AS $__vars['conkey'] => $__vars['conditionQuestion']) {
						if ($__vars['conditionQuestion']['answer'] == ($__vars['key'] + 1)) {
							$__vars['hasConditional'] = true;
						}
					}
				}
				if ($__vars['hasConditional']) {
					$__compilerTemp1[] = array(
						'class' => 'checkAll' . $__vars['question']['questionid'],
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'data-xf-init' => 'disabler',
						'data-container' => '#conditional' . $__vars['question']['questionid'] . '-' . ($__vars['key'] + 1),
						'data-autofocus' => 'false',
						'data-hide' => 'true',
						'label' => '
							' . $__templater->escape($__vars['answer']) . '
						',
						'_type' => 'option',
					);
				} else {
					$__compilerTemp1[] = array(
						'class' => 'checkAll' . $__vars['question']['questionid'],
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'label' => '
							' . $__templater->escape($__vars['answer']) . '
						',
						'_type' => 'option',
					);
				}
			} else {
				$__compilerTemp1[] = array(
					'class' => 'checkAll' . $__vars['question']['questionid'],
					'value' => ($__vars['key'] + 1),
					'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
					'label' => '
						' . $__templater->escape($__vars['answer']) . '
					',
					'_type' => 'option',
				);
			}
		}
	}
	if ($__vars['question']['type'] == 8) {
		$__compilerTemp1[] = array(
			'id' => 'selectAll' . $__vars['question']['questionid'],
			'value' => 'all',
			'label' => 'All of the above',
			'_type' => 'option',
		);
	}
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formCheckBox(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '

	';
	if ($__vars['question']['type'] == 8) {
		$__finalCompiled .= '
		<script>
			$("#selectAll' . $__templater->escape($__vars['question']['questionid']) . '").change(function() {
				$(\'.checkAll' . $__templater->escape($__vars['question']['questionid']) . '\').click();
				$(\'.checkAll' . $__templater->escape($__vars['question']['questionid']) . '\').prop(\'checked\', this.checked).change();
			});

			$(\'.checkAll' . $__templater->escape($__vars['question']['questionid']) . '\').click(function() {
				if($(\'#selectAll' . $__templater->escape($__vars['question']['questionid']) . '\').prop(\'checked\'))
				{
					$(\'#selectAll' . $__templater->escape($__vars['question']['questionid']) . '\').prop(\'checked\', this.checked).change();
				}
			});
		</script>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'conditionQuestions' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'Choose one',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['question'], 'getExpectedAnswers', array());
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['key'] => $__vars['answer']) {
			if ($__vars['question']['hasconditional']) {
				$__vars['hasConditional'] = false;
				if ($__templater->isTraversable($__vars['conditionQuestions'])) {
					foreach ($__vars['conditionQuestions'] AS $__vars['conkey'] => $__vars['conditionQuestion']) {
						if ($__vars['conditionQuestion']['answer'] == ($__vars['key'] + 1)) {
							$__vars['hasConditional'] = true;
						}
					}
				}
				if ($__vars['hasConditional']) {
					$__compilerTemp1[] = array(
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'data-xf-init' => 'disabler',
						'data-container' => '#conditional' . $__vars['question']['questionid'] . '-' . ($__vars['key'] + 1),
						'data-hide' => 'true',
						'label' => '
							' . $__templater->escape($__vars['answer']) . '
						',
						'_type' => 'option',
					);
				} else {
					$__compilerTemp1[] = array(
						'value' => ($__vars['key'] + 1),
						'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
						'label' => $__templater->escape($__vars['answer']),
						'_type' => 'option',
					);
				}
			} else {
				$__compilerTemp1[] = array(
					'value' => ($__vars['key'] + 1),
					'selected' => (($__vars['question']['defanswer'] == $__vars['answer']) ? true : false),
					'label' => $__templater->escape($__vars['answer']),
					'_type' => 'option',
				);
			}
		}
	}
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formSelect(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => $__vars['question']['expected'],
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_file_upload' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'noupload' => '!',
		'attachmentData' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['attachmentData']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if (!$__templater->test($__vars['forum'], 'empty', array())) {
			$__compilerTemp1 .= '
				' . $__templater->callMacro('snog_forms_helper_upload', 'upload_block', array(
				'attachmentData' => $__vars['attachmentData'],
				'forceHash' => $__vars['forum']['draft_thread']['attachment_hash'],
			), $__vars) . '
			';
		} else {
			$__compilerTemp1 .= '
				' . $__templater->callMacro('snog_forms_helper_upload', 'upload_block', array(
				'attachmentData' => $__vars['attachmentData'],
				'forceHash' => $__vars['draft']['attachment_hash'],
			), $__vars) . '
			';
		}
		$__vars['formData'] = $__templater->preEscaped('
			' . $__compilerTemp1 . '
		');
		$__finalCompiled .= '
		';
		if ($__vars['row']) {
			$__finalCompiled .= '
			';
			if (!$__vars['noupload']) {
				$__finalCompiled .= '
				' . $__templater->formRow('
					' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
				', array(
					'rowtype' => 'input',
					'rowclass' => 'formRow--noColon',
					'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
					'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
					'hint' => ($__vars['question']['error'] ? 'Required' : ''),
				)) . '
			';
			} else {
				$__finalCompiled .= '
				<dl class="formRow">
					<dt>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</dt>
					<dd class="blockMessage blockMessage--error"><b>' . 'You are not allowed to upload files to the forum selected for this form.<br />Please inform the site admin of this error.' . '</b></dd>
				</dl>
			';
			}
			$__finalCompiled .= '
		';
		} else {
			$__finalCompiled .= '
			<div class="menu-row">
				';
			if (!$__vars['noupload']) {
				$__finalCompiled .= '
					<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
					<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
					<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
					<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
				';
			} else {
				$__finalCompiled .= '
					<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
					<div class="blockMessage blockMessage--error"><b>' . 'You are not allowed to upload files to the forum selected for this form.<br />Please inform the site admin of this error.' . '</b></div>
				';
			}
			$__finalCompiled .= '
			</div>
		';
		}
		$__finalCompiled .= '

	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_date_input' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formDateInput(array(
		'data-year-range' => '50',
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => $__vars['input']['c']['newer_than'],
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	)) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_forum_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
		'nodeTree' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__vars['nodeTree']) {
		$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
		if ($__templater->isTraversable($__compilerTemp2)) {
			foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
				if ($__vars['treeEntry']['record']['node_type_id'] == 'Forum') {
					$__compilerTemp1[] = array(
						'value' => $__vars['treeEntry']['record']['node_id'],
						'selected' => (($__vars['treeEntry']['record']['title'] == $__vars['question']['defanswer']) ? true : false),
						'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
						'_type' => 'option',
					);
				} else {
					$__compilerTemp1[] = array(
						'value' => $__vars['treeEntry']['record']['node_id'],
						'disabled' => 'disabled',
						'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formSelect(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => '',
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_wisywig' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formEditor(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => $__vars['question']['defanswer'],
		'placeholder' => $__vars['question']['placeholder'],
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	)) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_spinbox' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['formData'] = $__templater->preEscaped('
		' . $__templater->formNumberBox(array(
		'name' => 'question[' . $__vars['question']['questionid'] . ']',
		'value' => ($__vars['question']['defanswer'] ? $__vars['question']['defanswer'] : 0),
		'min' => '0',
		'step' => ($__vars['question']['expected'] ? $__vars['question']['expected'] : 1),
		'readonly' => (!$__vars['canSubmit']),
		'required' => ($__vars['question']['error'] ? 'required' : ''),
	)) . '
	');
	$__finalCompiled .= '
	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('
			' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => 'input',
			'rowclass' => 'formRow--noColon',
			'label' => $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true),
			'explain' => $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true),
			'hint' => ($__vars['question']['error'] ? 'Required' : ''),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		<div class="menu-row">
			<label>' . $__templater->func('bb_code', array($__vars['question']['text'], '', '', ), true) . '</label>
			<div class="u-inputSpacer">' . $__templater->filter($__vars['formData'], array(array('raw', array()),), true) . '</div>
			<label class="u-muted">' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
			<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'type_prefix' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'form' => '!',
		'question' => '!',
		'canSubmit' => '!',
		'row' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['prefixes'] = ($__vars['form']['Forum'] ? $__templater->method($__vars['form']['Forum'], 'getUsablePrefixes', array()) : null);
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['prefixes'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->func('is_addon_active', array('SV/MultiPrefix', ), false)) {
			$__finalCompiled .= '
			';
			if ($__vars['row']) {
				$__finalCompiled .= '
				' . $__templater->callMacro(null, 'form_row', array(
					'name' => 'question[' . $__vars['question']['questionid'] . ']',
					'selected' => ($__vars['form']['prefix_ids'] ? $__vars['form']['prefix_ids'] : array(0, )),
					'explain' => $__vars['question']['description'],
					'label' => $__vars['question']['text'],
					'prefixes' => $__vars['prefixes'],
					'type' => 'thread',
					'multiple' => 'true',
					'hint' => ($__vars['question']['error'] ? 'Required' : ''),
					'readOnly' => (!$__vars['canSubmit']),
				), $__vars) . '
			';
			} else {
				$__finalCompiled .= '
				<div class="menu-row">
					<label>' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
					<div class="u-inputSpacer">
						' . $__templater->callMacro(null, 'form_select', array(
					'prefixes' => $__vars['prefixes'],
					'type' => 'thread',
					'selected' => ($__vars['form']['prefix_ids'] ? $__vars['form']['prefix_ids'] : array(0, )),
					'name' => 'question[' . $__vars['question']['questionid'] . ']',
					'multiple' => 'true',
					'readOnly' => (!$__vars['canSubmit']),
				), $__vars) . '
					</div>
					<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
				</div>
			';
			}
			$__finalCompiled .= '
		';
		} else {
			$__finalCompiled .= '
			';
			if ($__vars['row']) {
				$__finalCompiled .= '
				' . $__templater->callMacro(null, 'form_row', array(
					'name' => 'question[' . $__vars['question']['questionid'] . ']',
					'selected' => ($__vars['form']['prefix_ids'] ? $__templater->filter($__vars['form']['prefix_ids'], array(array('first', array()),), false) : 0),
					'explain' => $__vars['question']['description'],
					'label' => $__vars['question']['text'],
					'prefixes' => $__vars['prefixes'],
					'type' => 'thread',
					'hint' => ($__vars['question']['error'] ? 'Required' : ''),
					'readOnly' => (!$__vars['canSubmit']),
				), $__vars) . '
			';
			} else {
				$__finalCompiled .= '
				<div class="menu-row">
					<label>' . $__templater->filter($__vars['question']['description'], array(array('raw', array()),), true) . '</label>
					<div class="u-inputSpacer">
						' . $__templater->callMacro(null, 'form_select', array(
					'prefixes' => $__vars['prefixes'],
					'type' => 'thread',
					'selected' => ($__vars['form']['prefix_ids'] ? $__templater->filter($__vars['form']['prefix_ids'], array(array('first', array()),), false) : 0),
					'name' => 'question[' . $__vars['question']['questionid'] . ']',
					'readOnly' => (!$__vars['canSubmit']),
				), $__vars) . '
					</div>
					<label class="u-muted">' . ($__vars['question']['error'] ? 'Required' : '') . '</label>
				</div>
			';
			}
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'form_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'selected' => '',
		'name' => 'prefix_id',
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'No prefix' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'class' => '',
		'href' => '',
		'listenTo' => '',
		'readOnly' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['includeAny']) {
		$__compilerTemp1[] = array(
			'value' => '-1',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => '0',
		'label' => $__templater->escape($__vars['noneLabel']),
		'_type' => 'option',
	);
	$__compilerTemp2 = $__templater->func('array_keys', array($__vars['prefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp1[] = array(
					'label' => $__templater->func('prefix_group', array($__vars['type'], $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['prefixes'][$__vars['groupId']])) {
					foreach ($__vars['prefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array($__vars['type'], $__vars['prefixId'], ), true),
							'data-prefix-class' => $__vars['prefix']['css_class'],
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formSelect(array(
		'name' => $__vars['name'],
		'value' => $__vars['selected'],
		'multiple' => $__vars['multiple'],
		'class' => $__vars['class'],
		'data-xf-init' => (($__vars['href'] AND $__vars['listenTo']) ? 'prefix-loader' : ''),
		'data-href' => $__vars['href'],
		'data-listen-to' => $__vars['listenTo'],
		'title' => $__templater->filter('Prefix', array(array('for_attr', array()),), false),
		'readonly' => $__vars['readOnly'],
	), $__compilerTemp1) . '
';
	return $__finalCompiled;
}
),
'form_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'prefixes' => '!',
		'type' => '!',
		'label' => 'Prefix',
		'explain' => '',
		'selected' => '',
		'name' => 'prefix_id',
		'hint' => '',
		'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'multiple' => false,
		'includeAny' => false,
		'class' => '',
		'readOnly' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['explain']) {
		$__compilerTemp1 .= '
			<div class="formRow-explain">' . $__templater->filter($__vars['explain'], array(array('raw', array()),), true) . '</div>
		';
	}
	$__finalCompiled .= $__templater->formRow('
		' . $__templater->callMacro(null, 'form_select', array(
		'prefixes' => $__vars['prefixes'],
		'type' => $__vars['type'],
		'selected' => $__vars['selected'],
		'name' => $__vars['name'],
		'noneLabel' => $__vars['noneLabel'],
		'multiple' => $__vars['multiple'],
		'includeAny' => $__vars['includeAny'],
		'class' => $__vars['class'],
		'readOnly' => $__vars['readOnly'],
	), $__vars) . '
		' . $__compilerTemp1 . '
	', array(
		'rowtype' => 'input noColon',
		'label' => $__templater->escape($__vars['label']),
		'hint' => ($__vars['hint'] ? 'Required' : ''),
	)) . '
';
	return $__finalCompiled;
}
),
'conditional_questions' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'question' => '!',
		'questions' => '!',
		'attachmentData' => '',
		'forum' => '',
		'conditionQuestions' => '',
		'readOnly' => '',
		'row' => true,
		'nodeTree' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['current'] = '0';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['conditionQuestions'])) {
		foreach ($__vars['conditionQuestions'] AS $__vars['keyquestion'] => $__vars['conditionQuestion']) {
			$__finalCompiled .= '
		';
			if ($__vars['keyquestion'] == $__vars['question']['questionid']) {
				$__finalCompiled .= '
			';
				if ($__templater->isTraversable($__vars['conditionQuestion'])) {
					foreach ($__vars['conditionQuestion'] AS $__vars['condition']) {
						$__finalCompiled .= '
				';
						if ($__vars['current'] !== $__vars['condition']['answer']) {
							$__finalCompiled .= '
					';
							if ($__vars['current']) {
								$__finalCompiled .= '
						</div>
					';
							}
							$__finalCompiled .= '

					<div id="conditional' . $__templater->escape($__vars['question']['questionid']) . '-' . $__templater->escape($__vars['condition']['answer']) . '">
					';
							$__vars['current'] = $__vars['condition']['answer'];
							$__finalCompiled .= '
				';
						}
						$__finalCompiled .= '

				';
						if ($__templater->isTraversable($__vars['questions'])) {
							foreach ($__vars['questions'] AS $__vars['hiddenquestion']) {
								$__finalCompiled .= '
					';
								if ($__vars['hiddenquestion']['questionid'] == $__vars['condition']['questionid']) {
									$__finalCompiled .= '
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 1) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_text', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
		
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 2) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_text_multi', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 3) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_yes_no', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'conditionQuestions' => $__vars['conditionQuestions'][$__vars['hiddenquestion']['questionid']],
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 4) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_radio', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'conditionQuestions' => $__vars['conditionQuestions'][$__vars['hiddenquestion']['questionid']],
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if (($__vars['hiddenquestion']['type'] == 5) OR ($__vars['hiddenquestion']['type'] == 8)) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_checkboxes', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'conditionQuestions' => $__vars['conditionQuestions'][$__vars['hiddenquestion']['questionid']],
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 6) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_header', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 7) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_select', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'conditionQuestions' => $__vars['conditionQuestions'][$__vars['hiddenquestion']['questionid']],
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 9) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_agreement', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
			
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 10) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_file_upload', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'noupload' => $__vars['noupload'],
											'attachmentData' => $__vars['attachmentData'],
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
			
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 11) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_date_input', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 12) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_forum_select', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
											'nodeTree' => $__vars['nodeTree'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
			
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 13) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_wisywig', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
			
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 14) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_spinbox', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
			
						' . '
						';
									if ($__vars['hiddenquestion']['type'] == 15) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'type_prefix', array(
											'form' => $__vars['form'],
											'question' => $__vars['hiddenquestion'],
											'canSubmit' => '{canSubmit}',
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '

						';
									if ($__vars['hiddenquestion']['hasconditional']) {
										$__finalCompiled .= '
							' . $__templater->callMacro(null, 'conditional_questions', array(
											'question' => $__vars['hiddenquestion'],
											'questions' => $__vars['questions'],
											'attachmentData' => $__vars['attachmentData'],
											'forum' => $__vars['forum'],
											'conditionQuestions' => $__vars['conditionQuestions'],
											'readOnly' => (!$__vars['canSubmit']),
											'row' => $__vars['row'],
										), $__vars) . '
						';
									}
									$__finalCompiled .= '
					';
								}
								$__finalCompiled .= '
				';
							}
						}
						$__finalCompiled .= '
			';
					}
				}
				$__finalCompiled .= '
			';
				if ($__vars['current']) {
					$__finalCompiled .= '
				</div>
			';
				}
				$__finalCompiled .= '
		';
			}
			$__finalCompiled .= '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);