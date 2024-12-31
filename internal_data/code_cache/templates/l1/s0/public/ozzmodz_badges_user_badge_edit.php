<?php
// FROM HASH: 43bf995321554838a9e669a0bf13e260
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit badge reason');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextAreaRow(array(
		'name' => 'reason',
		'autosize' => 'true',
		'value' => $__vars['userBadge']['reason'],
		'maxlength' => $__vars['xf']['options']['ozzmodz_badges_awardReasonMaxLength'],
	), array(
		'label' => 'Reason',
		'hint' => 'You may use HTML',
	)) . '
		</div>
		
		' . $__templater->formSubmitRow(array(
		'fa' => 'fa-edit',
		'submit' => 'Edit',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('user-badges/edit', $__vars['userBadge'], array('user_badge_id' => $__vars['userBadge']['user_badge_id'], ), ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);