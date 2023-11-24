<?php
// FROM HASH: f5c6c0496c6fd1eb7cf914ac810adc7a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['trophies'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->includeTemplate('thuserimprovements_help_page_trophies', $__vars);
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);