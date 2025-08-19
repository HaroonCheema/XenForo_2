<?php
// FROM HASH: d49709532f28a77aa2b8162ab1b362ce
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . $__templater->escape($__vars['subject']) . '</mail:subject>

<p>' . $__templater->escape($__vars['message']) . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads/edit', $__vars['ad'], ), true) . '" class="button">' . 'Edit your ad' . '</a></p>';
	return $__finalCompiled;
}
);