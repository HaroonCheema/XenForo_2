<?php
// FROM HASH: 6c9c31dfe698b669c3429be888ecf0c1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['avatarBody'] = $__templater->preEscaped('
	
	' . $__templater->formSelectRow(array(
		'name' => 'options[type]',
	), array(array(
		'value' => '1',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'All' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Only have not Avatar' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	)), array(
		'label' => 'Rebuild Type',
	)) . '
');
	$__finalCompiled .= '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Gallery Avatar',
		'body' => $__vars['avatarBody'],
		'job' => 'FS\\AvatarGallery:UserAvatar',
	), $__vars);
	return $__finalCompiled;
}
);