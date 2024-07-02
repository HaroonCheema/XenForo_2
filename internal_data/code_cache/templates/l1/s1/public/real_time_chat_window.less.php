<?php
// FROM HASH: 89537b256157e567c6161ddfb7ebae35
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.rtc-window {	
	body {
		overflow: hidden !important;
		height: 100%;
	}
	
	.p-body-main {
		display: block;
		height: 100%;
	}

	.p-body-content {
		display: block;
		height: 100%;
		width: 100%;
	}

	.p-body-pageContent {
		height: 100%;
		width: 100%;
	}

	.p-body-inner {
		max-width: unset;
		padding: 0;
		margin: 0;
		width: 100%;
	}

	.real-time-chat {
		box-shadow: none;
		margin: 0;
		height: ~"calc(var(--vh, 1vh) * 100)";
		width: 100%;
		position: fixed;

		--chat-border-radius: 0;

		.left-column {
			@media (min-width: 925px) {
				max-width: 420px;
				width: 420px;
			}
		}
		
		.left-column-header {
			display: flex;
		}

		&.no-left-column {
			.header {
				border-top-left-radius: 0;
			}
			
			@media (min-width: 925px) {
				.left-column {
					max-width: 78px;
					width: 78px;

					&:after {
						width: 1px;
					}

					.btn-corner {
						display: none;
					}
				}

				.back-to-home-btn {
					padding-top: 15px;
					padding-bottom: 15px;

					.button-text {
						font-size: 24px;
					}

					.button-text--inner {
						font-size: 0;
						opacity: 0;
						width: 0;
						padding: 0;
					}
				}
			}
		}

		&:not(.no-left-column) {
			.message-list-wrapper {
				padding-left: 20px;
				padding-right: 20px;
			}
		}
	}
}';
	return $__finalCompiled;
}
);