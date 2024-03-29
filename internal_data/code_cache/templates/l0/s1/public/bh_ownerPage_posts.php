<?php
// FROM HASH: a0d20214b476a11a1e02a40850b60c9c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<ul class="tabPanes js-memberTabPanes">
	' . '
	';
	if ($__templater->method($__vars['ownerPage'], 'canViewPostsOnOwnerPage', array())) {
		$__finalCompiled .= '
		<li class="is-active" role="tabpanel" id="profile-posts">
			';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '

			' . $__templater->callMacro('lightbox_macros', 'setup', array(
			'canViewAttachments' => $__vars['canViewAttachments'],
		), $__vars) . '

			<div class="block block--messages"
				data-xf-init="lightbox inline-mod"
				data-type="bh_ownerPage_post"
				data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

				<div class="block-container">
					<div class="block-body js-replyNewMessageContainer">
						';
		if ($__templater->method($__vars['ownerPage'], 'canPostOnOwnerPage', array())) {
			$__finalCompiled .= '
							';
			$__vars['firstProfilePost'] = $__templater->filter($__vars['profilePosts'], array(array('first', array()),), false);
			$__finalCompiled .= '
							' . $__templater->callMacro('bh_owner_page_post_macros', 'quick_post', array(
				'ownerPage' => $__vars['ownerPage'],
				'lastDate' => ($__vars['firstProfilePost']['post_date'] ?: 0),
				'containerSelector' => '< .js-replyNewMessageContainer',
				'attachmentData' => $__vars['attachmentData'],
			), $__vars) . '
						';
		}
		$__finalCompiled .= '

						';
		if (!$__templater->test($__vars['profilePosts'], 'empty', array())) {
			$__finalCompiled .= '
							';
			if ($__templater->isTraversable($__vars['profilePosts'])) {
				foreach ($__vars['profilePosts'] AS $__vars['profilePost']) {
					$__finalCompiled .= '
								' . $__templater->callMacro('bh_owner_page_post_macros', (($__vars['profilePost']['message_state'] == 'deleted') ? 'profile_post_deleted' : 'profile_post'), array(
						'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['post_id']],
						'profilePost' => $__vars['profilePost'],
					), $__vars) . '
							';
				}
			}
			$__finalCompiled .= '
						';
		} else {
			$__finalCompiled .= '
							<div class="block-row js-replyNoMessages">' . 'There are no messages on ' . $__templater->escape($__vars['ownerPage']['title']) . ' owner-page yet.' . '</div>
						';
		}
		$__finalCompiled .= '
					</div>
				</div>

				<div class="block-outer block-outer--after">
					' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'owners',
			'data' => $__vars['ownerPage'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
					<div class="block-outer-opposite">
						' . $__templater->func('show_ignored', array(array(
		))) . '
						';
		if ($__vars['canInlineMod']) {
			$__finalCompiled .= '
							' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
						';
		}
		$__finalCompiled .= '
					</div>
				</div>
			</div>
		</li>
	';
	}
	$__finalCompiled .= '
</ul>';
	return $__finalCompiled;
}
);