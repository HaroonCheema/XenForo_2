<?php
// FROM HASH: 5506d0cb3feee4f7c8afdc0587ac8681
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['prefixes'] = $__templater->method($__vars['forum'], 'getUsablePrefixes', array());
	$__finalCompiled .= '
';
	if ($__vars['prefixes']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/prefix_menu.js',
			'min' => '1',
		));
		$__finalCompiled .= $__templater->formRow('
		' . '' . '
		' . $__templater->callMacro('public:prefix_macros', 'select', array(
			'type' => 'thread',
			'prefixes' => $__vars['prefixes'],
			'selected' => $__vars['forum']['sv_default_prefix_ids'],
			'name' => 'prefix_id[]',
			'contentParent' => $__vars['forum'],
		), $__vars) . '
	', array(
			'rowtype' => 'input fullWidth noLabel noGutter',
		)) . '
';
	}
	return $__finalCompiled;
}
);