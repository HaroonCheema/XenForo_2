<?php
// FROM HASH: ab395c5f3f2508af409e252299e6e0e5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.messageHide {
	
	margin: @xf-messagePaddingSmall 0;
	padding: @xf-messagePaddingSmall @xf-messagePadding;
	
	a,
	a:hover
	{
		.xf-contentAccentLink();
	}

	&:first-child
	{
		margin-top: 0;
	}

	&:before
	{
		display: inline-block;
		.m-faBase();
		padding-right: .2em;
		font-size: 125%;
	}
	
	&.messageHide--link { .xf-fs_hide_link_from_guests_error_link(); }
	&.messageHide--media { .xf-fs_hide_link_from_guests_error_media(); }
	&.messageHide--image { .xf-fs_hide_link_from_guests_error_image(); }
	&.messageHide--attach { .xf-fs_hide_link_from_guests_error_attach(); }
	
	&.messageHide--link:before { .xf-fs_hide_link_from_guests_error_link_icon(); }
	&.messageHide--media:before { .xf-fs_hide_link_from_guests_error_media_icon(); }
	&.messageHide--image:before { .xf-fs_hide_link_from_guests_error_image_icon(); }
	&.messageHide--attach:before { .xf-fs_hide_link_from_guests_error_attach_icon(); }
}';
	return $__finalCompiled;
}
);