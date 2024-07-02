<?php
// FROM HASH: 6208463024d88cf0bf347ef3825100f8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-row block-row--separated">
	' . $__templater->func('bb_code', array($__vars['report']['content_info']['message'], 'chat:message', ($__vars['content'] ?: $__vars['report']['User']), ), true) . '
</div>';
	return $__finalCompiled;
}
);