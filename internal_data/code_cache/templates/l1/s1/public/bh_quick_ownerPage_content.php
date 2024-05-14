<?php
// FROM HASH: ddff8de93370bbb09fbc64a70c8b12b5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

<div class=\'clearfix\'></div>
' . $__templater->includeTemplate('bh_user_ownerPage', $__vars);
	return $__finalCompiled;
}
);