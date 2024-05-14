<?php
// FROM HASH: 55e58f787967d91e45d489b875c90dfd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

<div class=\'clearfix\'></div>
' . $__templater->includeTemplate('bh_user_review', $__vars);
	return $__finalCompiled;
}
);