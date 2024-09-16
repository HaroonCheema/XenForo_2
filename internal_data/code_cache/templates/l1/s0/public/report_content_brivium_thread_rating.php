<?php
// FROM HASH: a68cf1e4efdfb1a77497f6bf0a5aee34
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-row block-row--separated">
	' . $__templater->func('bb_code', array($__vars['report']['content_info']['message'], 'rating', ($__vars['content'] ?: $__templater->method($__vars['report'], 'getUser', array())), ), true) . '
</div>
<div class="block-row block-row--separated block-row--minor">
	<dl class="pairs pairs--inline">
		<dt>' . 'Forum' . '</dt>
		<dd><a href="' . $__templater->func('link', array('forums', $__vars['report']['content_info'], ), true) . '">' . $__templater->escape($__vars['report']['content_info']['node_title']) . '</a></dd>
	</dl>
</div>';
	return $__finalCompiled;
}
);