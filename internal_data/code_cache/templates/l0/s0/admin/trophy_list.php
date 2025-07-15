<?php
// FROM HASH: fcdbd2110fcce1017970d3017de4c295
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Trophies');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add trophy', array(
		'href' => $__templater->func('link', array('trophies/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
' . $__templater->button('Add trophy category', array(
		'href' => $__templater->func('link', array('trophies/thui-category/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['trophies'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->includeTemplate('thuserimprovements_trophy_list', $__vars);
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No trophies have been created yet.' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('option_macros', 'option_form_block', array(
		'options' => $__vars['options'],
	), $__vars) . '

' . $__templater->includeTemplate('thuserimprovements_trophy_list_reward', $__vars);
	return $__finalCompiled;
}
);