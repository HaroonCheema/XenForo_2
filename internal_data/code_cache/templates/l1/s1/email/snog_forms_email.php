<?php
// FROM HASH: be893839104ab5f382b02fc9bb205434
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
' . '' . $__templater->escape($__vars['subject']) . ' (from ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ')' . '
</mail:subject>

<h2>' . $__templater->escape($__vars['subject']) . '</h2>

<blockquote>' . $__templater->func('bb_code', array($__vars['message'], '', '', ), true) . '</blockquote>

';
	if ($__vars['thread']) {
		$__finalCompiled .= '
	' . 'Thread' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . $__templater->escape($__vars['thread']['title']) . '</a>
';
	}
	return $__finalCompiled;
}
);