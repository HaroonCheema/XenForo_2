<?php
// FROM HASH: d8d23f7569895ddb3dd4ec9e7fc9851c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['user_id'] == $__vars['content']['OwnerPage']['user_id']) {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' reacted to your owner-page update with ' . $__templater->func('reaction_title', array($__vars['extra']['reaction_id'], ), true) . '.' . '
';
	} else {
		$__finalCompiled .= '
	' . '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' reacted to your post on ' . $__templater->escape($__vars['content']['OwnerPage']['title']) . ' owner-page with ' . $__templater->func('reaction_title', array($__vars['extra']['reaction_id'], ), true) . '.' . '
';
	}
	$__finalCompiled .= '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts', $__vars['content'], ), true) . '</push:url>
<push:tag>bh_ownerPage_post_reaction_' . $__templater->escape($__vars['content']['post_id']) . '_' . $__templater->escape($__vars['extra']['reaction_id']) . '</push:tag>';
	return $__finalCompiled;
}
);