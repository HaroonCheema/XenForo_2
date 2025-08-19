<?php
// FROM HASH: e62cc2af4456ffc12858e1fa6693fe21
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Ad requires reapproval' . '</mail:subject>

<p>' . 'Ad ' . $__templater->escape($__vars['ad']['name']) . ' requires reapproval due to recent changes.' . '</p>

<p><a href="' . $__templater->func('link_type', array('admin', 'canonical:ads-manager/ads/details', $__vars['ad'], ), true) . '" class="button">' . 'Approve/Reject' . '</a></p>';
	return $__finalCompiled;
}
);