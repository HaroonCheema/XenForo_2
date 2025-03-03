<?php
// FROM HASH: cd96ddcd5517bd73bc5752ef0cb4b563
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Your Upgrade Expires In ' . $__templater->filter($__vars['daysAmount'], array(array('number', array()),), true) . ' ' . $__templater->escape($__vars['daysPhrase']) . '' . '</mail:subject>

' . '<p>Hi ' . $__templater->escape($__vars['xf']['toUser']['username']) . ',</p>

<p>This is a friendly reminder that your user upgrade (' . $__templater->escape($__vars['upgrade']['title']) . ') expires in <span style="color:red;font-weight:bold;">' . $__templater->filter($__vars['daysAmount'], array(array('number', array()),), true) . ' ' . $__templater->escape($__vars['daysPhrase']) . '</span>.</p>

Click <a href="' . $__templater->func('link', array('canonical:account/upgrade-payment-options', null, array('extend' => 1, 'userUpgradeId' => $__vars['upgrade']['user_upgrade_id'], ), ), true) . '">here</a> to extend it now and prevent losing your benefits.' . '

';
	return $__finalCompiled;
}
);