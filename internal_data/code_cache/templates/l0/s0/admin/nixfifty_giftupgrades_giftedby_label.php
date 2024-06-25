<?php
// FROM HASH: 01a4020f8765ccc0475169164b2c87d5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['_upgrade']['is_gift']) {
		$__finalCompiled .= '
	(' . 'from' . $__vars['xf']['language']['label_separator'] . '
	';
		if ($__vars['_upgrade']['PurchaseRequest']['extra_data']['payUser']) {
			$__finalCompiled .= '
		' . $__templater->func('username_link', array($__vars['_upgrade']['PurchaseRequest']['extra_data']['payUser'], false, array(
				'defaultname' => 'Guest',
				'href' => $__templater->func('link', array('users/edit', $__vars['_upgrade']['PurchaseRequest']['extra_data']['payUser'], ), false),
			))) . ($__vars['_upgrade']['PurchaseRequest']['extra_data']['is_anonymous'] ? '*' : '') . ')
	';
		} else {
			$__finalCompiled .= '
		' . $__templater->func('username_link', array($__vars['_upgrade']['PayUser'], false, array(
				'defaultname' => 'Guest',
				'href' => $__templater->func('link', array('users/edit', $__vars['_upgrade']['PayUser'], ), false),
			))) . ')
	';
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);