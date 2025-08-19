<?php
// FROM HASH: 10f0fe0e2d1d797ee811ba92ded2a356
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Ad ' . (((('<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/details', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['name'])) . '</a>') . ' requires reapproval due to recent changes.';
	return $__finalCompiled;
}
);