<?php
// FROM HASH: 2f8e04ad5e8ad58880222f26bcf59516
return array(
'macros' => array('position_select' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'entity' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['positionData'] = $__templater->method($__vars['xf']['samAdmin'], 'getPositionData', array());
	$__finalCompiled .= '
	';
	$__vars['categories'] = $__vars['positionData']['positionCategories'];
	$__finalCompiled .= '

	';
	$__templater->inlineCss('
		.positionCategoryList
		{
			list-style-type: none;
			margin: 0 0 10px 0;
			padding: 0;
		}
		.positionCategoryList > li
		{
			display: inline;
			margin-right: 10px;
			font-weight: bold;
			cursor: pointer;
			font-size: 12px;
		}
	');
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['categoryId'] => $__vars['category']) {
			if ($__templater->func('count', array($__vars['positionData']['positions'][$__vars['categoryId']], ), false)) {
				$__compilerTemp1 .= '
				<li><a role="button" data-id="' . $__templater->escape($__vars['categoryId']) . '">' . $__templater->filter($__vars['category']['title'], array(array('replace', array(' positions', '', )),), true) . '</a></li>
			';
			}
		}
	}
	$__compilerTemp2 = '';
	if ($__templater->filter($__templater->func('count', array($__vars['positionData']['positions']['0'], ), false), array(array('number', array()),), false)) {
		$__compilerTemp2 .= '
				<li><a role="button" data-id="0">' . 'Uncategorized positions' . '</a></li>
			';
	}
	$__compilerTemp3 = array();
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['categoryId'] => $__vars['category']) {
			$__vars['positionCount'] = $__templater->filter($__templater->func('count', array($__vars['positionData']['positions'][$__vars['categoryId']], ), false), array(array('number', array()),), false);
			$__compilerTemp3[] = array(
				'label' => ($__vars['categoryId'] ? $__vars['category']['title'] : 'Uncategorized positions') . ' (' . $__vars['positionCount'] . ')',
				'data-id' => $__vars['categoryId'],
				'_type' => 'optgroup',
				'options' => array(),
			);
			end($__compilerTemp3); $__compilerTemp4 = key($__compilerTemp3);
			if ($__templater->isTraversable($__vars['positionData']['positions'][$__vars['categoryId']])) {
				foreach ($__vars['positionData']['positions'][$__vars['categoryId']] AS $__vars['positionId'] => $__vars['position']) {
					$__compilerTemp3[$__compilerTemp4]['options'][] = array(
						'value' => $__vars['positionId'],
						'label' => $__templater->escape($__vars['position']['title']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formRow('		
		<ul class="positionCategoryList" data-xf-init="siropu-ads-manager-position-categories">
			<li><a class="is-active" role="button" data-id="-1">' . 'All' . '</a></li>
			' . $__compilerTemp1 . '
			' . $__compilerTemp2 . '
		</ul>
		' . $__templater->formSelect(array(
		'name' => 'position',
		'value' => $__vars['entity']['position'],
		'size' => '10',
		'multiple' => 'true',
		'class' => 'js-positions',
	), $__compilerTemp3) . '
		' . $__templater->formTextBox(array(
		'name' => 'search',
		'placeholder' => 'Type to find positions...',
		'style' => 'margin-top: 5px;',
		'data-xf-init' => 'siropu-ads-manager-find-position',
		'autocomplete' => 'off',
	)) . '
	', array(
		'label' => 'Position',
		'explain' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
	)) . '

	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'checked' => ($__vars['entity']['settings']['randomize_display'] > 0),
		'label' => 'Randomize display',
		'data-hide' => 'true',
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'settings[randomize_display]',
		'value' => $__vars['entity']['settings']['randomize_display'],
		'min' => '1',
	))),
		'_type' => 'option',
	)), array(
		'explain' => 'If more than one position is selected, this option allows you to display the ad randomly in one or more positions, based on the position limit set.',
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