<?php
// FROM HASH: fea268eba144cef518beaa691ba09f53
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('fs_avatarGallery.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'FS/AvatarGallery/gallery_avatar.js?' . $__vars['xf']['time'],
	));
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['fs_enable'] AND (!$__templater->method($__vars['xf']['visitor'], 'hasPermission', array('general', 'fs_cannot_use_avatar_glry', )))) {
		$__finalCompiled .= '

	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['gallery_images'])) {
			foreach ($__vars['gallery_images'] AS $__vars['category'] => $__vars['avatars']) {
				$__compilerTemp1 .= '
						';
				if ($__templater->isTraversable($__vars['avatars'])) {
					foreach ($__vars['avatars'] AS $__vars['avatar']) {
						$__compilerTemp1 .= '
							<div id="xb_avatar_select" data-xf-click="xb_avatar" data-avatar-data-path="' . $__templater->escape($__vars['avatar']['data-path']) . '">
								<i class="fa fa-check"></i>
								<img class="avatar avatar--s" src="' . $__templater->escape($__vars['avatar']['url']) . '" >
							</div>
						';
					}
				}
				$__compilerTemp1 .= '
					';
			}
		}
		$__finalCompiled .= $__templater->formRow('

		' . '

		<label>' . 'Use a gallery avatar' . '</label>
		<div class="input xb_gallery_container">
			<ul class="xb_avatar_list">
				<li class="avatar-items">
					' . $__compilerTemp1 . '
				<li><input id="xb_avatar_choice" type="hidden" name="gallery_avatar"/></li>
			</ul>
		</div>
	', array(
			'label' => 'Avatars' . ' ',
		)) . '
';
	}
	return $__finalCompiled;
}
);