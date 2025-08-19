<?php
// FROM HASH: 8622d2681f3cd6b012867f3e15e73300
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['extra']['type'] == 'invoice') {
		$__finalCompiled .= '
	' . 'Invoice with ID ' . (((('<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/invoices/edit', array('invoice_id' => $__vars['extra']['id'], ), ), true)) . '" class="fauxBlockLink-blockLink">#') . $__templater->escape($__vars['extra']['id'])) . '</a>') . ' has been marked as paid by ' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' via bank transfer.' . '
';
	} else {
		$__finalCompiled .= '
	' . 'User upgrade with ID ' . (((('<a href="' . $__templater->func('link_type', array('admin', 'user-upgrades/edit', array('user_upgrade_id' => $__vars['extra']['id'], ), ), true)) . '" class="fauxBlockLink-blockLink">#') . $__templater->escape($__vars['extra']['id'])) . '</a>') . ' has been marked as paid by ' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' via bank transfer.' . '
';
	}
	return $__finalCompiled;
}
);