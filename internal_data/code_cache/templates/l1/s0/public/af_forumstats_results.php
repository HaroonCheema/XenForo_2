<?php
// FROM HASH: f7c5b978d553282c51c99934d18ca0c7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['forumStat']['position'] == 'left') {
		$__finalCompiled .= '
    <div class="js-forumStatsSidebar">
';
	}
	$__finalCompiled .= '

' . $__templater->filter($__templater->method($__vars['forumStat'], 'render', array()), array(array('raw', array()),), true) . '

';
	if ($__vars['forumStat']['position'] == 'left') {
		$__finalCompiled .= '
    </div>
';
	}
	return $__finalCompiled;
}
);