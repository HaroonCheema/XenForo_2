<?php
// FROM HASH: 0807a813a280ab5b5f25e9c40c3e5081
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Ad "' . $__templater->escape($__vars['ad']['name']) . '" has been deleted by the author.' . '</mail:subject>

<p>' . 'Ad "' . $__templater->escape($__vars['ad']['name']) . '" has been deleted by the author.' . '</p>';
	return $__finalCompiled;
}
);