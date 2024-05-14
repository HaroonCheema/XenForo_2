<?php
// FROM HASH: 9e38c3bf3760504849f73f6270e65a51
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	if ($__vars['loadMore']) {
		$__finalCompiled .= '
	<div class="message-responseRow js-commentLoader">
		<a href="' . $__templater->func('link', array('owner-page-posts/load-previous', $__vars['profilePost'], array('before' => $__vars['firstCommentDate'], ), ), true) . '"
			data-xf-click="comment-loader"
			data-container=".js-commentLoader"
			rel="nofollow">' . 'View previous comments' . $__vars['xf']['language']['ellipsis'] . '</a>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['comments'])) {
		foreach ($__vars['comments'] AS $__vars['comment']) {
			$__finalCompiled .= '
	' . $__templater->callMacro('bh_owner_page_post_macros', 'comment', array(
				'comment' => $__vars['comment'],
				'profilePost' => $__vars['profilePost'],
			), $__vars) . '
';
		}
	}
	return $__finalCompiled;
}
);