<?php
// FROM HASH: 8b2064d0adc45ee7918bb0e143af9510
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-row block-row--separated">
	' . $__templater->func('bb_code', array($__vars['report']['content_info']['message'], 'bh_ownerPage_post', ($__vars['content'] ?: $__vars['report']['User']), ), true) . '
</div>

';
	if ($__vars['report']['content_info']['user']) {
		$__finalCompiled .= '
	';
		if ($__vars['report']['content_info']['user']['user_id'] != $__vars['report']['content_info']['ownerPage']['user_id']) {
			$__finalCompiled .= '
		<div class="block-row block-row--separated block-row--minor">
			<dl class="pairs pairs--inline">
				<dt>' . 'Owner page' . '</dt>
				<dd><a href="' . $__templater->func('link', array('owners', $__vars['report']['content_info']['ownerPage'], ), true) . '">' . $__templater->escape($__vars['report']['content_info']['ownerPage']['title']) . '</a></dd>
			</dl>
		</div>
	';
		}
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	<div class="block-row block-row--separated block-row--minor">
		<dl class="pairs pairs--inline">
			<dt>' . 'Owner page' . '</dt>
			<dd>' . $__templater->escape($__vars['report']['content_info']['ownerPage']['title']) . '</dd>
		</dl>
	</div>
';
	}
	return $__finalCompiled;
}
);