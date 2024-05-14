<?php
// FROM HASH: ea96594022ff23e890809f07b1fb3968
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['firstUnshownProfilePost']) {
		$__finalCompiled .= '
	<div class="message message--simple">
		<div class="message-inner">
			<div class="message-cell message-cell--alert">
				' . 'There are more posts to display.' . ' <a href="' . $__templater->func('link', array('owner-page-posts', $__vars['firstUnshownProfilePost'], ), true) . '">' . 'View them?' . '</a>
			</div>
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['profilePosts'])) {
		foreach ($__vars['profilePosts'] AS $__vars['profilePost']) {
			$__finalCompiled .= '
	';
			if ($__vars['style'] == 'simple') {
				$__finalCompiled .= '
		<div class="block-row">
			' . $__templater->callMacro('bh_owner_page_post_macros', 'profile_post_simple', array(
					'profilePost' => $__vars['profilePost'],
				), $__vars) . '
		</div>
	';
			} else {
				$__finalCompiled .= '
		' . $__templater->callMacro('bh_owner_page_post_macros', 'profile_post', array(
					'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['post_id']],
					'profilePost' => $__vars['profilePost'],
				), $__vars) . '
	';
			}
			$__finalCompiled .= '
';
		}
	}
	return $__finalCompiled;
}
);