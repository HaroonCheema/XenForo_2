<?php
// FROM HASH: 11993c3cce191e6c59095b19b0247ef7
return array(
'macros' => array('go_content_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'content' => '!',
		'contentType' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<table cellpadding="10" cellspacing="0" border="0" width="100%" class="linkBar">
	<tr>
		<td>
			';
	if ($__vars['contentType'] == 'threads') {
		$__finalCompiled .= '
				<a href="' . $__templater->func('link', array('canonical:threads', $__vars['content'], ), true) . '" class="button">' . 'View this thread' . '</a>
			';
	}
	$__finalCompiled .= '
		</td>
		<td align="' . ($__vars['xf']['isRtl'] ? 'left' : 'right') . '">
			<a href="' . $__templater->func('link', array('canonical:watched/tags', ), true) . '" class="buttonFake">' . 'Watched tags' . '</a>
		</td>
	</tr>
	</table>
';
	return $__finalCompiled;
}
),
'watched_tag_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . '<p class="minorText">Please do not reply to this message. You must visit the forum to reply.</p>

<p class="minorText">This message was sent to you because you opted to watch the tag ' . (((('<a href="' . $__templater->func('link', array('canonical:tags', $__vars['tag'], ), true)) . '">') . $__templater->escape($__vars['tag']['tag'])) . '</a>') . ' at ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ' with email notification of new replies. You will not receive any further emails about this thread until you have read the new messages.</p>

<p class="minorText">If you no longer wish to receive these emails, you may <a href="' . $__templater->func('link', array('canonical:email-stop/content', $__vars['xf']['toUser'], array('t' => 'tag', 'id' => $__vars['tag']['tag_id'], ), ), true) . '">disable emails from this tag</a> or <a href="' . $__templater->func('link', array('canonical:email-stop/all', $__vars['xf']['toUser'], ), true) . '">disable all emails</a>.</p>' . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);