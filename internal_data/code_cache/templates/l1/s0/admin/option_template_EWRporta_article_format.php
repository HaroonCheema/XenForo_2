<?php
// FROM HASH: f5beec7a35f91340c282867d36fadee1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[article]',
		'value' => '1',
		'selected' => $__vars['option']['option_value']['article'],
		'label' => 'Enable custom article layout',
		'_dependent' => array($__templater->formCheckBox(array(
	), array(array(
		'name' => $__vars['inputName'] . '[comments]',
		'value' => '1',
		'selected' => $__vars['option']['option_value']['comments'],
		'label' => 'Enable simple comments',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['inputName'] . '[author]',
		'value' => '1',
		'selected' => $__vars['option']['option_value']['author'],
		'label' => 'Show author byline block',
		'_type' => 'option',
	),
	array(
		'name' => $__vars['inputName'] . '[attach]',
		'value' => '1',
		'selected' => $__vars['option']['option_value']['attach'],
		'label' => 'Show attachment gallery',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);