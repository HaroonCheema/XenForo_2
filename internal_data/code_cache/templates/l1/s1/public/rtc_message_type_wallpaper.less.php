<?php
// FROM HASH: 8e894f2f489d7bd5a0684038420b47ee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.chat-message-form.chat-message-form--wallpaper {
	dd {
		position: relative;
		--primary-color: @xf-buttonBg;
	}
	
	.themes-list-container {
		margin: 0 -8px;
		padding-right: 4px;
		padding-top: 4px;
	}
	
	.themes-list {
		display: flex;
		padding: 4px;
	}
	
	.theme-container {
		position: relative;
		width: 72px;
		min-width: 72px;
		height: 94px;
		margin: 0 4px;
		cursor: pointer;

		&:before {
			transition: transform .25s, opacity .25s;
			border: 2px solid var(--primary-color);
			border-radius: 14px;
			bottom: -4px;
			content: " ";
			left: -4px;
			position: absolute;
			right: -4px;
			top: -4px;
			opacity: 0;
			transform: scale(.86);
		}

		&.selected {
			&:before {
				opacity: 1;
				transform: scale(1);
			}
		}
	}

	.theme-canvas,
	.theme-pattern {
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		width: 100%;
		height: 100%;
		border-radius: 10px;
	}
	
	.theme-pattern {
		mix-blend-mode: soft-light;
		opacity: .5;
	}
	
	.upload-form {
		display: flex;
		flex-direction: column;
	}
}';
	return $__finalCompiled;
}
);