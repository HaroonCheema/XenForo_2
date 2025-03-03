<?php
// FROM HASH: 69513233d84fd7070e626d8e74211eab
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Thanks for your purchase!');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="blockMessage">' . 'Thank you for purchasing this upgrade as a gift for ' . $__templater->escape($__vars['user']['username']) . '.<br />
<br />
When the payment has been approved, their account will be upgraded and they will be notified.' . '</div>';
	return $__finalCompiled;
}
);