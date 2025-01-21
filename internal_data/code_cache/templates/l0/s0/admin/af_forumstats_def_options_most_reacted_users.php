<?php
// FROM HASH: 6f76674d1717e6478bf4bce77d7b283b
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

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[rich_usernames]',
		'selected' => $__vars['options']['rich_usernames'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Rich Usernames',
	));
	return $__finalCompiled;
}
);