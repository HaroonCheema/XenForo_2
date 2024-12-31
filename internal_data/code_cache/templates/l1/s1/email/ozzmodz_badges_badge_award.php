<?php
// FROM HASH: 516dff93ae6438bb21078715cfaf03e5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>
	' . '' . $__templater->escape($__vars['xf']['options']['boardTitle']) . ' - New badge' . '
</mail:subject>

';
	$__vars['badge'] = $__templater->preEscaped('
	<a href="' . $__templater->func('link', array('members', $__vars['xf']['visitor'], ), true) . '#badges" class="badgeTitle badgeMail badgeMail--' . $__templater->escape($__vars['badge']['badge_id']) . ' ' . $__templater->escape($__vars['badge']['class']) . '">
		' . $__templater->escape($__vars['badge']['title']) . '
	</a>
');
	$__finalCompiled .= '

' . '<p>' . $__templater->escape($__vars['user']['username']) . ',</p>

<p>You have been awarded with a new badge: ' . $__templater->escape($__vars['badge']) . '</p>' . '

';
	if (!$__templater->test($__vars['reason'], 'empty', array())) {
		$__finalCompiled .= '
	' . '<p>The following reason was provided:</p>
<div class="message">' . ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml'] ? $__templater->filter($__vars['reason'], array(array('raw', array()),), true) : $__templater->escape($__vars['reason'])) . '</div>' . '
';
	}
	return $__finalCompiled;
}
);