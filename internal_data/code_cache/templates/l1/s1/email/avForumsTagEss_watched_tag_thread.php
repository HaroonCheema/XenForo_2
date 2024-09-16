<?php
// FROM HASH: 64602885bac99d3f7dda6eb264d97f0e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
	' . '{name} tagged a {content_type} ' . ($__templater->func('prefix', array('thread', $__vars['content'], 'escaped', ), true) . $__templater->escape($__vars['content']['title'])) . ' with {tag}' . '
</mail:subject>

' . '<p>' . $__templater->func('username_link_email', array($__vars['tagContent']['AddUser'], $__vars['tagContent']['AddUser']['username'], ), true) . ' tagged new content with the tag ' . $__templater->escape($__vars['tag']) . ' you are watching at ' . (((('<a href="' . $__templater->func('link', array('canonical:index', ), true)) . '">') . $__templater->escape($__vars['xf']['options']['boardTitle'])) . '</a>') . '.</p>' . '

<h2>' . $__templater->func('prefix', array('thread', $__vars['content'], 'escaped', ), true) . $__templater->escape($__vars['content']['title']) . '</h2>

' . $__templater->callMacro('avForums_content_macros', 'go_content_bar', array(
		'content' => $__vars['content'],
		'watchType' => $__vars['tagContent']['content_type'],
	), $__vars) . '

' . $__templater->callMacro('avForums_content_macros', 'watched_tag_footer', array(
		'tag' => $__vars['tag'],
	), $__vars);
	return $__finalCompiled;
}
);