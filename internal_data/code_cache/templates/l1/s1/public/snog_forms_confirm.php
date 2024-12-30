<?php
// FROM HASH: a9b96cc8a53b01034c7d29394829d97f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	if ($__vars['deny']) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__vars['deny']['poll_id']) {
			$__compilerTemp1 .= '
						' . 'This action will also close the poll' . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to deny:' . '
					<strong>' . $__templater->escape($__vars['title']) . '</strong>
					' . $__compilerTemp1 . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'submit' => 'Deny',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form/deny', array('posid' => $__vars['deny']['post_id'], ), ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['approve']) {
		$__finalCompiled .= '
	';
		$__compilerTemp2 = '';
		if ($__vars['approve']['poll_id']) {
			$__compilerTemp2 .= '
						' . 'This action will also close the poll' . '
					';
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to approve:' . '
					<strong>' . $__templater->escape($__vars['title']) . '</strong>
					' . $__compilerTemp2 . '
				', array(
			'rowtype' => 'confirm',
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'submit' => 'Approve',
		), array(
			'rowtype' => 'simple',
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('form/approve', array('posid' => $__vars['approve']['post_id'], ), ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
';
	}
	return $__finalCompiled;
}
);