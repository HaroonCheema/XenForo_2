<?php
// FROM HASH: 5099c1efc4a04f3db6e755efd50c9214
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => '( ' . 'unspecified' . ' )',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['category']['category_id'],
				'label' => $__templater->escape($__vars['category']['category_name']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[category]',
		'value' => $__vars['options']['category'],
	), $__compilerTemp1, array(
		'label' => 'Category',
	)) . '

';
	$__compilerTemp2 = array(array(
		'value' => '',
		'label' => '( ' . 'unspecified' . ' )',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['authors'])) {
		foreach ($__vars['authors'] AS $__vars['author']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['author']['user_id'],
				'label' => $__templater->escape($__vars['author']['author_name']) . ' (' . $__templater->escape($__vars['author']['User']->{'username'}) . ')',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[author]',
		'value' => $__vars['options']['author'],
	), $__compilerTemp2, array(
		'label' => 'Author',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[masonry]',
		'selected' => $__vars['options']['masonry'],
		'label' => '
		' . 'Enable masonry grid' . '
	',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);