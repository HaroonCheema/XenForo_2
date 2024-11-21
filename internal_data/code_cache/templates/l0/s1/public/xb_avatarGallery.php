<?php
// FROM HASH: 84ce68671117bf1015c75f5eca7e99b3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('xb_avatarGallery.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'XenBulletin/AvatarGallery/gallery_avatar.js',
	));
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['xb_enable'] AND (!$__templater->method($__vars['xf']['visitor'], 'hasPermission', array('general', 'xb_cannot_use_avatar_glry', )))) {
		$__finalCompiled .= '
    <label>' . 'Use a gallery avatar' . '</label>
    <div class="input xb_gallery_container">
		<ul class="xb_avatar_list">
			<li>
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
									<img class="avatar avatar--m" src="' . $__templater->escape($__vars['avatar']['url']) . '" >
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
								<img class="avatar avatar--m" src="' . $__templater->escape($__vars['avatar']['url']) . '" >
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