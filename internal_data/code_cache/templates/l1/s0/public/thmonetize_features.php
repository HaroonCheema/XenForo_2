<?php
// FROM HASH: d857cecf68851a5d1c6124ce77b06ee0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('thmonetize_upgrade_page_macros', 'features', array(
		'features' => $__vars['upgrade']['thmonetize_features'],
		'upgrade' => $__vars['upgrade'],
		'styleProperties' => $__vars['upgrade']['thmonetize_style_properties'],
	), $__vars);
	return $__finalCompiled;
}
);