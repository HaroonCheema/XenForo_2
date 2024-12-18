<?php
// FROM HASH: 704e47dd3097bbfe1169f82b564da8e0
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
	if ($__vars['xf']['options']['fs_enable'] AND ((!$__templater->method($__vars['xf']['visitor'], 'hasPermission', array('general', 'fs_cannot_use_avatar_glry', ))) AND $__templater->func('count', array($__vars['gallery_images'], ), false))) {
		$__finalCompiled .= '
    <label>' . 'Use a gallery avatar' . '</label>
    <div class="input xb_gallery_container">
		<ul class="xb_avatar_list">
			<li class="avatar-items">
				';
		if ($__templater->isTraversable($__vars['gallery_images'])) {
			foreach ($__vars['gallery_images'] AS $__vars['category'] => $__vars['avatars']) {
				$__finalCompiled .= '
					';
				if ($__vars['avatars']['permission'] != '2') {
					$__finalCompiled .= '
						';
					if ($__vars['avatars']['permission']) {
						$__finalCompiled .= '
							';
						if ($__templater->isTraversable($__vars['avatars']['dirname'])) {
							foreach ($__vars['avatars']['dirname'] AS $__vars['avatar']) {
								$__finalCompiled .= '
								<div id="xb_avatar_select" data-xf-click="xb_avatar" data-avatar-data-path="' . $__templater->escape($__vars['avatar']['data-path']) . '">
									<i class="fa fa-check"></i>
									<img class="avatar avatar--s" src="' . $__templater->escape($__vars['avatar']['url']) . '" >
								</div>
							';
							}
						}
						$__finalCompiled .= '
						';
					}
					$__finalCompiled .= '
						';
				} else if ($__vars['avatars']['permission'] == '2') {
					$__finalCompiled .= '
						
						';
					if ($__templater->isTraversable($__vars['avatars']['dirname'])) {
						foreach ($__vars['avatars']['dirname'] AS $__vars['avatar']) {
							$__finalCompiled .= '
							<div id="xb_avatar_select" data-xf-click="xb_avatar" data-avatar-data-path="' . $__templater->escape($__vars['avatar']['data-path']) . '">
								<i class="fa fa-check"></i>
								<img class="avatar avatar--s" src="' . $__templater->escape($__vars['avatar']['url']) . '" >
							</div>
						';
						}
					}
					$__finalCompiled .= '
					';
				}
				$__finalCompiled .= '
				';
			}
		}
		$__finalCompiled .= '
			<li><input id="xb_avatar_choice" type="hidden" name="gallery_avatar"/></li>
		</ul>
	</div>
';
	}
	return $__finalCompiled;
}
);