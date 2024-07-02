<?php
// FROM HASH: 9eef9f9490532f6f01c08d0b91fea924
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Chat');
	$__finalCompiled .= '

' . $__templater->callMacro('section_nav_macros', 'section_nav', array(
		'section' => 'bsRtc',
	), $__vars);
	return $__finalCompiled;
}
);