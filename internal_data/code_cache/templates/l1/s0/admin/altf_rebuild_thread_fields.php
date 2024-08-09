<?php
// FROM HASH: ae83963ed3708f39bc53bddf5da93d06
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['threadFieldBody'] = $__templater->preEscaped('
');
	$__finalCompiled .= '
' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Rebuild Thread Fields',
		'body' => $__vars['threadFieldBody'],
		'job' => 'AL\\ThreadFilter:ThreadField',
	), $__vars);
	return $__finalCompiled;
}
);