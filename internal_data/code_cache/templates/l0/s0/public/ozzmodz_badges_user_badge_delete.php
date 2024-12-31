<?php
// FROM HASH: 4a3903e9df9bc967a629d656030d9ac2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['userBadge']['Badge'] AND $__vars['userBadge']['Badge']['user_criteria']) {
		$__compilerTemp1 .= '
			' . $__templater->formInfoRow('
				<p class="block-rowMessage block-rowMessage--warning block-rowMessage--iconic">
					<strong>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</strong>
					' . 'This badge has a user criteria and will be automatically awarded again if the criteria is met.' . '
				</p>
			', array(
		)) . '
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want delete following user badge' . $__vars['xf']['language']['label_separator'] . '
				<strong><a href="' . $__templater->func('link', array('members', $__vars['user'], ), true) . '">' . $__templater->escape($__templater->method($__vars['userBadge'], 'getContentTitle', array())) . '</a></strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		
		' . $__compilerTemp1 . '

		' . $__templater->formSubmitRow(array(
		'name' => 'delete',
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('user-badges/delete', $__vars['userBadge'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);