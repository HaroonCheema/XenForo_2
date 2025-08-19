<?php
// FROM HASH: 2b5337e984b893d9798491f1457e0aa2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Your ad has been rejected' . '</mail:subject>

<p>' . 'Your ad ' . $__templater->escape($__vars['content']['name']) . ' has been rejected for the following reason: ' . $__templater->escape($__vars['content']['Extra']['reject_reason']) . '' . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads', ), true) . '" class="button">' . 'Manage your ads' . '</a></p>';
	return $__finalCompiled;
}
);