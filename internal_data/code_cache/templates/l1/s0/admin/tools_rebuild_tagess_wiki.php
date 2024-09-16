<?php
// FROM HASH: 5e7f4fa32c61543eb4f1d0a2d7747b08
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Rebuild Empty Wiki Tags',
		'job' => 'AVForums\\TagEssentials:WikiFixup',
	), $__vars) . '
';
	return $__finalCompiled;
}
);