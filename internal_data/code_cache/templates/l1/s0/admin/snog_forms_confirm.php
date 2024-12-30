<?php
// FROM HASH: 181558c87882aa3cc9d4ed4738cada6e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	if ($__vars['type']) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array('form-types/edit', $__vars['type'], ), true) . '">[' . $__templater->escape($__vars['type']['type']) . ']</a></strong>
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'delete',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form-types/delete', $__vars['type'], ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['form']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__vars['form']['store'] > 0) {
			$__compilerTemp1 .= '
						<br />' . 'You are saving the answers to questions for this form in the database, they will be deleted if you delete this form.' . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array('form-forms/edit', $__vars['form'], ), true) . '">[' . $__templater->escape($__vars['form']['position']) . ']</a></strong>
					' . $__compilerTemp1 . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'delete',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form-forms/delete', $__vars['form'], ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['question']) {
		$__finalCompiled .= '
		';
		$__compilerTemp2 = '';
		if ($__vars['question']['posid'] > 0) {
			$__compilerTemp2 .= '
						<br />' . 'If there are conditional questions attached to this question, they will also be deleted.<br />If you are saving answers for this form to the database, answers to this question will also be deleted.' . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array('form-questions/edit', $__vars['question'], ), true) . '">[' . $__templater->escape($__vars['question']['text']) . ']</a></strong>
					' . $__compilerTemp2 . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'delete',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form-questions/delete', $__vars['question'], ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['reset']) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to reset all user counts for this form' . '
					<strong><a href="' . $__templater->func('link', array('form-forms/edit', $__vars['reset'], ), true) . '">[' . $__templater->escape($__vars['reset']['position']) . ']</a></strong>
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'refresh',
			'submit' => 'Reset',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form-forms/reset', $__vars['reset'], ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['resetone']) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please enter the name of the user to reset the counts for this form' . '
					<strong><a href="' . $__templater->func('link', array('form-forms/edit', $__vars['resetone'], ), true) . '">[' . $__templater->escape($__vars['resetone']['position']) . ']</a></strong>
				', array(
			'rowtype' => 'confirm',
		)) . '
				' . $__templater->formTextBoxRow(array(
			'name' => 'resetuser',
			'value' => '',
			'type' => 'search',
			'ac' => 'single',
			'placeholder' => 'Username' . $__vars['xf']['language']['ellipsis'],
		), array(
			'label' => 'Reset user name',
			'explain' => 'Enter the user name of the user you want to reset the form count for',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'refresh',
			'submit' => 'Reset',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form-forms/resetone', $__vars['resetone'], ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	return $__finalCompiled;
}
);