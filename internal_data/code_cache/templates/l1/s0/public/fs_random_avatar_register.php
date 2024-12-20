<?php
// FROM HASH: 2bf410c2960fdb239ee90fc6d95911cc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('fs_avatarGallery.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'FS/AvatarGallery/random_avatar.js?' . $__vars['xf']['time'],
	));
	$__finalCompiled .= '

' . $__templater->formRow('
	<div id="xb_avatar_select">
		<img class="avatar avatar--s" src="' . $__templater->escape($__vars['random_avatar']['url']) . '" >
	</div>

	<input id="fs_random_input" type="hidden" name="gallery_avatar" value="' . $__templater->escape($__vars['random_avatar']['data-path']) . '"/>
	<input id="fs_random_avatar_limit" type="hidden" name="random_avatar_limit" />
', array(
		'label' => 'Current Avatar' . ' ',
	)) . '

' . $__templater->formRow('
	' . $__templater->button('Random', array(
		'data-xf-click' => 'xb_random_avatar',
		'data-random-data-limit' => $__vars['xf']['options']['fs_random_limit'],
	), '', array(
	)) . '
', array(
		'label' => 'Change Avatar',
		'id' => 'random_button_c',
	));
	return $__finalCompiled;
}
);