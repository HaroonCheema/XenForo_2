<?php
// FROM HASH: ef3e6e374a8916c4511f4a0159391761
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'Your Upgrade ' . (((('<a href="' . $__templater->func('link', array('account/upgrade-payment-options', null, array('extend' => 1, 'userUpgradeId' => $__vars['content']['user_upgrade_id'], ), ), true)) . '" class="fauxBlockLink-blockLink">') . $__templater->escape($__vars['content']['title'])) . '</a>') . ' Expires In ' . $__templater->filter($__vars['extra']['daysAmount'], array(array('number', array()),), true) . ' ' . $__templater->escape($__vars['extra']['daysPhrase']) . '. Click here to extend it.';
	return $__finalCompiled;
}
);