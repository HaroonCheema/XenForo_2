<?php
// FROM HASH: a825bae700e95f925591b24b48109253
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'user_criteria[ozzmodz_badges_badge_count][rule]',
		'value' => 'ozzmodz_badges_badge_count',
		'selected' => $__vars['criteria']['ozzmodz_badges_badge_count'],
		'label' => 'User has at least X badges' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'user_criteria[ozzmodz_badges_badge_count][data][badges]',
		'value' => $__vars['criteria']['ozzmodz_badges_badge_count']['badges'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'user_criteria[ozzmodz_badges_badge_count_max][rule]',
		'value' => 'ozzmodz_badges_badge_count_max',
		'selected' => $__vars['criteria']['ozzmodz_badges_badge_count_max'],
		'label' => 'User has no more than X badges' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'user_criteria[ozzmodz_badges_badge_count_max][data][badges]',
		'value' => $__vars['criteria']['ozzmodz_badges_badge_count_max']['badges'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'user_criteria[ozzmodz_badges_not_awarded_days][rule]',
		'value' => 'ozzmodz_badges_not_awarded_days',
		'selected' => $__vars['criteria']['ozzmodz_badges_not_awarded_days'],
		'label' => 'User has not been awarded with badge for at least X days' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'user_criteria[ozzmodz_badges_not_awarded_days][data][days]',
		'value' => $__vars['criteria']['ozzmodz_badges_not_awarded_days']['days'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'user_criteria[ozzmodz_badges_has_badge][rule]',
		'value' => 'ozzmodz_badges_has_badge',
		'selected' => $__vars['criteria']['ozzmodz_badges_has_badge'],
		'label' => 'User has the following badges' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_chooser', array(
		'name' => 'user_criteria[ozzmodz_badges_has_badge][data][badge_ids]',
		'value' => ($__templater->func('is_array', array($__vars['criteria']['ozzmodz_badges_has_badge']['badge_ids'], ), false) ? $__vars['criteria']['ozzmodz_badges_has_badge']['badge_ids'] : $__templater->filter($__vars['criteria']['ozzmodz_badges_has_badge']['badge_ids'], array(array('split', array(',', )),), false)),
		'badgeData' => $__vars['data']['ozzModzBadges'],
		'multiple' => true,
		'showEmpty' => false,
		'row' => false,
	), $__vars)),
		'_type' => 'option',
	),
	array(
		'name' => 'user_criteria[ozzmodz_badges_has_no_badge][rule]',
		'value' => 'ozzmodz_badges_has_no_badge',
		'selected' => $__vars['criteria']['ozzmodz_badges_has_no_badge'],
		'label' => 'User does NOT have the following badges' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_chooser', array(
		'name' => 'user_criteria[ozzmodz_badges_has_no_badge][data][badge_ids]',
		'value' => $__vars['criteria']['ozzmodz_badges_has_no_badge']['badge_ids'],
		'badgeData' => $__vars['data']['ozzModzBadges'],
		'multiple' => true,
		'showEmpty' => false,
		'row' => false,
	), $__vars)),
		'_type' => 'option',
	)), array(
		'label' => 'Badges',
	)) . '

<hr class="formRowSep" />';
	return $__finalCompiled;
}
);