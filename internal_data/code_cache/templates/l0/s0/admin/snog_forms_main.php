<?php
// FROM HASH: 627c783fd2810ff6e429bf40ffadf80a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Advanced Forms');
	$__finalCompiled .= '

' . $__templater->callMacro('section_nav_macros', 'section_nav', array(
		'section' => 'snog_forms',
	), $__vars);
	return $__finalCompiled;
}
);