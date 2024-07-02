<?php
// FROM HASH: ffe9fa10fbaf7127d41f0a06516a4bbd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.rtc-room-avatar {
	display: flex;
	align-items: center;
	justify-content: center;

	border-radius: 50%;
	overflow: hidden;
	transition: .2s;

	color: var(--color);
	background: var(--background);

	&.size--xxs {
		.m-roomAvatarSize(@avatar-xxs);
	}

	&.size--xs {
		.m-roomAvatarSize(@avatar-xs);
	}

	&.size--s {
		.m-roomAvatarSize(@avatar-s);
	}

	&.size--m {
		.m-roomAvatarSize(@avatar-m);
	}

	&.size--l {
		.m-roomAvatarSize(@avatar-l);
	}

	&.size--o {
		.m-roomAvatarSize(@avatar-o);
	}
}

.m-roomAvatarSize(@avatarSize) {
	width: @avatarSize;
	height: @avatarSize;
	font-size: round((@avatarSize) * (@xf-avatarDynamicTextPercent / 150));
}';
	return $__finalCompiled;
}
);