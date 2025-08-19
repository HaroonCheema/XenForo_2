<?php
// FROM HASH: 2ea5187615866d6e8a24b74505b53ab3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<!DOCTYPE html>
<html id="XF" lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '"
	data-app="public"
	data-template="' . $__templater->escape($__vars['template']) . '"
	data-container-key="' . $__templater->escape($__vars['containerKey']) . '"
	data-content-key="' . $__templater->escape($__vars['contentKey']) . '"
	data-logged-in="' . ($__vars['xf']['visitor']['user_id'] ? 'true' : 'false') . '"
	data-cookie-prefix="' . $__templater->escape($__vars['xf']['cookie']['prefix']) . '"
	class="has-no-js' . ($__vars['template'] ? (' template-' . $__templater->escape($__vars['template'])) : '') . '"
	style="background: transparent;"
	' . ($__vars['xf']['runJobs'] ? ' data-run-jobs=""' : '') . '>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		' . $__templater->callMacro('helper_js_global', 'head', array(
		'app' => 'public',
	), $__vars) . '

		' . $__templater->includeTemplate('google_analytics', $__vars) . '
	</head>
	<body>
		' . $__templater->callMacro('helper_js_global', 'body', array(
		'app' => 'public',
		'jsState' => $__vars['jsState'],
	), $__vars) . '

		' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '
		
		' . $__templater->filter($__vars['ldJsonHtml'], array(array('raw', array()),), true) . '
	</body>
</html>';
	return $__finalCompiled;
}
);