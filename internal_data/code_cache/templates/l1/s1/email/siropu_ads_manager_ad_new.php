<?php
// FROM HASH: 643912014bf1c7685a6bde4f322da91c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'New ad!' . '</mail:subject>

<p>' . '' . $__templater->func('username_link', array($__vars['ad']['User'], false, array('defaultname' => $__vars['ad']['username'], ), ), true) . ' has submitted a new ad: ' . $__templater->escape($__vars['ad']['name']) . '' . '</p>

<ul>
	<li>' . 'Package' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link_type', array('admin', 'canonical:ads-manager/packages/edit', $__vars['ad']['Package'], ), true) . '">' . $__templater->escape($__vars['ad']['Package']['title']) . '</a></li>
</ul>

<p><a href="' . $__templater->func('link_type', array('admin', 'canonical:ads-manager/ads/details', $__vars['ad'], ), true) . '" class="button">' . 'Approve/Reject' . '</a></p>';
	return $__finalCompiled;
}
);