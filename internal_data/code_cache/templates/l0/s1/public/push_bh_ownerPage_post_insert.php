<?php
// FROM HASH: 6542e48b7f7c2978299dba1e149c3417
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['alert']['username'])) . ' wrote a message on your owner-page.' . '
<push:url>' . $__templater->func('link', array('canonical:owner-page-posts', $__vars['content'], ), true) . '</push:url>';
	return $__finalCompiled;
}
);