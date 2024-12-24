<?php
// FROM HASH: 7a423a145ba04f1d7258c8520ea19910
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('fs_avatar_gallery_macro', 'js_and_style_css', array(), $__vars) . '

' . $__templater->callMacro('fs_avatar_gallery_macro', 'account_details_avatar', array(
		'random_avatar' => $__vars['random_avatar'],
	), $__vars) . '

' . $__templater->callMacro('fs_avatar_gallery_macro', 'upload_tag_script', array(), $__vars);
	return $__finalCompiled;
}
);