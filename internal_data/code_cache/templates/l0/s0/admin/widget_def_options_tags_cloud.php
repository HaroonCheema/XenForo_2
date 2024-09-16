<?php
// FROM HASH: ae9e43b922a44d68579dc1f3de5d1811
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['tagCategories']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[category_ids]',
		'value' => $__vars['options']['category_ids'],
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp1, array(
		'label' => 'Tag category',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['option']['limit'],
		'min' => '25',
		'step' => '10',
	), array(
		'label' => 'Limit',
		'explain' => 'how many tags will be shown for the tags cloud widget',
	));
	return $__finalCompiled;
}
);