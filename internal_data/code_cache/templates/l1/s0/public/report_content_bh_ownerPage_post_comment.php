<?php
// FROM HASH: 1ecfd0783e59606c9633b04c05c78715
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-row block-row--separated">
	' . $__templater->func('bb_code', array($__vars['report']['content_info']['message'], 'bh_ownerPage_post_comment', ($__vars['content'] ?: $__vars['report']['User']), ), true) . '
</div>

';
	if ($__vars['report']['content_info']['user']) {
		$__finalCompiled .= '
	';
		if ($__vars['report']['content_info']['user']['user_id'] != $__vars['report']['content_info']['ownerPage']['user_id']) {
			$__finalCompiled .= '
		<div class="block-row block-row--separated block-row--minor">
			<dl class="pairs pairs--inline">
				<dt>' . 'Owner-page post' . '</dt>
				<dd><a href="' . $__templater->func('link', array('owner-page-posts', $__vars['report']['content_info'], ), true) . '">' . 'Owner-page post for ' . $__templater->escape($__vars['report']['content_info']['ownerPage']['title']) . '' . '</a></dd>
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
			<dt>' . 'Owner-page post' . '</dt>
			<dd><a href="' . $__templater->func('link', array('owner-page-posts', $__vars['report']['content_info'], ), true) . '">' . 'Owner-page post for ' . $__templater->escape($__vars['report']['content_info']['ownerPage']['title']) . '' . '</a></dd>
		</dl>
	</div>
';
	}
	return $__finalCompiled;
}
);