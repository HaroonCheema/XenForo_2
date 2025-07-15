<?php
// FROM HASH: f7b836ab493ebbe72f1ba97abd879f0f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">
	<img src="' . $__templater->escape($__vars['providerData']['avatar_url']) . '" width="48" alt="" />
</a>
<div>
	<a href="' . $__templater->escape($__vars['providerData']['profile_link']) . '" target="_blank">' . ($__templater->escape($__vars['providerData']['username']) ?: 'View account') . '</a>
</div>';
	return $__finalCompiled;
}
);