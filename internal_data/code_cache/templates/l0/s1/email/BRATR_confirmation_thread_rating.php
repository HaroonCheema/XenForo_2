<?php
// FROM HASH: 51cffd7f0981a3acae99a650f388eb57
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
	' . 'Confirmation to rated thread ' . ($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title'])) . '' . '
</mail:subject>

' . 'Dear ' . $__templater->escape($__vars['rating']['username']) . ',<br/><br/>
You rated thread \'' . ((((('<a href="' . $__templater->func('link', array('canonical:threads', $__vars['thread'], ), true)) . '">') . $__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true)) . $__templater->escape($__vars['thread']['title'])) . '</a>') . '\', you need to confirm by click on the following link below:<br/>
<a href="' . $__templater->func('link', array('canonical:bratr-ratings/confirm', $__vars['rating'], array('c' => $__vars['rating']['encode'], ), ), true) . '" target="_blank">' . $__templater->func('link', array('canonical:bratr-ratings/confirm', $__vars['rating'], array('c' => $__vars['rating']['encode'], ), ), true) . '</a>
<br/><br/>
We apologize for any inconvenience caused. Thanks for your cooperation in advance.<br/>
' . (((('<a href="' . $__templater->func('link', array('canonical:index', ), true)) . '">') . $__templater->escape($__vars['xf']['options']['boardTitle'])) . '</a>') . '' . '

<div class="message">' . $__templater->func('bb_code_type', array('emailHtml', $__vars['rating']['message'], 'bratr-review', $__vars['rating'], ), true) . '</div>

' . $__templater->callMacro('thread_forum_macros', 'go_thread_bar', array(
		'thread' => $__vars['thread'],
		'watchType' => 'threads',
	), $__vars) . '
' . $__templater->callMacro('thread_forum_macros', 'watched_thread_footer', array(
		'thread' => $__vars['thread'],
	), $__vars);
	return $__finalCompiled;
}
);