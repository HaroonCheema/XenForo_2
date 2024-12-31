<?php
// FROM HASH: 2b9c3f82528f7046fa7b58893f9b4290
return array(
'macros' => array('badge_chooser' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'name' => '!',
		'badgeData' => '!',
		'value' => '',
		'multiple' => false,
		'label' => '',
		'hint' => '',
		'explain' => '',
		'html' => '',
		'row' => true,
		'rowClass' => '',
		'rowtype' => '',
		'required' => false,
		'includeEmpty' => true,
		'emptyLabel' => '',
		'controlId' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	
	';
	if ($__vars['row'] AND (!$__vars['controlId'])) {
		$__finalCompiled .= '
		';
		$__vars['controlId'] = $__templater->func('unique_id', array(), false);
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array();
	if ($__vars['includeEmpty']) {
		$__compilerTemp1[] = array(
			'value' => '0',
			'label' => ($__templater->escape($__vars['emptyLabel']) ?: $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close']),
			'_type' => 'option',
		);
	}
	$__compilerTemp2 = $__templater->func('array_keys', array($__vars['badgeData'], ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['badgeGroupId']) {
			if ($__vars['badgeData'][$__vars['badgeGroupId']]['options']) {
				$__compilerTemp1[] = array(
					'label' => $__vars['badgeData'][$__vars['badgeGroupId']]['label'],
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['badgeData'][$__vars['badgeGroupId']]['options'])) {
					foreach ($__vars['badgeData'][$__vars['badgeGroupId']]['options'] AS $__vars['badgeId'] => $__vars['badge']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['badgeId'],
							'label' => $__templater->escape($__vars['badge']['label']),
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__vars['badges'] = $__templater->preEscaped('
		' . $__templater->formSelect(array(
		'name' => $__vars['name'],
		'multiple' => $__vars['multiple'],
		'value' => $__vars['value'],
	), $__compilerTemp1) . '
	');
	$__finalCompiled .= '

	';
	if ($__vars['row']) {
		$__finalCompiled .= '
		' . $__templater->formRow('

			' . $__templater->filter($__vars['badges'], array(array('raw', array()),), true) . '
		', array(
			'rowtype' => $__vars['rowtype'],
			'rowclass' => 'formRow--input ' . $__vars['rowClass'],
			'controlid' => $__vars['controlId'],
			'label' => $__templater->escape($__vars['label']),
			'hint' => $__templater->escape($__vars['hint']),
			'explain' => $__templater->escape($__vars['explain']),
			'html' => $__templater->escape($__vars['html']),
		)) . '
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['badges'], array(array('raw', array()),), true) . '
	';
	}
	$__finalCompiled .= '

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