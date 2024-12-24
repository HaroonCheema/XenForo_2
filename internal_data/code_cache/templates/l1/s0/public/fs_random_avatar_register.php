<?php
// FROM HASH: d91f869b4b0885147f6e7bed52abaafe
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('fs_avatar_gallery_macro', 'js_and_style_css', array(), $__vars) . '

' . $__templater->callMacro('fs_avatar_gallery_macro', 'register_details_avatar', array(
		'random_avatar' => $__vars['random_avatar'],
	), $__vars) . '

' . $__templater->callMacro('fs_avatar_gallery_macro', 'upload_tag_script', array(), $__vars);
	return $__finalCompiled;
}
);