<?php
// FROM HASH: 0c9916e5990f221f53534b87aa760e59
return array(
'macros' => array('delete' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'object' => '!',
		'idKey' => 'quiz_id',
	); },
'global' => true,
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= ' 
	';
	$__vars['quiz'] = $__vars['object'];
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if (!$__vars['quiz']['quiz_id']) {
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
							' . $__templater->escape($__vars['quiz']['quiz_name']) . '
						</h2>
					</strong>
				', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
			' . $__templater->formSubmitRow(array(
		'submit' => ((!$__vars['quiz']['quiz_id']) ? 'Revert' : 'Delete'),
		'icon' => ($__vars['quiz']['quiz_id'] ? 'delete' : ''),
	), array(
		'rowtype' => 'simple',
	)) . '
		</div>
		' . $__templater->func('redirect_input', array(null, null, true)) . '
	', array(
		'action' => $__templater->func('link', array('quiz/delete', $__vars['quiz'], ), false),
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