<?php
// FROM HASH: 7916cd348229c30200acfc8852fc5229
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm awarding users');
	$__finalCompiled .= '

' . $__templater->form('
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
		'submit' => 'Award',
	), array(
	)) . '
	</div>

	' . $__templater->formHiddenVal('json_criteria', $__templater->filter($__vars['criteria'], array(array('json', array()),), false), array(
	)) . '

	' . $__templater->formHiddenVal('total', $__vars['total'], array(
	)) . '

	' . $__templater->formHiddenVal('badge_id', $__vars['badge']['badge_id'], array(
	)) . '
	
	' . $__templater->formHiddenVal('reason', $__vars['input']['reason'], array(
	)) . '
	' . $__templater->formHiddenVal('avoid_duplicates', $__vars['input']['avoid_duplicates'], array(
	)) . '
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/award/submit', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);