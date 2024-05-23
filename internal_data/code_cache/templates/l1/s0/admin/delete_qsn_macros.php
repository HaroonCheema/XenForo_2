<?php
// FROM HASH: 95582a861485de56ec4f2dda16f428a2
return array(
'macros' => array('delete' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'object' => '!',
		'idKey' => 'question_id',
	); },
'global' => true,
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= ' 
	';
	$__vars['question'] = $__vars['object'];
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if (!$__vars['question']['question_id']) {
		$__compilerTemp1 .= '
						' . 'Please confirm that you want to revert the changes made to the following' . $__vars['xf']['language']['label_separator'] . '
					';
	} else {
		$__compilerTemp1 .= '
						' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . $__compilerTemp1 . '
					<strong>
						<h2>
							' . $__templater->escape($__vars['object']['question_title']) . '
						</h2>
					</strong>
				', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
			' . $__templater->formSubmitRow(array(
		'submit' => ((!$__vars['question']['question_id']) ? 'Revert' : 'Delete'),
		'icon' => ($__vars['question']['question_id'] ? 'delete' : ''),
	), array(
		'rowtype' => 'simple',
	)) . '
		</div>
		' . $__templater->func('redirect_input', array(null, null, true)) . '
	', array(
		'action' => $__templater->func('link', array('quiz-qsn/delete', $__vars['question'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	)) . '


';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);