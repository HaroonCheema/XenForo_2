<?php
// FROM HASH: 32956ff4291020b2f2af032cbc3e3618
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->includeTemplate('real_time_chat_setup.less', $__vars) . '

.template-xf_messenger_conversations {
	.real-time-chat.real-time-chat--xf-messenger {
		height: 600px;
		resize: vertical;

		@media (min-width: 925px) {
			.chat-columns {
				.left-column {
					max-width: 350px;
					width: 350px;
					align-items: start;
				}
				
				.messages .message-list-wrapper {
					padding-left: 20px;
					padding-right: 20px;
				}
			}
		}
	}
}

.real-time-chat.real-time-chat--xf-messenger {
	.chat-columns {
		.left-column {
			.xf-xfmRoomList();
		}
	}

	&.no-left-column {
		.header {
			border-top-left-radius: 0;
		}
		
		.chat-wallpaper {
			border-top-left-radius: 0;
			border-bottom-left-radius: 0;
		}
		
		.left-column {
			max-width: 420px;
			width: 420px;
			
			&:after {
				width: 1px;
			}
		}
	}
	
	.header {
		.header-buttons {
			.header-button--toggleLeft {
				display: none;
			}
		}
	}

	.search-box {
		padding: 0 15px 12px;
		display: flex;
		flex-wrap: wrap;
		z-index: 20;
		
		&.has-query {
			.reset-icon {
				display: flex;
			}
		}

		&.is-active {
			.actions {
				display: none;
			}
			
			.return-back {
				width: auto;
				padding-right: 15px;
				padding-left: 5px;
			}
			
			.search-filters {
				display: block;
			}
		}

		.return-back {
			width: 0;
			transition: all .2s;
			overflow: hidden;
			-webkit-tap-highlight-color: rgba(0,0,0,0);
			-webkit-tap-highlight-color: transparent;
		}
		
		.big-icon {
			display: flex;
			align-items: center;
			font-size: 22px;
			cursor: pointer;
		}
		
		.actions {
			.xf-xfmActions();
		}

		.search-input {
			position: relative;
			flex: 1;

			.input {
				.xf-xfmSearchFormInput();
				.xf-xfmSearchInput();
			}
		}
		
		.search-filters {
			width: 100%;
			padding-top: 10px;
			display: none;
			
			.input {
				.xf-xfmSearchFormInput();
			}
			
			.inputChoices {
				display: flex;
				
				.inputChoices-choice {
					margin-left: 15px;
					
					&:first-child {
						margin-left: 0;
					}
				}
			}
		}
		
		.input-icon {
			position: absolute;
			top: 0;
			height: 100%;
			display: flex;
			align-items: center;
			font-size: 20px;
		}

		.search-icon {
			.xf-xfmSearchInputIcon();
			left: 0;
		}
		
		.reset-icon {
			.xf-xfmSearchInputResetIcon();
			right: 0;
			display: none;
		}
	}
	
	.search-fault {
		.xf-xfmSearchFault();
	}
	
	.create-conv-form {
		z-index: 0;
		
		&.is-active {
			z-index: 100;
		}
		
		.bubble-tail {
			display: none;
		}
	}
	
	.room-list {
		.left-slide {
			display: flex;
			flex-direction: column;
		}
	}

	.search-container {
		display: none;
		flex-direction: column;
		opacity: 0;
		visibility: hidden;
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background: var(--surface-color);
		z-index: 200;
		
		.tabs.tabs--standalone {
			background: none;
			border: none;
			border-bottom: 1px solid var(--border-color);
			padding: 0 15px;
			margin-bottom: 5px;
			
			.tabs-tab {
				padding: 10px;
				font-weight: 500;

				&:not(.is-active) {
					color: var(--surface-color-muted);
				}
			}
		}

		&.is-active {
			display: flex;
			opacity: 1;
			visibility: visible;
		}
		
		.search-results {
			height: 100%;
			position: relative;
		}
		
		.search-result-items {
			height: 100%;
		}
		
		.content-loader {
			padding-top: 10px;
		}
	}
	
	// search result
	.room--attachment {
		text-decoration: none;
		
		&:hover {
			background: inherit !important;
		}

		.room-avatar {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 48px;
			height: 48px;

			img, video {
				width: 48px;
				height: 48px;
				border-radius: 4px;
			}
		}
		
		.file-typeIcon {
			font-size: 50px;
		}
	}
	
	.attachment-items-container {
		padding: 0 5px;
	}
	
	.message {
		.content-bubble-container {
			margin-left: 38px;
		}
	}
	
	// mobile
	@media (max-width: 925px) {
		.m-messengerCompact();
	}
	
	&.compact {
		.m-messengerCompact();
	}
	
	.m-chatResponsive(925px);
}

.m-messengerCompact() {
	&.no-left-column {
		.left-column {
			&:after {
				width: 0;
			}
		}
	}
}';
	return $__finalCompiled;
}
);