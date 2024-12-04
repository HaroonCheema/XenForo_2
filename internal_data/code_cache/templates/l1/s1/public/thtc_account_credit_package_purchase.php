<?php
// FROM HASH: 9fbe1cf6e3f0c195e29439d02ff1c482
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Thanks for your purchase!');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="blockMessage">' . 'Thank you for purchasing this credit package.' . '</div>';
	return $__finalCompiled;
}
);