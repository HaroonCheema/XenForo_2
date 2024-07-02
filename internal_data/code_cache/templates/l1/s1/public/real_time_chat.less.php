<?php
// FROM HASH: 38dae173539862b2026e0216027146a0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('real_time_chat_setup.less', $__vars) . '

.real-time-chat {
	.xf-rtcContainer();
	font-family: var(--chat-font-family);
	--chat-border-radius: @xf-rtcContainer--border-radius;
	border-radius: var(--chat-border-radius);

	a,
	a.bbCodeBlock-sourceJump,
	a:hover,
	a.bbCodeBlock-sourceJump:hover {
		color: var(--link-color);
		text-decoration: none;
	}
	
	.text-primary {
		color: var(--primary-color) !important;
	}
	
	.text-details {
		color: var(--details-color) !important;
	}

	.chat-columns {
		display: flex;
		height: 100%;
		max-height: 100%;
		min-height: 100%;
		overflow: hidden;
		position: relative;
		width: 100%;

		.left-column {
			.xf-rtcRoomList();

			&:after {
				background-color: var(--border-color);
				content: " ";
				display: block;
				height: 100%;
				position: absolute;
				top: 0;
				right: -1px;
				width: 1px;
				z-index: 3;
			}
		}

		.center-column {
			height: 100%;
			width: 100%;
			position: relative;
			z-index: 5;
			flex: 2;
			overflow: hidden;
		}
	}
	
	&.no-left-column {
		.header {
			border-left: none;
			border-top-left-radius: var(--chat-border-radius);
		}
		
		.chat-wallpaper {
			border-top-left-radius: var(--chat-border-radius);
			border-bottom-left-radius: var(--chat-border-radius);
		}
		
		.left-column {
			width: 0;
			max-width: 0;
			
			&:after {
				width: 0;
			}
			
			.content-loader.is-active {
				display: none;
			}
		}
		
		.messages .message-list-wrapper {
			padding-left: 20px;
			padding-right: 20px;
		}
	}
	
	&.connected {
		.pinned-notices {
			display: block;
		}
	}
	
	.left-column-header {
		display: none;
		padding: 0 .5rem .5rem;
		width: 100%;
		
		.back-to-home-btn {
			.m-chatButton();
			border: 1px solid var(--border-color);
			color: var(--primary-color);
			background: var(--surface-color);
			box-shadow: none;
			transition: all .25s;
			
			.button-text {
				display: flex;	
				align-items: center;
				transition: all .25s;
			}

			.button-text--inner {
				transition: all .25s;
				padding-left: 5px;
			}

			&:hover,
			&:active,
			&:focus {
				background: var(--primary-color-light-filled);
			}
		}
	}

	.communication-content {
		display: flex;
		flex-direction: column;
		height: 100%;
		width: 100%;
		z-index: -2;
		position: relative;

		.content-inner {
			display: flex;
			flex-direction: column;
			height: 100%;
			width: 100%;
			position: relative;
		}
	}

	.chat-wallpaper {
		.m-fillAbsolute();
		z-index: -1;
		border-top-right-radius: var(--chat-border-radius);
		border-bottom-right-radius: var(--chat-border-radius);
		overflow: hidden;
		transition: border-radius .2s;
		
		.default-wallpaper {
			.m-fillAbsolute();
			z-index: 1;
			.chat-canvas-gradient {
				position: absolute;
				height: 100%;
				width: 100%;
				-webkit-mask-position: center;
				mask-position: center;
				-webkit-mask-size: cover;
				mask-size: cover;
			}
			.chat-canvas-pattern {
				position: absolute;
				height: 100%;
				width: 100%;
				mix-blend-mode: soft-light;
				opacity: .5;
			}
			&.is-dark {
				.chat-canvas-pattern {
					mix-blend-mode: darken;
				}
			}
		}

		.custom-wallpaper {
			.m-fillAbsolute();
			z-index: 2;
			background-image: var(--wallpaper-image);
			background-size: var(--wallpaper-size);
			background-repeat: var(--wallpaper-repeat);
			background-position: center;
			filter: var(--wallpaper-filter);
			-webkit-filter: var(--wallpaper-filter);
			transform: scale(1.05);
		}
	}

	.chat-form {
		width: 100%;
		height: 100%;
		z-index: 150;
		overflow: hidden;
		display: flex;
		justify-content: start;
		flex-direction: column;
		background: var(--surface-color);
		padding: 0 25px;

		.title {
			.xf-rtcChatFormTitle();
		}

		.return-back {
			.xf-rtcChatFormReturnBack();
		}
		
		.form-body {
			display: flex;
			flex-direction: column;
			flex: 1 1 auto;
			
			> div {
				margin: 0 auto;
			}
		}
		
		.form-body-content {
			padding: 0 0 10px;
			width: 100%;
			
			&.form-body-content--big {
				max-width: 720px;
			}
			
			.input {
				.m-chatInput();
				margin-bottom: 10px;

				&:last-child {
					margin-bottom: 0;
				}
				
				&.select2-selection {
					padding: 7px 11px;
				}
			}
			
			.input-line,
			.select2 {
				margin-bottom: 10px;
			}

			.input,
			.quill-editor-container {
				background: transparent;
				border-color: var(--border-color);
				border-radius: var(--chat-input-border-radius);
			}
		}
		
		.form-submit {
			width: 100%;
			display: flex;
			flex-wrap: wrap;
			
			.button {
				.m-chatButton();
			}
		}
	}

	.chat-header-input {
		display: flex;
		background: none !important;
		box-shadow: none !important;
		padding: 0 !important;
		border: none !important;

		.avatar-box {
			margin-right: 7px;
			position: relative;
			border: 1px solid var(--border-color);
			border-radius: 50%;

			.upload-input {
				cursor: pointer;
				opacity: 0;
				position: absolute;
				left: 0;
				top: 0;
				bottom: 0;
				right: 0;
				width: 100%;
				height: 100%;
			}
		}

		.rtc-room-avatar {
			color: inherit;
			background: transparent;
			border-radius: var(--chat-input-border-radius);
		}
	}
	
	.tag-input {
		display: flex;
		align-items: center;

		.tag-prefix {
			margin-right: .5px;
			white-space: nowrap;
		}

		.input {
			background: none !important;
			box-shadow: none !important;
			padding: 0 !important;
			margin: 0 !important;
			border: none !important;
			font-weight: 500;
		}
	}
	
	.room-list,
	.room-items,
	.scrollable {
		width: 100%;
	}
	
	.room-items {
		z-index: 10;
	}

	.room-items-container {
		padding: 0 5px;
	}
	
	.rooms-placeholder {
		opacity: 0;
		visibility: hidden;
		display: none;
		transition: opacity .25s ease-in-out;
		margin: 0 auto;
		padding: 0 16px;
		position: relative;
		text-align: center;
		top: 40%;
		transform: translateY(-50%);
		z-index: 30;

		&.visible {
			opacity: 1;
			visibility: visible;
			display: block;
		}
		
		.placeholder-icon {
			margin-bottom: 17px;
		}
		
		.placeholder-title {
			font-size: 20px;
			font-weight: 500
		}
	}
	
	.btn-corner {
		.xf-rtcCornerButton();
	}
	
	.room {
		.xf-rtcRoom();

		&.selected {
			.xf-rtcRoomSelected();

			.room-title,
			.room-latest-message,
			.room-latest-message.type--system,
			.room-extraInfo,
			.room-latest-message .text-highlight,
			.room-latest-message .typer {
				color: var(--primary-color-contrast);
			}
			
			.room-latest-message .typer .dots .dot {
				background: var(--primary-color-contrast);
			}

			.room-extraInfo {
				.extra-item--attention {
					color: var(--primary-color-contrast);
				}
			}

			.badge--unread {
				background: var(--surface-color);
				color: var(--primary-color);
			}
		}
		
		&:not(.selected):hover {
			.xf-rtcRoomHovered();
		}
		
		.rtc-room-avatar {
			.xf-rtcRoomAvatar();
		}
		
		.room-title-with-markers {
			display: flex;
			white-space: nowrap;
		}

		.room-title {
			.xf-rtcRoomTitle();
			.m-overflowEllipsis();
		}

		.room-content {
			flex: 1;
			padding-left: 10px;
			overflow: hidden;
		}

		.room-latest-message {
			.xf-rtcRoomLatestMessage();
			
			&.type--system,
			.text-highlight,
			.typer {
				color: var(--primary-color);
			}
			
			.typer .dots .dot {
				background: var(--primary-color);
			}
			
			.message-sender {
				padding-right: 2px;
				white-space: nowrap;
			}
			
			.message-text {
				display: flex;
				overflow: hidden;
			}

			.bbWrapper {
				.m-overflowEllipsis();
			}
		}
		
		&.is-typing {
			.room-latest-message {
				.message-text {
					display: none;
				}

				.typer {
					display: block;
				}
			}
		}

		.room-extra {
			margin-left: auto;
			padding-left: 5px;
			display: flex;
			align-items: center;
			font-weight: normal;
		}

		.room-extraInfo {
			.xf-rtcRoomExtraInfo();
			
			li {
				margin-left: 5px;
				
				&:first-child {
					margin-left: 0;
				}
			}
			
			.extra-item {
				.xf-rtcRoomExtraItem();	

				&--attention {
					.xf-rtcRoomExtraItemAttention();
				}
			}
		}
		
		.read-mark {
			display: none;
		}
		
		.badge--unread {
			margin-top: -2px;
		}
	}
	
	.typer {
		width: 100%;
		display: none;
		overflow: hidden;
		
		.typer--activity {
			display: flex;
			align-items: center;
		}

		.typers {
			margin-left: 5px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.dots {
			display: flex;
			opacity: 1;
			line-height: inherit;
			-o-transition: opacity 350ms linear;
			transition: opacity 350ms linear;

			.dot {
				&:nth-child(2) {
					-o-animation-delay: 0.36666667s;
					animation-delay: 0.36666667s;
				}

				&:nth-child(3) {
					-o-animation-delay: 0.73333333s;
					animation-delay: 0.73333333s;
				}

				display: inline-block;
				vertical-align: top;
				width: 4px;
				height: 4px;
				border-radius: 50%;
				opacity: 0.2;

				margin-right: 3px;
				background: @xf-rtcRoomStatus--color;
				vertical-align: middle;
				-o-animation: 1.1s linear 0s infinite typer;
				animation: 1.1s linear 0s infinite typer;
			}
		}
	}

	.tag {
		font-weight: 500;
	}
	
	.badge {
		--size: 22px;
		--padding: 7px;
		background: var(--primary-color);
		border-radius: ~"calc(var(--size)/2)";
		color: #fff;
		font-size: 14px;
		font-weight: 500;
		height: var(--size);
		line-height: var(--size);
		min-width: var(--size);
		padding: 0 var(--padding);
		text-align: center;
		position: relative;

		transition: transform .25s;
		transform: scale(1);

		&.is-hidden {
			transition: none;
			transform: scale(0);
			position: absolute;
		}
	}

	.room-name {
		display: flex;
		align-items: baseline;
	}

	.room-status {
		.title,
		.typer {
			.xf-rtcRoomStatus();
		}

		&.is-typing {
			.title {
				display: none;
			}

			.typer {
				display: block;
			}
		}
	}

	.header {
		.xf-rtcHeader();
		border-top-right-radius: var(--chat-border-radius);
		transition: border-radius .2s;
		
		&.is-shown {
			display: flex;
		}
		
		&.header--popup {
			display: none;
		}
		
		.header-main {
			flex: 1;
			padding-left: 18px;
			line-height: 20px;
			.m-overflowEllipsis();
			
			.room-main {
				display: inline-flex;
				color: inherit;

				.m-overflowEllipsis();
				max-width: 100%;
				
				.tag {
					.m-overflowEllipsis();
				}
			}
			
			.room-name {
				.m-overflowEllipsis();
			}
		}

		.header-buttons {
			height: 100%;
			display: flex;

			.header-button {
				.xf-rtcHeaderButton();
				
				&--pl-sm {
					padding-left: 5px;
				}

				&.header-button--toggleLeft {
					display: none;
				}
				
				&.header-button--popup {
					display: none;
				}

				&:hover {
					.xf-rtcHeaderButtonHover();
				}

				&:last-child {
					margin-right: 0;
				}
			}
		}
		
		.header-avatar {
			.rtc-room-avatar,
			.avatar {
				width: 42px;
				height: 42px;
				font-size: 23px;
			}
		}
	}

	.connecting-container {
		padding: 15px 0;
		display: flex;
		justify-content: center;
		position: absolute;
		top: 0;
		width: 100%;
		
		.connecting-notice {
			.xf-rtcConnectingNotice();
		}
	}

	.pinned-notices {
		.xf-rtcPinnedNotices();
		display: none;
		
		&.is-hidden {
			display: none;
		}

		.pinned-notice {  
			display: flex;
			.xf-rtcPinnedNotice();
			
			.content {
				flex: 1 1 auto;
			}
			
			.notice-closer {
				color: @xf-rtcHeaderButton--color;
				cursor: pointer;
			}
		}
	}
	
	.room-list {
		height: 100%;
		width: 100%;
		display: flex;
		flex-direction: column;
		position: relative;
		
		.default-rooms {
			margin-bottom: 10px;
		}
		
		.content-loader--top {
			padding-top: 0;
		}
	}

	.scrollable-container {
		flex: 1 1 auto;
		position: relative;
		height: 100%;
	}
	
	.scrollable {
		display: block;
		height: auto;
		-ms-overflow-style: none;
		overflow-x: hidden;
		overflow-y: auto;
		overflow-y: overlay;
		scrollbar-color: transparent transparent;
		scrollbar-width: thin;
		// fix brave
		// https://community.brave.com/t/scrollbar-width-not-working/464113
		&::-webkit-scrollbar { display: none; }
		position: absolute;
		left: 0;
		bottom: 0;
		right: 0;
		top: 0;
		width: 100%;
		
		&.is-scrolling {
			.messages-group.has-sticky-dates {
				.messages-group-title {
					opacity: .99999;
				}
			}
		}
	}

	.messages {
		z-index: 1;

		.message-list-wrapper {
			display: flex;
			flex-direction: column;
			justify-content: end;
			margin: 0 auto;
			width: 100%;
			min-height: 100%;
			padding-left: 10px;
			padding-right: 10px;
			transition: padding .25s;

			.xf-rtcMessagesWrapper();

			&:after {
				content: " ";
				height: 2px;
			}
		}

		.messages-group {
			margin-bottom: 6px;
			position: relative;
			
			&.has-sticky-dates {
				.messages-group-title {
					opacity: .00001;
				}
			}
			
			.sticky_sentinel {
				left: 0;
				pointer-events: none;
				position: absolute;
				right: 0;
				visibility: hidden;
				
				&--top {
					height: .25rem;
					top: 0;
				}
			}
			
			.messages-group-title {
				position: sticky;
				top: 4px;
				z-index: 20;
				margin: 0 auto;
				transition: opacity .3s ease;
				pointer-events: none;
			}
			
			.messages-group-content {
				display: flex;
				flex-direction: column;
			}
			
			&.messages-group--day:last-child {
				margin-bottom: 0;
				
				.messages-group:last-child {
					margin-bottom: 0;
				}
			}

			.message:last-child {
				margin-bottom: 0;	
			}

			.content-icon.group-content-icon {
				display: flex;
			}
			
			.message {
				&:not(:first-child) {
					.content-author {
						display: none;
					}
				}
				
				&:not(:last-child) {
					.bubble-tail {
						display: none;
					}
				}

				&:not(.is-visitor) {
					&:not(:first-child) {
						.content-bubble-container .content-bubble {
							border-top-left-radius: @xf-rtcMessageBubble--border-radius / 2;
						}
					}

					&:not(:last-child) {
						.content-bubble-container .content-bubble {
							border-bottom-left-radius: @xf-rtcMessageBubble--border-radius / 2;
						}
					}
				}

				&.is-visitor {
					&:not(:first-child) {
						.content-bubble-container .content-bubble {
							border-top-right-radius: @xf-rtcMessageBubble--border-radius / 2;
						}
					}

					&:not(:last-child) {
						.content-bubble-container .content-bubble {
							border-bottom-right-radius: @xf-rtcMessageBubble--border-radius / 2;
						}
					}
				}
			}
			
			.content-icon {
				bottom: 0;
				display: none;
				flex-direction: column-reverse;
				left: 0;
				pointer-events: none;
				position: absolute;
				right: 0;
				top: 0;
				z-index: 20;

				.avatar {
					cursor: pointer;
					pointer-events: all;
					position: sticky;
					top: 0;
					border-radius: 100%;
					bottom: .25rem;
				}

				.avatar.avatar--s {
					font-size: 27px;
					width: 40px;
					height: 40px;
				}
			}
		}

		.message {
			color: var(--message-text-color);
			display: flex;
			border: none;
			position: relative;
			
			.xf-rtcMessage();

			&:after {
				background: var(--highlighted-message-bg);
				position: absolute;
				left: -50%;
				right: -50%;
				top: -4px;
				bottom: -4px;
				content: \' \';
				z-index: -1;
				opacity: 0;
				transition: opacity .25s;
			}

			&.message--system {
				justify-content: center;
				margin-bottom: 6px;
				
				.message-text {
					.xf-rtcSystemMessage();
					
					a {
						color: inherit;
					}
				}
			}

			&.is-highlight {
				&:after {
					opacity: 1;
				}
			}
			
			&.is-removing {
				transform: translateX(-100%);
			}

			&.is-visitor {
				--details-color: var(--visitor-details-color);
				--bubble-background: var(--visitor-bubble-background);
				--message-text-color: var(--visitor-message-text-color);
				--input-bg-color: var(--visitor-form-input-bg-color);
				--primary-color-light-filled: var(--visitor-primary-color-light-filled);

				&.is-removing {
					transform: translateX(100%);
				}
				
				flex-direction: row-reverse;
				
				.content-icon {
					display: none;
				}
				
				.content-author {
					display: none;
				}
				
				.content-bubble-container {
					margin-left: 0;

					.content-bubble {
						border-bottom-right-radius: 0;
					}
				}
				
				.beside-buttons {
					left: var(--beside-buttons-margin);
					right: unset;
				}

				.message-markers {
					margin-left: -4px;
					padding-right: 0;
					
					.markers-inner {
						bottom: 4px;
						padding-right: 0;
					}
					
					.time:after {
						.m-faContent(@fa-var-check);
					}
				}
				
				.bubble-tail {
					right: -8.4px;
					transform: translateY(1px) scaleX(-1);
					
					& when (@rtl) {
						transform: translateY(1px);
					}
				}
			}
			
			&:not(.is-visitor) {
				.content-bubble {
					border-bottom-left-radius: 0;
				}
				
				.message-markers {
					margin-left: -4px;
					
					.markers-inner {
						margin-bottom: 4px;
					}
				}
				
				.bubble-tail {
					& when (@rtl) {
						transform: translateY(1px) scaleX(-1);
					}
				}
			}

			&.is-sending {
				.message-markers {
					.time:after {
						.m-faContent(@fa-var-clock);
					}
				}
				
				blockquote {
					&[data-quote] {
						&:before {
							content: attr(data-quote) " ' . 'said' . $__templater->escape($__vars['xf']['language']['label_separator']) . '";
							color: var(--primary-color);
							font-weight: 500;
						}
					}
				}
			}
			
			&.is-pm {
				.xf-rtcPrivateMessageBubble();
			}
			
			&.is-form {
				--bubble-background: var(--highlighted-message-bg);
				--input-bg-color: var(--highlighted-message-bg);
				--form-input-bg-color: var(--highlighted-message-bg);
				--details-color: rgba(255, 255, 255, .75);
				--primary-color: #fff;
				color: #fff;
				
				a {
					color: #fff;
				}
				
				.content-bubble-container {
					width: 350px;
					
					.content-bubble {
						border-bottom-left-radius: @xf-rtcMessageBubble--border-radius;
						border-bottom-right-radius: @xf-rtcMessageBubble--border-radius;
					}
				}

				.bubble-tail {
					display: none;
				}
				
				.input {
					background: var(--highlighted-message-bg);
					color: #fff;
					border: none;

					&::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
						color: rgba(255, 255, 255, .65);
						opacity: 1; /* Firefox */
					}

					&:-ms-input-placeholder { /* Internet Explorer 10-11 */
						color: rgba(255, 255, 255, .65);
					}

					&::-ms-input-placeholder { /* Microsoft Edge */
						color: rgba(255, 255, 255, .65);
					}
				}
			}

			&.has-been-read {
				.message-markers {
					.time {
						&:after {
							.m-faContent(@fa-var-eye);
						}
					}
				}
			}
			
			&.has-actions {
				.content-bubble-container {
					.content-bubble {
						border-bottom-left-radius: 6px;
						border-bottom-right-radius: 6px;
					}
				}
			}
			
			&:hover {
				.beside-buttons {
					opacity: 1;
				}
			}
			
			.content-author {
				font-size: 14px;
				font-weight: 500;
			}

			.content-bubble-container {
				max-width: 69%;
				position: relative;
				margin-left: 45px;
			}

			.content-bubble {
				position: relative;
				display: flex;
				flex-direction: column-reverse;
				.xf-rtcMessageBubble();
				
				&.has-footer {
					.message-markers {
						display: block;
					}
				}
			}

			.beside-buttons {
				--beside-buttons-count: ' . ($__vars['xf']['options']['realTimeChatEnabledBbCodes']['quote'] ? 2 : 1) . ';				
				--beside-buttons-width: ~"calc(var(--beside-button-size) * var(--beside-buttons-count))";
				--beside-buttons-margin-abs: ~"calc(var(--beside-buttons-width) + 7px)";
				--beside-buttons-margin: ~"calc(var(--beside-buttons-margin-abs) * -1)";
				
				position: absolute;
				right: var(--beside-buttons-margin);
				bottom: 0;
				display: flex;
				gap: 4px;
				transition: opacity .2s ease-in-out,transform .2s ease-in-out;
				opacity: 0;

				.btn {
					align-items: center;
					background: var(--highlighted-message-bg);
					border-radius: 50%;
					color: #fff;
					cursor: pointer;
					display: flex;
					font-size: var(--beside-button-font-size);
					height: var(--beside-button-size);
					justify-content: center;
					transform: translateX(0);
					width: var(--beside-button-size);
					-webkit-tap-highlight-color: rgba(0,0,0,0);
					-webkit-tap-highlight-color: transparent;
				}
			}

			.bubble-actions {
				display: flex;
				flex-direction: column;
				margin-top: 4px;
				
				.button-group {
					display: flex;
					gap: 4px;
					margin-bottom: 4px;
					
					&:last-child {
						margin-bottom: 0;
					}
					
					.button {
						margin-bottom: 0;
						flex: 1;
					}
				}
				
				.button {
					display: block;
					color: #fff;
					width: auto;
					border: none;
					background: var(--highlighted-message-bg);
					padding: 10px;
					font-weight: 500;
					font-size: var(--message-font-size);
					border-radius: 12px;
					font-family: var(--chat-font-family);
					margin-bottom: 4px;
					position: relative;
					
					&:last-child {
						margin-bottom: 0;
					}
					
					&:hover:after {
						opacity: 0.08;
					}
					
					&:after {
						background-color: #fff;
						border-radius: inherit;
						bottom: 0;
						content: " ";
						display: block;
						left: 0;
						opacity: 0;
						position: absolute;
						right: 0;
						top: 0;
						z-index: -1;
					}
				}
			}
			
			.message-markers {
				direction: ltr;
				display: inline-flex;
				float: right;
				font-size: 12px;
				line-height: 1;
				pointer-events: none;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
				vertical-align: middle;
				visibility: hidden;
				z-index: 1;
				padding: 0;
				padding-right: 3px;

				> span {
					margin-right: 6px;
				}

				.markers-inner {
					align-items: center;
					bottom: 0;
					color: var(--details-color);
					display: flex;
					line-height: 1;
					padding: 0;
					pointer-events: all;
					position: absolute;
					right: 0;
					visibility: visible;
					white-space: nowrap;
					padding-right: 3px;
					
					> span {
						margin-right: 6px;
					}
				}
				
				.iconic {
					display: flex;
					
					& + .iconic {
						margin-left: -6px;
					}
					
					&:after {
						.m-faBase();
						padding-left: 2px;
					}
				}

				.italic {  
					font-style: italic;
				}
				
				.bold {
					font-weight: 600;
				}
				
				.translation-error:after {
					.m-faContent(@fa-var-exclamation-circle);
				}
			}
			
			.message-footer {
				display: flex;
				flex-wrap: wrap;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;

				.reactionsBar {
					position: relative;
					.xf-rtcMessageReactionsBar();
					margin-top: 3px;
					margin-right: 6px;

					&:hover {
						&:after {
							background-color: @xf-rtcMessageReactionsBar--background-color;
							border-radius: inherit;
							bottom: 0;
							content: " ";
							left: 0;
							opacity: .3;
							position: absolute;
							right: 0;
							top: 0;
							z-index: 0;
						}
					}
					
					.reactionSummary {
						height: auto;
						line-height: 1;
						padding-left: 1px;
						
						li {
							padding: 0;
							background: none;
							height: 21px;
							width: 21px;
						}
						
						.reaction {
							transform: scale(0.9);
							top: 1px;
						}
					}
					
					.reactionsBar-link {
						font-weight: 500;
						text-decoration: none;
						margin-left: 2px;
						z-index: 2;
						position: relative;
						color: var(--primary-color);
						
						&:hover {
							color: var(--primary-color);
						}
					}
				}
			}

			.bbWrapper {
				display: inline;
				
				p {
					margin: 0;
					
					&:first-child {
						display: inline;
					}
				}
				
				blockquote {
					margin: 0;
					margin-top: 4px;
				}
				
				.mention {
					padding: 0;
					margin: 0;
					color: var(--primary-color);
					
					> span {
						margin: 0;
					}
				}

				a.username {
					color: var(--primary-color);	
				}
				
				.bbMediaWrapper, .bbMediaJustifier, .bbOembed {
					width: unset;
				}
				
				.bbMediaWrapper {
					padding-left: 10px;
					border-left: 2px solid var(--primary-color);
					position: relative;
					
					.imgur-embed-iframe-pub {
						margin-left: -10px !important;
						padding-left: 10px !important;
					}
				}

				.imgur-embed-iframe-pub {
					border-radius: 0;
					margin-top: 3px !important;
					box-shadow: none;
					margin-bottom: 0 !important;
					border: none;
				}

				.bbImage {
					max-height: 300px;
				}
				
				.fauxBlockLink-blockLink {
					&:before {
						display: none;
					}
				}
			}
		}
	}

	.bbCodeBlock {
		margin: 0;
		margin-top: 4px;
		overflow: hidden;
		background: none;
		border-radius: 0;
		border: none;
		border-left: 2px solid var(--primary-color);
		padding-left: 8px;
		padding-top: 0;
		padding-bottom: 0;
		
		.bbCodeBlock-title {
			padding: 0;
			color: var(--primary-color);
			font-weight: 500;
			background: none;
			font-size: ~"calc(var(--message-font-size) - 1px)";
			line-height: 1;
		}
		
		.bbCodeBlock-content {
			padding: 0;
			padding-top: 2px;
			font-size: ~"calc(var(--message-font-size) - 1px)";
			background: none;
		}

		.bbCodeCode {
			padding-bottom: 0;
			font-size: ~"calc(var(--message-font-size) - 1px)";
		}
		
		.bbCodeBlock-expandLink {
			top: 80px;
			background: linear-gradient(to bottom, rgba(245,245,245,0) 0%, var(--bubble-background) 60%);
			
			a {
				color: var(--details-color);
			}
		}
	}
	
	.message-attachments {
		overflow: hidden;
		margin: -4px -10px 0;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
		
		.attachmentList {
			display: block;
		}
		
		.block-textHeader {
			display: none;
		}
		
		.attachUploadList {
			.file {
				.file-insert {
					display: none;
				}
				
				.file-delete {
					display: none;
				}
			}
		}
		
		.file {
			display: flex;
			align-items: center;
			background: none;
			padding: .25rem 10px;
			
			&:first-child {
				padding-top: .5rem;
			}
			
			&:last-child {
				padding-bottom: .5rem;
			}
			
			&:after {
				padding-bottom: 0;
			}
			
			.file-content {
				overflow: hidden;
			}
			
			.file-preview,
			.file-content,
			.file-info {
				position: unset;
				top: unset;
				left: unset;
			}
			
			.file-preview {
				--file-preview-size: 54px;
				
				height: var(--file-preview-size);
				width: var(--file-preview-size);
				max-height: var(--file-preview-size);
				max-width: var(--file-preview-size);
				min-width: var(--file-preview-size);
				min-height: var(--file-preview-size);
				border-radius: 4px;
				overflow: hidden;
				flex-basis: 100%;
				
				&:after {
					position: absolute;
					width: 100%;
					height: 100%;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
				}
				
				img,video {
					position: relative;
					left: unset;
					top: unset;
					height: 100%;
					width: 100%;
				}
			}

			.file-info {
				background: no-repeat;
				color: unset;
				text-shadow: none;
				line-height: 1.4;
				height: 100%;
				font-size: unset;
				display: inline-block;
			}
			
			.file-name {
				font-weight: 500;
			}
			
			.file-meta {
				color: var(--details-color);
			}

			.file-typeIcon {
				font-size: 50px;
			}
		}
	}

	.content-loader {
		width: 100%;
		text-align: center;
		display: none;
		position: absolute;
		z-index: 10;
		
		&--top {
			top: 0;
			padding-top: 15px;
		}
		
		&--bottom {
			bottom: 0;
		}
		
		&.is-active {
			display: block;
		}

		.spinner {
			opacity: 1;
			width: 48px;
			height: 48px;
			border: 5px solid var(--highlighted-message-bg);
			border-bottom-color: transparent;
			border-radius: 50%;
			display: inline-block;
			box-sizing: border-box;
			animation: rotation 1s linear infinite;
		}
	}

	.ctrls {
		display: flex;

		.column {
			flex: 0 0 auto;
			vertical-align: middle;
		}
	}

	.action-buttons {
		display: flex;
	}
	
	.message-editor {
		display: flex;
		justify-content: center;
		max-width: 720px;
		margin: 0 auto 15px;
		width: 100%;
		padding-top: 4px;
		padding-left: 10px;
		padding-right: 10px;
		
		&:not(.is-shown) {
			opacity: 0;
			visibility: hidden;
			height: 5px;
		}

		.bubble-tail {
			right: -8.4px;
			transform: translateY(1px) scaleX(-1);

			& when (@rtl) {
				transform: translateY(1px);
			}
		}
		
		.attachmentUploads {
			padding-bottom: 10px;
			border-bottom: 1px solid var(--border-color);
			margin-bottom: 0;
		}

		.quill-editor-container {
			--editor-background: var(--surface-color);
			--bubble-background: var(--editor-background);
			box-shadow: 0 1px 8px 1px rgba(0,0,0,.12);
			border: none;
			width: ~"calc(100% - 54px)";
			max-width: ~"calc(100% - 54px)";
			transition: border-radius .8s;
			border-radius: 1rem;
			border-bottom-right-radius: 0;

			.ql-editor {
				border: none;
				max-height: 88px;
				
				blockquote[data-quote] {
					&:before {
						color: var(--primary-color);
						background: none;
						padding: 0;
						font-weight: 500;
					}
					
					.bbCodeBlock-remove {
						padding: 0;
					}
				}
			}
			
			.ql-button {
				color: var(--surface-color-secondary);
				height: 100%;
				padding-top: 0;
				padding-bottom: 0;
				display: flex;
				align-items: center;
				overflow: hidden;
			}
			
			.ql-button.ql-button--avatar {
				.avatar {
					width: 21px;
					height: 21px;
				}
			}
			
			.ql-picker-options {
				margin-top: -100px;
			}
		}

		.btn-send-container {
			padding-left: 5px;
			display: flex;
			align-items: end;
			
			.btn-send {
				.xf-rtcSendButton();
				
				&.is-disabled {
					opacity: .7;
				}
				
				&:hover {
					background: var(--primary-color-darken);
				}
			}
		}
		
		.attachUploadList {
			padding: 10px 16px 0;
		}

		.file {
			background: none;
			width: 80px;
			height: 80px;
			border-radius: 6px;
			overflow: hidden;
			
			a {
				color: #fff;
			}
		}
		
		.file-insert {
			display: none;
		}
		
		.mention {
			padding: 0;
			margin: 0;
			background: none;
			
			> span {
				margin: 0;
				color: var(--primary-color);
			}
		}
	}
	
	.chat-command {
		&.is-pinned {
			.action.action--commandPin {
				color: var(--primary-color);
			}
		}
	}
	
	.message-action-container-wrapper {
		display: none;
	}
	
	.message-action-container {
		display: flex;
		padding: 10px;
		border-bottom: 1px solid var(--border-color);

		.icon {
			display: flex;
			align-items: center;
			font-size: 17px;
			color: var(--primary-color);
			width: 22px;
			justify-content: center;
		}

		.content {
			padding-left: 7px;
			font-size: 14px;
			line-height: 1.3;
			overflow: hidden;

			.title {
				font-weight: 550;
				color: var(--primary-color);
			}
			
			.message-text {
				color: var(--surface-color-muted);
				opacity: .8;
				.m-overflowEllipsis();
				white-space: nowrap;
			}
		}

		.actions {
			display: flex;
			align-items: center;
			margin-left: auto;

			.action {
				height: 100%;
				display: flex;
				align-items: center;
				cursor: pointer;
				font-size: 21px;
				padding-right: 10px;
				padding-left: 10px;
				color: var(--surface-color-muted);
			}
		}
	}

	.bubble-tail {
		fill: var(--bubble-background);
		display: block;
		height: 20px;
		position: absolute;
		transform: translateY(1px);
		width: 11px;
		z-index: 10;
		margin-left: -8.4px;
		bottom: 0;
	}

	.ql-button {
		&.ql-button--attachment {
			position: relative;

			.button--link {
				text-indent: -9999px;
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				height: 100%;
				width: auto;
				opacity: 0;
				z-index: 20;
			}
		}
	}
	
	.chat-message-form {	
		min-width: 250px;
		padding-bottom: 5px;
		
		.chat-input {
			.m-chatInput();
			background: var(--form-input-bg-color);
		}
		
		.form-header {
			margin: 0;
			font-size: 16px;
			font-weight: 500;
			margin-bottom: 5px;
		}
		
		.form-body {
			> .input {
				.m-chatInput();
				background: var(--form-input-bg-color);
				padding: 10px 12px;
				margin-top: 5px;
				border-radius: 6px;
				
				.avatar-box {
					border: none;
				}

				.rtc-room-avatar {
					background: var(--form-input-bg-color);
					border-radius: 50%;
				}
			}
			
			.button {
				.m-chatButton();
			}
			
			> .inputChoices {
				margin-top: 5px;
			}
			
			.inputGroup {
				.input[type="number"], .input.input--number {
					max-width: 100px;
				}
				
				&.inputGroup--joined .inputGroup-text {
					color: var(--primary-color);
					background: var(--input-bg-color);
					border: none;
					width: 25px;
				}
			}
			
			.form-line {
				&.form-line--margined {
					margin-bottom: 10px;
					
					&:last-child {
						margin-bottom: 0;
					}
				}
			}

			.space-line {
				margin-top: 5px;
				
				&.space-line--md {
					margin-top: 10px;
				}
				
				&:first-child {
					margin-top: 0;
				}
			}
			
			.hScroller-scroll {
				scrollbar-color: transparent transparent;
				scrollbar-width: thin;
				
				// fix brave
				// https://community.brave.com/t/scrollbar-width-not-working/464113
				&::-webkit-scrollbar { visibility: hidden; }
			}
		}

		.form-submit {
			display: flex;
			padding-top: 10px;
			flex-direction: column;
			
			.button {
				.m-chatButton();
			}
		}
		
		.formRow {
			> dt {
				background: none;
				border-right: none;
				padding-top: 4px;
				padding-right: 0;
				padding-left: 0;
			}
			
			> dd {
				padding-top: 4px;
				padding-bottom: 4px;
			}
			
			&.formRow--input {
				> dt {
					padding-top : 10px;
				}
			}

			@media (max-width: @xf-formResponsive) {
				> dt {
					padding: 0;
					padding-bottom: 5px;
				}

				> dd {
					padding: 0;
					padding-bottom: 7.5px;
				}
			}
		}
	}

	.page-nav-submit {
		&.fix-double-brs {
			margin-top: -15px;
			padding-top: 0;
		}
	
		padding-top: 4px;
	
		.pageNav-page {
			padding: 0;
			border: none;
			box-shadow: none;
			background: none;
			padding-right: 5px;
			
			&:hover {
				> a:before {
					opacity: 1;
				}
			}
			
			> a {
				.m-chatButton();
				background: var(--highlighted-message-bg);
				z-index: 1;
				position: relative;
				
				&:before {
					content: \' \';
					.m-fillAbsolute();
					background: var(--highlighted-message-bg);
					z-index: -1;
					border-radius: inherit;
					opacity: 0;
				}
			}

			&.pageNav-page--current {
				> a:before {
					opacity: 1;
				}
			}
		}
		
		.pageNav-jump {
			.m-chatButton();
			position: relative;
			background: var(--highlighted-message-bg);

			&:before {
				content: \' \';
				.m-fillAbsolute();
				background: var(--highlighted-message-bg);
				z-index: -1;
				border-radius: inherit;
				opacity: 0;
				transition: opacity .2s;
			}
			
			&:hover {
				&:before {
					opacity: 1;
				}
			}
		}
	}

	.button,
	.button--primary {
		color: var(--primary-color-contrast);
		background: var(--primary-color);
		
		&:hover,
		&:focus {
			background: var(--primary-color-darken);
		}
	}
	
	.inputChoices-choice {
		i {
			&:after,
			&:before {
				color: var(--primary-color);
			}
		}
	}

	.hScroller-action {
		&:after {
			color: var(--highlighted-message-bg);
		}
	}

	.tabs--standalone .tabs-tab.is-active {
		color: var(--primary-color);
		border-color: var(--primary-color);
	}
	
	.m-chatResponsive(925px);
}

.has-touchevents {
	.real-time-chat {
		.messages .message {
			.content-bubble-container {
				max-width: ~"calc(100% - 5.5625rem)";
			}

			.beside-buttons {
				display: none;
			}
		}
	}
}

.rtc-slide-menu {
	position: relative;
	overflow: hidden;
	
	&.is-open {
		.left-slide {
			left: -100%;
		}

		.right-slide {
			right: 0;
		}
	}
	
	.left-slide {
		.m-fillAbsolute();
		transition: left .15s;
		left: 0;
		right: unset;
		z-index: 1;
	}
	
	.right-slide {
		width: 100%;
		.m-fillAbsolute();
		transition: right .15s;
		right: -100%;
		left: unset;
		z-index: 2;
	}
}

.rtc-flat-menu {
	margin-top: 0;
	border-radius: 20px;
	box-shadow: none !important;
	min-width: unset;
	background: none;
	text-align: right;
	z-index: 905 !important;
	
	.menu-arrow {
		display: none;
	}
	
	.menu-content {
		position: relative;
		z-index: 20;
		
		float: right;
		min-width: 105px;
		border-top: none;
		border-radius: 10px;
		margin-top: 1px;
		.m-dropShadow(0, 5px, 10px, 0, .35);
	}

	.menu-linkRow {  
		padding: 7px 8px;
		font-size: 14px;
		border-left: none;
		border-radius: 10px;
		margin: 3px;
		white-space: nowrap;
		
		.enter-icon {
			float: right;
			color: @xf-textColorMuted;
			padding-left: 15px;
			
			i {
				width: auto;
			}
		}
		
		&.menu-linkRow--warning {
			color: @xf-errorColor;
			
			&:hover {	
				background: @xf-errorBg;
			}
		}
	}
	
	.menu-reactions {
		position: relative;
	}

	.menu-linkReactions {
		position: relative;
		z-index: 10;
		
		display: inline-flex;
		padding: 3px 5px;
		background: @xf-contentBg;
		border-radius: 25px;
		.m-dropShadow(0, 5px, 10px, 0, .35);

		.message-react {
			border-radius: 25px;

			&.is-selected {
				background: darken(@xf-contentHighlightBg, 15%);
			}
		}

		.reaction {
			flex: 1;
			-webkit-transform: scale(.8);
			-ms-transform: scale(.8);
			transform: scale(.8);
			transition: transform .2s;
			
			&:hover {
				-webkit-transform: scale(1);
				-ms-transform: scale(1);
				transform: scale(1);
			}
		}
	}
}

.rtc-lightbox {
	z-index: 910 !important;
}

@keyframes typer {
	0% {
		opacity: 0.5;
	}
	25% {
		opacity: 1;
	}
	50% {
		opacity: 0.5;
	}
}

@keyframes rotation {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}';
	return $__finalCompiled;
}
);