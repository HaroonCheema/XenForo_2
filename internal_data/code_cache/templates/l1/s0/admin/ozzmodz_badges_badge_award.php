<?php
// FROM HASH: 8d00266ce70dbf2b79728fcf381a5317
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Award with badge');
	$__finalCompiled .= '

';
	if ($__vars['awarded']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">
		' . 'You successfully awarded ' . $__templater->filter($__vars['awarded'], array(array('number', array()),), true) . ' users. ' . '
	</div>
';
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_chooser', array(
		'name' => 'badge_id',
		'badgeData' => $__vars['ozzModzBadges'],
		'multiple' => false,
		'includeEmpty' => false,
		'label' => 'Badge',
	), $__vars) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'reason',
		'maxlength' => $__vars['xf']['options']['ozzmodz_badges_awardReasonMaxLength'],
	), array(
		'label' => 'Reason',
		'hint' => ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml'] ? 'You may use HTML' : ''),
	)) . '

			' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'avoid_duplicates',
		'value' => '1',
		'label' => '
                    ' . 'Avoid duplicates' . '
                ',
		'_type' => 'option',
	)), array(
	)) . '

		</div>

		<h2 class="block-formSectionHeader"><span class="block-formSectionHeader-aligner">' . 'User criteria' . '</span></h2>
		<div class="block-body">
			' . $__templater->includeTemplate('helper_user_search_criteria', $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/award/confirm', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);