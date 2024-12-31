<?php
// FROM HASH: bf4c60dec11163a7d800fa47efd9ac18
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Award with badge');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['badgeData']['badgeCategories'])) {
		foreach ($__vars['badgeData']['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
			$__compilerTemp1[] = array(
				'label' => (($__vars['catId'] == 0) ? 'Uncategorized' : $__vars['category']['title']),
				'_type' => 'optgroup',
				'options' => array(),
			);
			end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
			if ($__templater->isTraversable($__vars['badgeData']['badges'][$__vars['catId']])) {
				foreach ($__vars['badgeData']['badges'][$__vars['catId']] AS $__vars['badge']) {
					$__compilerTemp1[$__compilerTemp2]['options'][] = array(
						'value' => $__vars['badge']['badge_id'],
						'label' => $__templater->escape($__vars['badge']['title']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->formRow('
				' . $__templater->formSelect(array(
		'name' => 'badge_id',
	), $__compilerTemp1) . '
			', array(
		'name' => 'badge_id',
		'label' => 'Badge',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'reason',
		'autosize' => 'true',
		'maxlength' => $__vars['xf']['options']['ozzmodz_badges_awardReasonMaxLength'],
	), array(
		'label' => 'Reason',
		'hint' => ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml'] ? 'You may use HTML' : ''),
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'fa' => 'fa-medal',
		'submit' => 'Award',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('members/award-badge', $__vars['user'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);