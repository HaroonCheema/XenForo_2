<?php
// FROM HASH: d94504d6eab760c20f5122f4d53051da
return array(
'macros' => array('js_and_style_css' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('fs_avatarGallery.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'FS/AvatarGallery/random_avatar.js?' . $__vars['xf']['time'],
	));
	$__finalCompiled .= '

	<style>
		#onCustomAvatar{
			display: none;
		}
	</style>

';
	return $__finalCompiled;
}
),
'account_details_avatar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'random_avatar' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	' . $__templater->formRow('
		<div id="xb_avatar_select">
			<img class="avatar avatar--s" id="imagePreview" src="' . $__templater->escape($__vars['random_avatar']['url']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['height']) . 'px;">
		</div>
	', array(
		'label' => 'Current Avatar',
		'id' => 'onCustomAvatar',
	)) . '

	';
	if (($__vars['xf']['options']['fs_use_random'] AND $__templater->method($__vars['xf']['visitor'], 'canUseRandomAvatar', array())) OR $__vars['xf']['options']['fs_use_custom']) {
		$__finalCompiled .= '

		';
		$__compilerTemp1 = '';
		if ($__vars['xf']['options']['fs_use_random'] AND $__templater->method($__vars['xf']['visitor'], 'canUseRandomAvatar', array())) {
			$__compilerTemp1 .= '
				<input id="fs_random_input" type="hidden" name="gallery_avatar" value="' . $__templater->escape($__vars['random_avatar']['data-path']) . '"/>
				<input id="fs_random_avatar_limit" type="hidden" name="random_avatar_limit" />

				' . $__templater->button('Random', array(
				'id' => 'random_button_c',
				'data-xf-click' => 'fs_random_account_details',
				'data-random-data-limit' => $__vars['xf']['options']['fs_random_limit'],
			), '', array(
			)) . '

			';
		}
		$__compilerTemp2 = '';
		if ($__vars['xf']['options']['fs_use_custom']) {
			$__compilerTemp2 .= '

				<label class="button">' . 'Upload' . '
					' . $__templater->formUpload(array(
				'name' => 'img_avatar',
				'id' => 'imageUpload',
				'class' => 'js-uploadAvatar',
				'accept' => '.gif,.jpeg,.jpg,.jpe,.png,.webp',
				'style' => 'display: none;',
			)) . '
				</label>

			';
		}
		$__finalCompiled .= $__templater->formRow('
			' . $__compilerTemp1 . '
			' . $__compilerTemp2 . '
		', array(
			'label' => 'Change Avatar',
		)) . '

	';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'register_details_avatar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'random_avatar' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['xf']['options']['fs_use_random'] OR $__vars['xf']['options']['fs_use_custom']) {
		$__finalCompiled .= '

		';
		if (($__vars['xf']['options']['fs_use_random'] AND $__vars['xf']['options']['fs_use_custom']) OR $__vars['xf']['options']['fs_use_random']) {
			$__finalCompiled .= '

			' . $__templater->formRow('
				<div id="xb_avatar_select">
					<img class="avatar avatar--s" id="imagePreview" src="' . $__templater->escape($__vars['random_avatar']['url']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['height']) . 'px;">
				</div>
			', array(
				'label' => 'Current Avatar',
			)) . '
			';
		} else {
			$__finalCompiled .= '
			' . $__templater->formRow('
				<div id="xb_avatar_select">
					<img class="avatar avatar--s" id="imagePreview" src="' . $__templater->escape($__vars['random_avatar']['url']) . '" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_register_avatar_preview']['height']) . 'px;">
				</div>
			', array(
				'label' => 'Current Avatar',
				'id' => 'onCustomAvatar',
			)) . '
		';
		}
		$__finalCompiled .= '

	';
	}
	$__finalCompiled .= '

	';
	$__compilerTemp1 = '';
	if ($__vars['xf']['options']['fs_use_random']) {
		$__compilerTemp1 .= '
			<input id="fs_random_input" type="hidden" name="gallery_avatar" value="' . $__templater->escape($__vars['random_avatar']['data-path']) . '"/>
			<input id="fs_random_avatar_limit" type="hidden" name="random_avatar_limit" />

			' . $__templater->button('Random', array(
			'data-xf-click' => 'xb_random_avatar',
			'data-random-data-limit' => $__vars['xf']['options']['fs_random_limit'],
		), '', array(
		)) . '

		';
	}
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['fs_use_custom']) {
		$__compilerTemp2 .= '

			<label class="button">' . 'Upload' . '
				' . $__templater->formUpload(array(
			'name' => 'img_avatar',
			'id' => 'imageUpload',
			'class' => 'js-uploadAvatar',
			'accept' => '.gif,.jpeg,.jpg,.jpe,.png,.webp',
			'style' => 'display: none;',
		)) . '
			</label>

		';
	}
	$__finalCompiled .= $__templater->formRow('
		' . $__compilerTemp1 . '
		' . $__compilerTemp2 . '
	', array(
		'label' => 'Change Avatar',
		'id' => 'random_button_c',
	)) . '

';
	return $__finalCompiled;
}
),
'upload_tag_script' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<script>
		document.getElementById(\'imageUpload\').addEventListener(\'change\', function(event) {
			const file = event.target.files[0];
			const preview = document.getElementById(\'imagePreview\');
			const previewImgTag = document.getElementById(\'onCustomAvatar\');

			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result;
					previewImgTag.style.display = \'flex\'; 
				};
				reader.readAsDataURL(file); 
			} else {
				previewImgTag.style.display = \'none\'; 
				preview.src = \'\'; 
			}
		});
	</script>

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '


' . '

';
	return $__finalCompiled;
}
);