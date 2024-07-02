<?php
// FROM HASH: 3687c3d78f333cd464e8a185b5c531e8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.m-chatButton () {
	flex: 1;
	max-width: unset;
	font-size: 15px;
	text-transform: uppercase;
	letter-spacing: .8px;
	padding: 12px 15px;
	border-radius: var(--chat-button-border-radius);
	border: none;
	-webkit-tap-highlight-color: rgba(0,0,0,0);
	-webkit-tap-highlight-color: transparent;
	font-family: var(--chat-font-family);
}

.m-chatInput () {
	padding: 13px 16px;
	// iphone focus fix
	// https://stackoverflow.com/questions/2989263/disable-auto-zoom-in-input-text-tag-safari-on-iphone
	font-size: 16px;
	box-shadow: none;
	border: 1px solid var(--border-color);
	border-radius: var(--chat-input-border-radius);
	background: transparent;
}

.m-chatResponsive (@compact-breakpoint) {
	@media (max-width: @compact-breakpoint) {
		.m-chatCompact();
	}
	
	&.compact {
		.m-chatCompact();
	}
	
	// iphone focus fix
	// https://stackoverflow.com/questions/2989263/disable-auto-zoom-in-input-text-tag-safari-on-iphone
	@media screen and (-webkit-min-device-pixel-ratio: 0) { 
		select,
		textarea,
		input,
		.ql-editor {
			font-size: 16px;
		}
	}
}

.m-chatCompact() {
	--beside-button-size: 30px;
	--beside-button-font-size: 16px;
	
	&.no-left-column {
		.chat-columns {
			.left-column {
				left: -100%;
			}

			.center-column {
				right: 0;
			}
		}
		
		.header {
			border-top-left-radius: var(--chat-border-radius);
			border-left: none;
			padding-left: 10px;
			padding-right: 10px;

			.header-buttons {
				.header-button--toggleLeft {
					display: flex;
				}
				.header-button--bars {
					display: none;
				}
			}
		}
	}
		
	.chat-wallpaper {
		.default-wallpaper {
			.pattern {
				background-size: 100%;
			}
		}
	}
	
	.chat-columns {
		position: relative;
		
		.left-column {
			max-width: 100% !important;
			width: 100% !important;
			border-top-right-radius: var(--chat-border-radius);
			border-bottom-right-radius: var(--chat-border-radius);
			.m-fillAbsolute();
			transition: left .15s;
			left: 0;
			right: unset;
			z-index: 1;
		}

		.center-column {
			width: 100%;
			.m-fillAbsolute();
			transition: right .15s;
			right: -100%;
			left: unset;
			z-index: 2;
		}
	}
	
	.room {
		transition: none;
	}
	
	.communication-content .messages {
		.message-list-wrapper {
			padding-left: 10px;
			padding-right: 10px;
		}
		
		.content-icon.group-content-icon {
			.avatar {
				.m-avatarSize(@avatar-xs);
			}
		}
		
		.message {
			.content-bubble-container {
				margin-left: 38px;
			}
		}
	}
	
	.chat-message-form,
	.chat-message-form.chat-message-form--wallpaper {
		min-width: unset;
	}

	.message-editor {
		margin-bottom: 10px;
		
		.ql-button.ql-button--avatar {
			display: none;
		}
	}
}

.m-fillAbsolute() {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 100%;
}';
	return $__finalCompiled;
}
);