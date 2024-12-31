<?php
// FROM HASH: d49b6ae280fb8a1762a600447bd52113
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm unawarding users');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['input']['badge_ids'])) {
		foreach ($__vars['input']['badge_ids'] AS $__vars['badgeId']) {
			$__compilerTemp1 .= '
		' . $__templater->formHiddenVal('badge_ids[]', $__vars['badgeId'], array(
			)) . '
	';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->filter($__vars['total'], array(array('number', array()),), true) . '
				<span role="presentation" aria-hidden="true">&middot;</span>
				<a href="' . $__templater->func('link', array('users/list', null, array('criteria' => $__vars['criteria'], ), ), true) . '">' . 'View full list' . '</a>
			', array(
		'label' => 'Number of users matching criteria',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Unaward',
	), array(
	)) . '
	</div>

	' . $__templater->formHiddenVal('json_criteria', $__templater->filter($__vars['criteria'], array(array('json', array()),), false), array(
	)) . '

	' . $__compilerTemp1 . '
	
	' . $__templater->formHiddenVal('total', $__vars['total'], array(
	)) . '
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/unaward/submit', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);