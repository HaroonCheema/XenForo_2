<?php
// FROM HASH: 2274d1771240fd54042bfbf2fc830f9e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('bh_owner_page_post_macros', 'comment', array(
		'comment' => $__vars['comment'],
		'profilePost' => $__vars['profilePost'],
	), $__vars) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);