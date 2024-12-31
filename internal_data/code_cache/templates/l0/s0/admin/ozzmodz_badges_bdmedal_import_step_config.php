<?php
// FROM HASH: d2edb1d30188897193ef1c6102f54e33
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'step_config[badges][only_large_icons]',
		'value' => '1',
		'checked' => $__vars['stepConfig']['badges']['only_large_icons'],
		'label' => 'Import only large icons',
		'hint' => 'Check this option if you want to import only large variants of badge images.',
		'_type' => 'option',
	)), array(
	));
	return $__finalCompiled;
}
);