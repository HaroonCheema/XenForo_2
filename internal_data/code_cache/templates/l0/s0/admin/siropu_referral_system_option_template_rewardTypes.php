<?php
// FROM HASH: 0afc61917bebf037f1139acc37c23e1a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['rewardTypes']);
	$__finalCompiled .= $__templater->formRow('

	' . $__templater->formSelect(array(
		'name' => $__vars['inputName'],
		'value' => $__vars['option']['option_value'],
		'class' => 'input--autoSize',
	), $__compilerTemp1) . '
', array(
		'rowtype' => 'input',
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
		'label' => $__templater->escape($__vars['option']['title']),
	));
	return $__finalCompiled;
}
);