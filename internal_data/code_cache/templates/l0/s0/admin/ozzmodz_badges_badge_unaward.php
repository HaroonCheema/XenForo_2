<?php
// FROM HASH: 48c23bfd2732b7e08fbc32238839b5d4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Take away badge');
	$__finalCompiled .= '

';
	if ($__vars['unawarded']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--success blockMessage--iconic">
		' . 'You successfully unawarded ' . $__templater->filter($__vars['unawarded'], array(array('number', array()),), true) . ' users. ' . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->func('count', array($__vars['badgeData']['badges'], ), false) > 0) {
		$__compilerTemp1 .= '
					';
		$__compilerTemp2 = array();
		if ($__templater->isTraversable($__vars['badgeData']['badgeCategories'])) {
			foreach ($__vars['badgeData']['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
				$__compilerTemp2[] = array(
					'label' => (($__vars['catId'] == 0) ? 'Uncategorized' : $__vars['category']['title']),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp2); $__compilerTemp3 = key($__compilerTemp2);
				if ($__templater->isTraversable($__vars['badgeData']['badges'][$__vars['catId']])) {
					foreach ($__vars['badgeData']['badges'][$__vars['catId']] AS $__vars['badge']) {
						$__compilerTemp2[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['badge']['badge_id'],
							'label' => $__templater->escape($__vars['badge']['title']),
							'_type' => 'option',
						);
					}
				}
			}
		}
		$__compilerTemp1 .= $__templater->formSelect(array(
			'name' => 'badge_ids',
			'multiple' => 'true',
		), $__compilerTemp2) . '
				';
	} else {
		$__compilerTemp1 .= '
					' . 'No badges available' . '
				';
	}
	$__vars['noOzzModzBadges'] = true;
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__compilerTemp1 . '
			', array(
		'name' => 'badge_ids',
		'label' => 'Badges',
		'explain' => 'The badges with a user criteria will be automatically awarded again if the criteria is met.',
	)) . '

		</div>

		<h2 class="block-formSectionHeader"><span class="block-formSectionHeader-aligner">' . 'User criteria' . '</span></h2>
		<div class="block-body">
			' . '' . '
			' . $__templater->includeTemplate('helper_user_search_criteria', $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges/unaward/confirm', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);