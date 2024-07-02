<?php
// FROM HASH: ef9e9781776e3c5d5fbd60d447e9267c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('real_time_chat_setup.less', $__vars) . '

.chat-popup-container {
	position: absolute;
	left: 0;
	top: 0;
}

.chat-popup {
	position: fixed;
	bottom: 5px;
	right: 16px;
	width: 600px;
	min-width: 450px;
	box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
	overflow: hidden;
	border-radius: 16px;
	height: 70vh;
	resize: both;
	display: flex;
	flex-direction: column;
	animation: chat-popup-scale .25s forwards;
	transition: height .25s;
	z-index: 900;
	
	&.is-closing {
		animation: chat-popup-scale-close .25s forwards;
	}

	&.is-collapsed {
		height: 56px !important;
		resize: none;
		
		.real-time-chat.compact {
			.header-buttons {
				.header-button {
					&.header-button--toggleLeft,
					&.header-button--roomMenu {
						width: 0;
						padding: 0;
						transform: scale(0);
						overflow: hidden;
					}
				}

				.collapse-icon {
					transform: rotate(0deg);
				}
			}
			
			.communication-content {
				.content-inner {
					height: 0;
					overflow: hidden;
				}
			}
		}
	}	
	
	&.is-loading {
		display: none;
	}
	
	.real-time-chat.compact {
		height: 100%;
		--chat-border-radius: 0;
		box-shadow: none;
		transition: height .25s;
		
		.connecting-container {
			padding: 7px 0;
		}

		.header {
			font-size: 18px;

			.collapse-icon {
				transform: rotate(180deg);
			}
			
			.header-main {
				cursor: move;
			}
			
			.avatar-container {
				position: relative;

				.badge--popup {
					position: absolute;
					right: -7px;
					top: 0;
					--size: 18px;
					font-size: 11px;
				}
			}

			&.header--popup {
				display: flex;
				margin-top: -10px;
				z-index: 100;
				position: relative;
				box-shadow: none;
				border-bottom: 1px solid var(--border-color);
				margin-bottom: 12px;

				.header-main {
					padding-left: 0;
					height: 100%;
					display: flex;
					align-items: center;
				}

				.badge--popup {
					margin-left: 5px;
					--size: 18px;
					font-size: 12px;
					margin-top: 0;
				}
			}

			.header-buttons {
				.collapse-icon {
					transition: transform .25s;
				}
				
				.header-button {
					&.header-button--toggleLeft,
					&.header-button--roomMenu {
						transition: all .25s;
					}
						
					// show popup buttons
					&.header-button--popup {
						display: flex;
					}
				}
			}
		}

		.communication-content {
			.content-inner {
				transition: height .25s;
			}
		}
	}
	
	@media (max-width: 750px) {
		width: 100% !important;
		top: unset !important;
		bottom: 0 !important;
		right: 0 !important;
		left: 0;
		border-radius: 0;
		min-width: unset;
		
		&:not(.is-collapsed) {
			height: 100% !important;
			
			.collapse-icon {
				transform: rotate(0deg) !important;
			}
		}
		
		&.is-collapsed {
			.collapse-icon {
				transform: rotate(180deg) !important;
			}
		}
		
		.real-time-chat.compact {
			height: ~"calc(var(--vh, 1vh) * 100)";
		}
	}
}

.button--rtcPopup {
	.m-chatButton();
	width: 60px;
	height: 60px;
	right: 8px;
	bottom: 16px;
	border-radius: 50%;
	background: @xf-buttonPrimaryBg;
	position: fixed;
	color: contrast(@xf-buttonPrimaryBg);
	font-size: 27px;
	cursor: pointer;
	box-shadow: rgba(0, 0, 0, 0.3) 0px 4px 12px 0px;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: all .15s;
	transform: scale(1);
	
	&.is-popup-open {
		transform: scale(0);
	}
}

@keyframes chat-popup-scale {
	0% {
		transform: scale(0);
	}
	100% {
		transform: scale(1);
	}
}

@keyframes chat-popup-scale-close {
	0% {
		transform: scale(1);
	}
	100% {
		transform: scale(0);
	}
}';
	return $__finalCompiled;
}
);