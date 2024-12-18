<?php
// FROM HASH: d59c62f2272cbc31e904c6c89138680b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('fs_avatarGallery.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'FS/AvatarGallery/gallery_avatar.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	if ($__vars['gallery_images']) {
		$__finalCompiled .= '
	<dl class="formRow formRow--input">
		<dt>
			<div class="formRow-labelWrapper">
				<label>' . 'Avatar' . $__vars['xf']['language']['label_separator'] . '</label>
			</div>
		</dt>
		<dd>
			<div class="input xb_gallery_container">
				<ul class="xb_avatar_list">
					<li>
						';
		if ($__templater->isTraversable($__vars['gallery_images'])) {
			foreach ($__vars['gallery_images'] AS $__vars['category'] => $__vars['avatars']) {
				$__finalCompiled .= '
							
							';
				if ($__templater->isTraversable($__vars['avatars'])) {
					foreach ($__vars['avatars'] AS $__vars['avatar']) {
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
		}
		$__finalCompiled .= '
					</li>
					<li><input id="xb_avatar_choice" type="hidden" name="gallery_avatar"/></li>
				</ul>
			</div>
			<p class="formRow-explain">' . 'You can choose an avatar from this pre-selected list.' . '</p>
		</dd>
	</dl>
';
	}
	return $__finalCompiled;
}
);