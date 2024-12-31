<?php
// FROM HASH: e1a44a3bf98a535e10cd52d262615ca6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['badges'] = $__templater->method($__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('OzzModz\\Badges:Badge', )), 'findBadgesForList', array()), 'fetch', array());
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['badges'])) {
		foreach ($__vars['badges'] AS $__vars['badge']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['badge']['badge_id'],
				'label' => $__templater->escape($__vars['badge']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'settings[badge][]',
		'multiple' => 'true',
		'size' => '8',
		'value' => ($__vars['event']['settings']['badge'] ? $__vars['event']['settings']['badge'] : array()),
	), $__compilerTemp1, array(
		'label' => 'Badges',
	));
	return $__finalCompiled;
}
);