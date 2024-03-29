<?php
// FROM HASH: 2a3fb34dce60b5020c54695ce9e49e96
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] == $__vars['content']['OwnerPagePost']['user_id']) {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' reacted to your comment on your owner-page post with ' . $__templater->func('reaction_title', array($__vars['extra']['reaction_id'], ), true) . '.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' reacted to your comment on ' . $__templater->escape($__vars['content']['OwnerPagePost']['OwnerPage']['title']) . '\'s owner-page post with ' . $__templater->func('reaction_title', array($__vars['extra']['reaction_id'], ), true) . '.' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts', $__vars['content'], ), true) . '</push:url>
<push:tag>bh_ownerPage_post_comment_reaction_' . $__templater->escape($__vars['content']['post_comment_id']) . '_' . $__templater->escape($__vars['extra']['reaction_id']) . '</push:tag>';
	return $__finalCompiled;
}
);