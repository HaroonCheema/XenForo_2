<?php
// FROM HASH: cd7434c68ffe11fc4d331e89c2bb1a5f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your request about Verification was rejected. Reason: ' . $__templater->escape($__vars['content']['reject_reason']) . '';
	return $__finalCompiled;
}
);