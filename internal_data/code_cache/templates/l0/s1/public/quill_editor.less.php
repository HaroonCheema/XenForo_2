<?php
// FROM HASH: e0115703b0822341c08078eac52783f7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.quill-editor-container {
	position: relative;
	width: 100%;
	.xf-quillEditorContainer();

	&.is-disabled {
		opacity: .7;
	}

	.quill-wrapper {
		display: flex;
	}
	
	.quill-editor-wrapper {
		flex: 1;
		width: 0;
	}

	.ql-buttons {
		display: flex;
		align-items: end;
		height: auto;

		&.ql-buttons--left {
			padding-left: 8px;

			.ql-button:last-child {
				padding-right: 14px;
			}
		}

		&.ql-buttons--right {
			padding-right: 10px;
		}
	}

	.ql-button {
		.xf-quillEditorButton();
		&:hover { .xf-quillEditorButtonHover(); }
	}
	
	.image-uploading {
		position: relative;
		display: inline-block;

		&:img {
			max-width: 98% !important;
			filter: blur(5px);
			opacity: 0.3;
		}

		&:before {
			content: "";
			box-sizing: border-box;
			position: absolute;
			top: 50%;
			left: 50%;
			width: 30px;
			height: 30px;
			margin-top: -15px;
			margin-left: -15px;
			border-radius: 50%;
			
			// todo what is it?
			border: 3px solid #ccc;
			border-top-color: #1e986c;
			z-index: 1;
			animation: image-uploading-spinner 0.6s linear infinite;
		}
	}
}

.ql-container {
	box-sizing: border-box;
	height: 100%;
	margin: 0px;
	position: relative;
	display: flex;
	flex: 1;
	flex-direction: column;
}
.ql-container.ql-disabled {
	.ql-tooltip {
		visibility: hidden;
	}
	.ql-editor {
		ul[data-checked] {
			>li {
				&::before {
					pointer-events: none;
				}
			}
		}
	}
}
.ql-clipboard {
	left: -100000px;
	height: 1px;
	overflow-y: hidden;
	position: absolute;
	top: 50%;
	p {
		margin: 0;
		padding: 0;
	}
}
.ql-editor {
	.xf-quillEditorInput();

	.smilie {
		user-select: text;
		pointer-events: auto;
		
		> span {
			display: inline-block;
			width: 100%;
			height: 100%;
		}
	}

	> * {
		cursor: text;
		overflow: hidden;
	}
	p {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	ol {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
		padding-left: 1.5em;
		>li {
			list-style-type: none;
		}
		li {
			&:not(.ql-direction-rtl) {
				padding-left: 1.5em;
			}
			counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
			counter-increment: list-0;
			&:before {
				content: counter(list-0, decimal) \'. \';
			}
		}
		li.ql-direction-rtl {
			padding-right: 1.5em;
		}
		li.ql-indent-1 {
			counter-increment: list-1;
			counter-reset: list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
			&:before {
				content: counter(list-1, lower-alpha) \'. \';
			}
		}
		li.ql-indent-2 {
			counter-increment: list-2;
			counter-reset: list-3 list-4 list-5 list-6 list-7 list-8 list-9;
			&:before {
				content: counter(list-2, lower-roman) \'. \';
			}
		}
		li.ql-indent-3 {
			counter-increment: list-3;
			counter-reset: list-4 list-5 list-6 list-7 list-8 list-9;
			&:before {
				content: counter(list-3, decimal) \'. \';
			}
		}
		li.ql-indent-4 {
			counter-increment: list-4;
			counter-reset: list-5 list-6 list-7 list-8 list-9;
			&:before {
				content: counter(list-4, lower-alpha) \'. \';
			}
		}
		li.ql-indent-5 {
			counter-increment: list-5;
			counter-reset: list-6 list-7 list-8 list-9;
			&:before {
				content: counter(list-5, lower-roman) \'. \';
			}
		}
		li.ql-indent-6 {
			counter-increment: list-6;
			counter-reset: list-7 list-8 list-9;
			&:before {
				content: counter(list-6, decimal) \'. \';
			}
		}
		li.ql-indent-7 {
			counter-increment: list-7;
			counter-reset: list-8 list-9;
			&:before {
				content: counter(list-7, lower-alpha) \'. \';
			}
		}
		li.ql-indent-8 {
			counter-increment: list-8;
			counter-reset: list-9;
			&:before {
				content: counter(list-8, lower-roman) \'. \';
			}
		}
		li.ql-indent-9 {
			counter-increment: list-9;
			&:before {
				content: counter(list-9, decimal) \'. \';
			}
		}
	}
	ul {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
		padding-left: 1.5em;
		>li {
			list-style-type: none;
			&::before {
				content: \'\\2022\';
			}
		}
		li {
			&:not(.ql-direction-rtl) {
				padding-left: 1.5em;
			}
		}
		li.ql-direction-rtl {
			padding-right: 1.5em;
		}
	}
	pre {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	blockquote {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
		white-space: normal;
		display: flex;
		flex-direction: column;
		overflow: hidden;
		position: relative;

		> span {
			width: 100%;
		}

		&[data-quote] {
			&:before {
				display: block;
				content: attr(data-quote) " ' . 'said' . $__templater->escape($__vars['xf']['language']['label_separator']) . '";
				.xf-bbCodeBlockTitle();
				padding: @xf-paddingMedium @xf-paddingLarge;
			}
		}
		
		.bbCodeBlock-remove {
			position: absolute;
			top: 0;
			right: 0;
			padding-right: @xf-paddingLarge;
			padding-top: @xf-paddingMedium;
			cursor: pointer;
			width: auto;
			
			&:after {
				.m-faBase();
				.m-faContent(@fa-var-times);
				color: @xf-textColorMuted;
			}
		}
	}
	h1 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	h2 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	h3 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	h4 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	h5 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	h6 {
		margin: 0;
		padding: 0;
		counter-reset: list-1 list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9;
	}
	ul[data-checked=true] {
		pointer-events: none;
		>li {
			* {
				pointer-events: all;
			}
			&::before {
				color: var(--color-button-muted);
				cursor: pointer;
				pointer-events: all;
				content: \'\\2611\';
			}
		}
	}
	ul[data-checked=false] {
		pointer-events: none;
		>li {
			* {
				pointer-events: all;
			}
			&::before {
				color: var(--color-button-muted);
				cursor: pointer;
				pointer-events: all;
				content: \'\\2610\';
			}
		}
	}
	li {
		&::before {
			display: inline-block;
			white-space: nowrap;
			width: 1.2em;
		}
		&:not(.ql-direction-rtl) {
			&::before {
				margin-left: -1.5em;
				margin-right: 0.3em;
				text-align: right;
			}
		}
	}
	li.ql-direction-rtl {
		&::before {
			margin-left: 0.3em;
			margin-right: -1.5em;
		}
	}
	.ql-indent-1 {
		&:not(.ql-direction-rtl) {
			padding-left: 3em;
		}
	}
	li.ql-indent-1 {
		&:not(.ql-direction-rtl) {
			padding-left: 4.5em;
		}
	}
	.ql-indent-1.ql-direction-rtl.ql-align-right {
		padding-right: 3em;
	}
	li.ql-indent-1.ql-direction-rtl.ql-align-right {
		padding-right: 4.5em;
	}
	.ql-indent-2 {
		&:not(.ql-direction-rtl) {
			padding-left: 6em;
		}
	}
	li.ql-indent-2 {
		&:not(.ql-direction-rtl) {
			padding-left: 7.5em;
		}
	}
	.ql-indent-2.ql-direction-rtl.ql-align-right {
		padding-right: 6em;
	}
	li.ql-indent-2.ql-direction-rtl.ql-align-right {
		padding-right: 7.5em;
	}
	.ql-indent-3 {
		&:not(.ql-direction-rtl) {
			padding-left: 9em;
		}
	}
	li.ql-indent-3 {
		&:not(.ql-direction-rtl) {
			padding-left: 10.5em;
		}
	}
	.ql-indent-3.ql-direction-rtl.ql-align-right {
		padding-right: 9em;
	}
	li.ql-indent-3.ql-direction-rtl.ql-align-right {
		padding-right: 10.5em;
	}
	.ql-indent-4 {
		&:not(.ql-direction-rtl) {
			padding-left: 12em;
		}
	}
	li.ql-indent-4 {
		&:not(.ql-direction-rtl) {
			padding-left: 13.5em;
		}
	}
	.ql-indent-4.ql-direction-rtl.ql-align-right {
		padding-right: 12em;
	}
	li.ql-indent-4.ql-direction-rtl.ql-align-right {
		padding-right: 13.5em;
	}
	.ql-indent-5 {
		&:not(.ql-direction-rtl) {
			padding-left: 15em;
		}
	}
	li.ql-indent-5 {
		&:not(.ql-direction-rtl) {
			padding-left: 16.5em;
		}
	}
	.ql-indent-5.ql-direction-rtl.ql-align-right {
		padding-right: 15em;
	}
	li.ql-indent-5.ql-direction-rtl.ql-align-right {
		padding-right: 16.5em;
	}
	.ql-indent-6 {
		&:not(.ql-direction-rtl) {
			padding-left: 18em;
		}
	}
	li.ql-indent-6 {
		&:not(.ql-direction-rtl) {
			padding-left: 19.5em;
		}
	}
	.ql-indent-6.ql-direction-rtl.ql-align-right {
		padding-right: 18em;
	}
	li.ql-indent-6.ql-direction-rtl.ql-align-right {
		padding-right: 19.5em;
	}
	.ql-indent-7 {
		&:not(.ql-direction-rtl) {
			padding-left: 21em;
		}
	}
	li.ql-indent-7 {
		&:not(.ql-direction-rtl) {
			padding-left: 22.5em;
		}
	}
	.ql-indent-7.ql-direction-rtl.ql-align-right {
		padding-right: 21em;
	}
	li.ql-indent-7.ql-direction-rtl.ql-align-right {
		padding-right: 22.5em;
	}
	.ql-indent-8 {
		&:not(.ql-direction-rtl) {
			padding-left: 24em;
		}
	}
	li.ql-indent-8 {
		&:not(.ql-direction-rtl) {
			padding-left: 25.5em;
		}
	}
	.ql-indent-8.ql-direction-rtl.ql-align-right {
		padding-right: 24em;
	}
	li.ql-indent-8.ql-direction-rtl.ql-align-right {
		padding-right: 25.5em;
	}
	.ql-indent-9 {
		&:not(.ql-direction-rtl) {
			padding-left: 27em;
		}
	}
	li.ql-indent-9 {
		&:not(.ql-direction-rtl) {
			padding-left: 28.5em;
		}
	}
	.ql-indent-9.ql-direction-rtl.ql-align-right {
		padding-right: 27em;
	}
	li.ql-indent-9.ql-direction-rtl.ql-align-right {
		padding-right: 28.5em;
	}
	.ql-video {
		display: block;
		max-width: 100%;
	}
	.ql-video.ql-align-center {
		margin: 0 auto;
	}
	.ql-video.ql-align-right {
		margin: 0 0 0 auto;
	}
	.ql-bg-black {
		background-color: var(--background-black);
	}
	.ql-bg-red {
		background-color: var(--background-red);
	}
	.ql-bg-orange {
		background-color: var(--background-orange);
	}
	.ql-bg-yellow {
		background-color: var(--background-yellow);
	}
	.ql-bg-green {
		background-color: var(--background-green);
	}
	.ql-bg-blue {
		background-color: var(--background-blue);
	}
	.ql-bg-purple {
		background-color: var(--background-purple);
	}
	.ql-color-white {
		color: var(--color-white);
	}
	.ql-color-red {
		color: var(--color-red);
	}
	.ql-color-orange {
		color: var(--color-orange);
	}
	.ql-color-yellow {
		color: var(--color-yellow);
	}
	.ql-color-green {
		color: var(--color-green);
	}
	.ql-color-blue {
		color: var(--color-blue);
	}
	.ql-color-purple {
		color: var(--color-purple);
	}
	.ql-font-serif {
		font-family: var(--font-family-serif);
	}
	.ql-font-monospace {
		font-family: var(--font-family-monospace);
	}
	.ql-size-small {
		font-size: 0.75em;
	}
	.ql-size-large {
		font-size: 1.5em;
	}
	.ql-size-huge {
		font-size: 2.5em;
	}
	.ql-direction-rtl {
		direction: rtl;
		text-align: inherit;
	}
	.ql-align-center {
		text-align: center;
	}
	.ql-align-justify {
		text-align: justify;
	}
	.ql-align-right {
		text-align: right;
	}
}
.ql-editor.ql-blank {
	&::before {
		color: @xf-textColorMuted;
		content: attr(data-placeholder);
		left: var(--editor-padding-h);
		pointer-events: none;
		position: absolute;
		right: var(--editor-padding-h);
	}
}
.ql-snow.ql-toolbar {
	&:after {
		clear: both;
		content: \'\';
		display: table;
	}
	button {
		background: none;
		border: none;
		cursor: pointer;
		display: inline-block;
		float: left;
		height: 24px;
		padding: 3px 5px;
		width: 28px;
		svg {
			float: left;
			height: 100%;
		}
		&:active {
			&:hover {
				outline: none;
			}
		}
		&:hover {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
		&:focus {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
	}
	input.ql-image[type=file] {
		display: none;
	}
	button.ql-active {
		color: var(--color-blue);
		.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke {
			stroke: var(--color-blue);
		}
		.ql-stroke-miter {
			stroke: var(--color-blue);
		}
	}
	.ql-picker-label {
		&:hover {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
	}
	.ql-picker-label.ql-active {
		color: var(--color-blue);
		.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke {
			stroke: var(--color-blue);
		}
		.ql-stroke-miter {
			stroke: var(--color-blue);
		}
	}
	.ql-picker-item {
		&:hover {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
	}
	.ql-picker-item.ql-selected {
		color: var(--color-blue);
		.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke.ql-fill {
			fill: var(--color-blue);
		}
		.ql-stroke {
			stroke: var(--color-blue);
		}
		.ql-stroke-miter {
			stroke: var(--color-blue);
		}
	}
}
.ql-snow {
	.ql-toolbar {
		&:after {
			clear: both;
			content: \'\';
			display: table;
		}
		button {
			background: none;
			border: none;
			cursor: pointer;
			display: inline-block;
			float: left;
			height: 24px;
			padding: 3px 5px;
			width: 28px;
			svg {
				float: left;
				height: 100%;
			}
			&:active {
				&:hover {
					outline: none;
				}
			}
			&:hover {
				color: var(--color-blue);
				.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke {
					stroke: var(--color-blue);
				}
				.ql-stroke-miter {
					stroke: var(--color-blue);
				}
			}
			&:focus {
				color: var(--color-blue);
				.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke {
					stroke: var(--color-blue);
				}
				.ql-stroke-miter {
					stroke: var(--color-blue);
				}
			}
		}
		input.ql-image[type=file] {
			display: none;
		}
		button.ql-active {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
		.ql-picker-label {
			&:hover {
				color: var(--color-blue);
				.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke {
					stroke: var(--color-blue);
				}
				.ql-stroke-miter {
					stroke: var(--color-blue);
				}
			}
		}
		.ql-picker-label.ql-active {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
		.ql-picker-item {
			&:hover {
				color: var(--color-blue);
				.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke.ql-fill {
					fill: var(--color-blue);
				}
				.ql-stroke {
					stroke: var(--color-blue);
				}
				.ql-stroke-miter {
					stroke: var(--color-blue);
				}
			}
		}
		.ql-picker-item.ql-selected {
			color: var(--color-blue);
			.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke.ql-fill {
				fill: var(--color-blue);
			}
			.ql-stroke {
				stroke: var(--color-blue);
			}
			.ql-stroke-miter {
				stroke: var(--color-blue);
			}
		}
	}
	box-sizing: border-box;
	* {
		box-sizing: border-box;
	}
	.ql-hidden {
		display: none;
	}
	.ql-out-bottom {
		visibility: hidden;
	}
	.ql-out-top {
		visibility: hidden;
	}
	.ql-tooltip {
		position: absolute;
		transform: translateY(10px);
		background-color: var(--tooltip-background-color);
		border: 1px solid var(--color-button-label);
		box-shadow: 0px 0px 5px #ddd;
		color: var(--color-button);
		padding: 5px 12px;
		white-space: nowrap;
		
		a {
			cursor: pointer;
			text-decoration: none;
			line-height: 26px;
		}
		&::before {
			content: "Visit URL:";
			line-height: 26px;
			margin-right: 8px;
		}
		input[type=text] {
			display: none;
			border: 1px solid var(--color-button-label);
			font-size: 13px;
			height: 26px;
			margin: 0px;
			padding: 3px 5px;
			width: 170px;
		}
		a.ql-preview {
			display: inline-block;
			max-width: 200px;
			overflow-x: hidden;
			text-overflow: ellipsis;
			vertical-align: top;
		}
		a.ql-action {
			&::after {
				border-right: 1px solid var(--color-button-label);
				content: \'' . 'Edit' . '\';
				margin-left: 16px;
				padding-right: 8px;
			}
		}
		a.ql-remove {
			&::before {
				content: \'' . 'Remove' . '\';
				margin-left: 8px;
			}
		}
	}
	.ql-tooltip.ql-flip {
		transform: translateY(-10px);
	}
	.ql-formats {
		display: inline-block;
		vertical-align: middle;
		&:after {
			clear: both;
			content: \'\';
			display: table;
		}
	}
	.ql-stroke {
		fill: none;
		stroke: var(--color-button);
		stroke-linecap: round;
		stroke-linejoin: round;
		stroke-width: 2;
	}
	.ql-stroke-miter {
		fill: none;
		stroke: var(--color-button);
		stroke-miterlimit: 10;
		stroke-width: 2;
	}
	.ql-fill {
		fill: var(--color-button);
	}
	.ql-stroke.ql-fill {
		fill: var(--color-button);
	}
	.ql-empty {
		fill: none;
	}
	.ql-even {
		fill-rule: evenodd;
	}
	.ql-thin {
		stroke-width: 1;
	}
	.ql-stroke.ql-thin {
		stroke-width: 1;
	}
	.ql-transparent {
		opacity: 0.4;
	}
	.ql-direction {
		svg {
			&:last-child {
				display: none;
			}
		}
	}
	.ql-direction.ql-active {
		svg {
			&:last-child {
				display: inline;
			}
			&:first-child {
				display: none;
			}
		}
	}
	.ql-editor {
		h1 {
			font-size: 2em;
		}
		h2 {
			font-size: 1.5em;
		}
		h3 {
			font-size: 1.17em;
		}
		h4 {
			font-size: 1em;
		}
		h5 {
			font-size: 0.83em;
		}
		h6 {
			font-size: 0.67em;
		}
		a {
			text-decoration: underline;
		}
		blockquote {
			// no style
		}
		code {
			background-color: var(--background-code-inline);
			border-radius: 3px;
			font-size: 85%;
			padding: 2px 4px;
		}
		pre {
			background-color: var(--background-code-inline);
			border-radius: 3px;
			white-space: pre-wrap;
			margin-bottom: 5px;
			margin-top: 5px;
			padding: 5px 10px;
		}
		pre.ql-syntax {
			background-color: var(--background-code);
			color: var(--color-code);
			overflow: visible;
		}
		img {
			max-width: 100%;
		}
	}
	.ql-picker {
		color: var(--color-button);
		display: inline-block;
		float: left;
		font-size: 14px;
		font-weight: 500;
		height: 24px;
		position: relative;
		vertical-align: middle;
		&:not(.ql-color-picker) {
			&:not(.ql-icon-picker) {
				svg {
					position: absolute;
					margin-top: -9px;
					right: 0;
					top: 50%;
					width: 18px;
				}
			}
		}
	}
	.ql-picker-label {
		cursor: pointer;
		display: inline-block;
		height: 100%;
		padding-left: 8px;
		padding-right: 2px;
		position: relative;
		width: 100%;
		&::before {
			display: inline-block;
			line-height: 22px;
		}
	}
	.ql-picker-options {
		background-color: var(--tooltip-background-color);
		display: none;
		min-width: 100%;
		padding: 4px 8px;
		position: absolute;
		white-space: nowrap;
		.ql-picker-item {
			cursor: pointer;
			display: block;
			padding-bottom: 5px;
			padding-top: 5px;
		}
	}
	.ql-picker.ql-expanded {
		.ql-picker-label {
			color: var(--color-button-label);
			z-index: 2;
			.ql-fill {
				fill: var(--color-button-label);
			}
			.ql-stroke {
				stroke: var(--color-button-label);
			}
		}
		.ql-picker-options {
			display: block;
			margin-top: -1px;
			top: 100%;
			z-index: 1;
		}
	}
	.ql-color-picker {
		width: 28px;
		.ql-picker-label {
			padding: 2px 4px;
			svg {
				right: 4px;
			}
		}
		.ql-picker-options {
			padding: 3px 5px;
			width: 152px;
		}
		.ql-picker-item {
			border: 1px solid transparent;
			float: left;
			height: 16px;
			margin: 2px;
			padding: 0px;
			width: 16px;
		}
	}
	.ql-icon-picker {
		width: 28px;
		.ql-picker-label {
			padding: 2px 4px;
			svg {
				right: 4px;
			}
		}
		.ql-picker-options {
			padding: 4px 0px;
		}
		.ql-picker-item {
			height: 24px;
			width: 24px;
			padding: 2px 4px;
		}
	}
	.ql-picker.ql-header {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 98px;
		.ql-picker-label {
			&::before {
				content: \'' . 'Normal' . '\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'' . 'Normal' . '\';
			}
		}
		.ql-picker-label[data-value="1"] {
			&::before {
				content: \'' . 'Heading 1' . '\';
			}
		}
		.ql-picker-item[data-value="1"] {
			&::before {
				content: \'' . 'Heading 1' . '\';
				font-size: 2em;
			}
		}
		.ql-picker-label[data-value="2"] {
			&::before {
				content: \'' . 'Heading 2' . '\';
			}
		}
		.ql-picker-item[data-value="2"] {
			&::before {
				content: \'' . 'Heading 2' . '\';
				font-size: 1.5em;
			}
		}
		.ql-picker-label[data-value="3"] {
			&::before {
				content: \'' . 'Heading 3' . '\';
			}
		}
		.ql-picker-item[data-value="3"] {
			&::before {
				content: \'' . 'Heading 3' . '\';
				font-size: 1.17em;
			}
		}
		.ql-picker-label[data-value="4"] {
			&::before {
				content: \'Heading 4\';
			}
		}
		.ql-picker-item[data-value="4"] {
			&::before {
				content: \'Heading 4\';
				font-size: 1em;
			}
		}
		.ql-picker-label[data-value="5"] {
			&::before {
				content: \'Heading 5\';
			}
		}
		.ql-picker-item[data-value="5"] {
			&::before {
				content: \'Heading 5\';
				font-size: 0.83em;
			}
		}
		.ql-picker-label[data-value="6"] {
			&::before {
				content: \'Heading 6\';
			}
		}
		.ql-picker-item[data-value="6"] {
			&::before {
				content: \'Heading 6\';
				font-size: 0.67em;
			}
		}
	}
	.ql-picker.ql-font {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 108px;
		.ql-picker-label {
			&::before {
				content: \'Sans Serif\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'Sans Serif\';
			}
		}
		.ql-picker-label[data-value=serif] {
			&::before {
				content: \'Serif\';
			}
		}
		.ql-picker-item[data-value=serif] {
			&::before {
				content: \'Serif\';
				font-family: var(--font-family-serif);
			}
		}
		.ql-picker-label[data-value=monospace] {
			&::before {
				content: \'Monospace\';
			}
		}
		.ql-picker-item[data-value=monospace] {
			&::before {
				content: \'Monospace\';
				font-family: var(--font-family-monospace);
			}
		}
	}
	.ql-picker.ql-size {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 98px;
		.ql-picker-label {
			&::before {
				content: \'' . 'Normal' . '\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'' . 'Normal' . '\';
			}
		}
		.ql-picker-label[data-value=small] {
			&::before {
				content: \'Small\';
			}
		}
		.ql-picker-item[data-value=small] {
			&::before {
				content: \'Small\';
				font-size: 10px;
			}
		}
		.ql-picker-label[data-value=large] {
			&::before {
				content: \'Large\';
			}
		}
		.ql-picker-item[data-value=large] {
			&::before {
				content: \'Large\';
				font-size: 18px;
			}
		}
		.ql-picker-label[data-value=huge] {
			&::before {
				content: \'Huge\';
			}
		}
		.ql-picker-item[data-value=huge] {
			&::before {
				content: \'Huge\';
				font-size: 32px;
			}
		}
	}
	.ql-color-picker.ql-background {
		.ql-picker-item {
			background-color: var(--tooltip-background-color);
		}
	}
	.ql-color-picker.ql-color {
		.ql-picker-item {
			background-color: var(--background-black);
		}
	}
	.ql-tooltip.ql-editing {
		a.ql-preview {
			display: none;
		}
		a.ql-remove {
			display: none;
		}
		input[type=text] {
			display: inline-block;
		}
		a.ql-action {
			&::after {
				border-right: 0px;
				content: \'Save\';
				padding-right: 0px;
			}
		}
	}
	.ql-tooltip[data-mode=link] {
		&::before {
			content: "Enter link:";
		}
	}
	.ql-tooltip[data-mode=formula] {
		&::before {
			content: "Enter formula:";
		}
	}
	.ql-tooltip[data-mode=video] {
		&::before {
			content: "Enter video:";
		}
	}
	a {
		color: var(--color-blue);
	}
}
.ql-toolbar.ql-snow {
	border-bottom: 1px solid @xf-borderColorFaint;
	box-sizing: border-box;
	font-family: var(--toolbar-font-family);
	padding: 8px;
	.ql-formats {
		margin-right: 15px;
	}
	.ql-picker-label {
		border: 1px solid transparent;
	}
	.ql-picker-options {
		border: 1px solid transparent;
		box-shadow: rgba(0,0,0,0.2) 0 2px 8px;
	}
	.ql-picker.ql-expanded {
		.ql-picker-label {
			border-color: var(--border-color-picker-separator);
		}
		.ql-picker-options {
			border-color: var(--border-color-picker-separator);
		}
	}
	.ql-color-picker {
		.ql-picker-item.ql-selected {
			border-color: var(--border-color-picker-selected-separator);
		}
		.ql-picker-item {
			&:hover {
				border-color: var(--border-color-picker-selected-separator);
			}
		}
	}
	&+.ql-container.ql-snow {
		border-top: 0px;
	}
}
.ql-container.ql-snow {
}
@media (pointer: coarse) {
	.ql-snow.ql-toolbar {
		button {
			&:hover {
				&:not(.ql-active) {
					color: var(--color-button);
					.ql-fill {
						fill: var(--color-button);
					}
					.ql-stroke.ql-fill {
						fill: var(--color-button);
					}
					.ql-stroke {
						stroke: var(--color-button);
					}
					.ql-stroke-miter {
						stroke: var(--color-button);
					}
				}
			}
		}
	}
	.ql-snow {
		.ql-toolbar {
			button {
				&:hover {
					&:not(.ql-active) {
						color: var(--color-button);
						.ql-fill {
							fill: var(--color-button);
						}
						.ql-stroke.ql-fill {
							fill: var(--color-button);
						}
						.ql-stroke {
							stroke: var(--color-button);
						}
						.ql-stroke-miter {
							stroke: var(--color-button);
						}
					}
				}
			}
		}
	}
}

// Mentions

.ql-mention-list-container {
	.xf-quillEditorContainer();
	border: none;
	border-radius: 8px;
	z-index: 100;
	overflow: auto;
	box-shadow: 0 2px 12px 0 rgba(30, 30, 30, 0.08);

	.ql-mention-list {
		box-shadow: none;
	}
}
.ql-mention-loading {
	line-height: 44px;
	padding: 0 20px;
	vertical-align: middle;
	font-size: 16px;
}
.ql-mention-list {
	border-radius: 8px;
	margin-top: 0;
	overflow: hidden;
}
.ql-mention-list-item {
	&:hover {
		cursor: pointer;
	}

	&.disabled {
		cursor: auto;
	}

	&.selected {
		background: @xf-contentHighlightBg;
	}
}
.mention {
	height: 24px;
	border-radius: 6px;
	background-color: var(--mention-background);
	padding: 4px 0;
	margin-right: 2px;
	user-select: all;

	> span {
		margin: 0 3px;
	}
}

/** Bubble theme **/
.ql-bubble {
	.ql-toolbar {
		&:after {
			clear: both;
			content: \'\';
			display: table;
		}
		button {
			.xf-quillEditorTooltipButton();

			svg {
				float: left;
				height: 100%;
			}
			&:active {
				&:hover {
					outline: none;
				}
			}
			&:hover {
				background: var(--tooltip-button-hover-background-color);
			}
			&:focus {
				background: var(--tooltip-button-hover-background-color);
			}
		}
		input.ql-image[type=file] {
			display: none;
		}
		button.ql-active {
			background: var(--tooltip-button-hover-background-color);
		}
		.ql-picker {
			&:hover {
				background: var(--tooltip-button-hover-background-color);
			}
		}
		.ql-picker-label.ql-active {
			background: var(--tooltip-button-hover-background-color);
		}
		.ql-picker-item {
			&:hover {
				background: var(--tooltip-button-hover-background-color);
			}
		}
		.ql-picker-item.ql-selected {
			background: var(--tooltip-button-hover-background-color);
		}
		.ql-formats {
			.xf-quillEditorTooltipFormats();

			> * {
				margin-right: 3px;

				&:last-child {
					margin-right: 0;
				}
			}

			&:first-child {
				padding-left: 8px;
			}

			&:last-child {
				padding-right: 8px;
				border-right: none;
			}
		}
	}
	box-sizing: border-box;
	* {
		box-sizing: border-box;
	}
	.ql-hidden {
		display: none;
	}
	.ql-out-bottom {
		visibility: hidden;
	}
	.ql-out-top {
		visibility: hidden;
	}
	.ql-tooltip {
		.xf-quillEditorTooltip();

		a {
			cursor: pointer;
			text-decoration: none;
		}

		.ql-tooltip-arrow {
			display: none;
		}

		&:not(.ql-flip) {
			.ql-tooltip-arrow {
				border-bottom: 6px solid var(--tooltip-background-color);
				top: -6px;
			}
		}
	}
	.ql-tooltip.ql-flip {
		transform: translateY(-10px);
		
		.ql-tooltip-arrow {
			border-top: 6px solid var(--tooltip-background-color);
			bottom: -6px;
		}
	}
	.ql-formats {
		display: inline-block;
		vertical-align: middle;
		&:after {
			clear: both;
			content: \'\';
			display: table;
		}
	}
	.ql-stroke {
		fill: none;
		stroke: var(--color-button-label);
		stroke-linecap: round;
		stroke-linejoin: round;
		stroke-width: 2;
	}
	.ql-stroke-miter {
		fill: none;
		stroke: var(--color-button-label);
		stroke-miterlimit: 10;
		stroke-width: 2;
	}
	.ql-fill {
		fill: var(--color-button-label);
	}
	.ql-stroke.ql-fill {
		fill: var(--color-button-label);
	}
	.ql-empty {
		fill: none;
	}
	.ql-even {
		fill-rule: evenodd;
	}
	.ql-thin {
		stroke-width: 1;
	}
	.ql-stroke.ql-thin {
		stroke-width: 1;
	}
	.ql-transparent {
		opacity: 0.4;
	}
	.ql-direction {
		svg {
			&:last-child {
				display: none;
			}
		}
	}
	.ql-direction.ql-active {
		svg {
			&:last-child {
				display: inline;
			}
			&:first-child {
				display: none;
			}
		}
	}
	.ql-editor {
		h1 {
			font-size: 2em;
		}
		h2 {
			font-size: 1.5em;
		}
		h3 {
			font-size: 1.17em;
		}
		h4 {
			font-size: 1em;
		}
		h5 {
			font-size: 0.83em;
		}
		h6 {
			font-size: 0.67em;
		}
		a {
			text-decoration: underline;
		}
		blockquote {
		}
		code {
			background-color: var(--background-code);
			border-radius: 3px;
			font-size: 85%;
			padding: 2px 4px;
		}
		pre {
			background-color: var(--background-code);
			border-radius: 3px;
			white-space: pre-wrap;
			margin-bottom: 5px;
			margin-top: 5px;
			padding: 5px 10px;
		}
		pre.ql-syntax {
			background-color: var(--background-code-inline);
			color: var(--color-code);
			overflow: visible;
		}
		img {
			max-width: 100%;
		}
	}
	.ql-picker {
		color: var(--color-button-label);
		display: inline-block;
		float: left;
		font-weight: 500;
		position: relative;
		vertical-align: middle;
		padding: 4px;
		border-radius: 8px;
		height: 30px;
		width: 30px;
		-webkit-tap-highlight-color: rgba(0,0,0,0);
		-webkit-tap-highlight-color: transparent;

		&:not(.ql-color-picker) {
			&:not(.ql-icon-picker) {
				svg {
					position: absolute;
					margin-top: -9px;
					right: 0;
					top: 50%;
					width: 18px;
				}
			}
		}
	}
	.ql-picker-label {
		cursor: pointer;
		display: inline-block;
		position: relative;
		width: 100%;
		height: 100%;
		padding: 0;
		&::before {
			display: inline-block;
			line-height: 22px;
		}
	}
	.ql-picker-options {
		background-color: var(--tooltip-background-color);
		box-shadow: var(--tooltip-box-shadow);
		display: none;
		min-width: 100%;
		padding: 10px;
		position: absolute;
		white-space: nowrap;
		border-radius: 8px;

		.ql-picker-item {
			cursor: pointer;
			display: block;
			padding-bottom: 5px;
			padding-top: 5px;
			border-radius: 2px;
		}
	}
	.ql-picker.ql-expanded {
		.ql-picker-label {
			color: var(--color-button-muted);
			z-index: 2;
			.ql-fill {
				fill: var(--color-button-muted);
			}
			.ql-stroke {
				stroke: var(--color-button-muted);
			}
		}
		.ql-picker-options {
			display: block;
			margin-top: -1px;
			top: 100%;
			z-index: 1;
		}
	}
	.ql-color-picker {
		.ql-picker-label {
			svg {
				right: 4px;
			}
		}
		.ql-picker-options {
			padding: 3px 5px;
			width: 152px;
		}
		.ql-picker-item {
			border: 1px solid transparent;
			float: left;
			height: 16px;
			margin: 2px;
			padding: 0px;
			width: 16px;
			&:hover {
				border-color: var(--color-white);
			}
		}
		svg {
			margin: 1px;
		}
		.ql-picker-item.ql-selected {
			border-color: var(--color-white);
		}
	}
	.ql-icon-picker {
		.ql-picker-label {
			svg {
				right: 4px;
			}
		}
		.ql-picker-options {
			padding: 4px 0px;
		}
		.ql-picker-item {
			height: 24px;
			width: 24px;
			padding: 2px 4px;
		}
	}
	.ql-picker.ql-header {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 98px;
		.ql-picker-label {
			&::before {
				content: \'Normal\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'Normal\';
			}
		}
		.ql-picker-label[data-value="1"] {
			&::before {
				content: \'Heading 1\';
			}
		}
		.ql-picker-item[data-value="1"] {
			&::before {
				content: \'Heading 1\';
				font-size: 2em;
			}
		}
		.ql-picker-label[data-value="2"] {
			&::before {
				content: \'Heading 2\';
			}
		}
		.ql-picker-item[data-value="2"] {
			&::before {
				content: \'Heading 2\';
				font-size: 1.5em;
			}
		}
		.ql-picker-label[data-value="3"] {
			&::before {
				content: \'Heading 3\';
			}
		}
		.ql-picker-item[data-value="3"] {
			&::before {
				content: \'Heading 3\';
				font-size: 1.17em;
			}
		}
		.ql-picker-label[data-value="4"] {
			&::before {
				content: \'Heading 4\';
			}
		}
		.ql-picker-item[data-value="4"] {
			&::before {
				content: \'Heading 4\';
				font-size: 1em;
			}
		}
		.ql-picker-label[data-value="5"] {
			&::before {
				content: \'Heading 5\';
			}
		}
		.ql-picker-item[data-value="5"] {
			&::before {
				content: \'Heading 5\';
				font-size: 0.83em;
			}
		}
		.ql-picker-label[data-value="6"] {
			&::before {
				content: \'Heading 6\';
			}
		}
		.ql-picker-item[data-value="6"] {
			&::before {
				content: \'Heading 6\';
				font-size: 0.67em;
			}
		}
	}
	.ql-picker.ql-font {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 108px;
		.ql-picker-label {
			&::before {
				content: \'Sans Serif\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'Sans Serif\';
			}
		}
		.ql-picker-label[data-value=serif] {
			&::before {
				content: \'Serif\';
			}
		}
		.ql-picker-item[data-value=serif] {
			&::before {
				content: \'Serif\';
				font-family: Georgia, Times New Roman, serif;
			}
		}
		.ql-picker-label[data-value=monospace] {
			&::before {
				content: \'Monospace\';
			}
		}
		.ql-picker-item[data-value=monospace] {
			&::before {
				content: \'Monospace\';
				font-family: Monaco, Courier New, monospace;
			}
		}
	}
	.ql-picker.ql-size {
		.ql-picker-label[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		.ql-picker-item[data-label] {
			&:not([data-label=\'\']) {
				&::before {
					content: attr(data-label);
				}
			}
		}
		width: 98px;
		.ql-picker-label {
			&::before {
				content: \'Normal\';
			}
		}
		.ql-picker-item {
			&::before {
				content: \'Normal\';
			}
		}
		.ql-picker-label[data-value=small] {
			&::before {
				content: \'Small\';
			}
		}
		.ql-picker-item[data-value=small] {
			&::before {
				content: \'Small\';
				font-size: 10px;
			}
		}
		.ql-picker-label[data-value=large] {
			&::before {
				content: \'Large\';
			}
		}
		.ql-picker-item[data-value=large] {
			&::before {
				content: \'Large\';
				font-size: 18px;
			}
		}
		.ql-picker-label[data-value=huge] {
			&::before {
				content: \'Huge\';
			}
		}
		.ql-picker-item[data-value=huge] {
			&::before {
				content: \'Huge\';
				font-size: 32px;
			}
		}
	}
	.ql-color-picker.ql-background {
		.ql-picker-item {
			background-color: var(--color-white);
		}
	}
	.ql-color-picker.ql-color {
		.ql-picker-item {
			background-color: #000;
		}
	}
	.ql-tooltip-arrow {
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		content: " ";
		display: block;
		left: 50%;
		margin-left: -6px;
		position: absolute;
	}
	.ql-tooltip.ql-editing {
		.ql-tooltip-editor {
			display: block;
		}
		.ql-formats {
			visibility: hidden;
		}
	}
	.ql-tooltip-editor {
		display: none;
		input[type=text] {
			background: transparent;
			border: none;
			color: @xf-input--color;
			font-size: @xf-input--font-size;
			height: 100%;
			outline: none;
			padding: 10px 15px;
			padding-right: 40px;
			position: absolute;
			width: 100%;
		}
		a {
			top: 10px;
			position: absolute !important;
			right: 20px;
			&:before {
				color: var(--color-button-label);
				content: "\\D7";
				font-size: 18px;
				font-weight: bold;
			}
		}
	}
}
.ql-container.ql-bubble {
	&:not(.ql-disabled) {
		a {
			position: relative;
			white-space: nowrap;
		}
	}
}
@media (pointer: coarse) {
	.ql-bubble.ql-toolbar {
		button {
			&:hover {
				&:not(.ql-active) {
					color: var(--color-button-label);
					.ql-fill {
						fill: var(--color-button-label);
					}
					.ql-stroke.ql-fill {
						fill: var(--color-button-label);
					}
					.ql-stroke {
						stroke: var(--color-button-label);
					}
					.ql-stroke-miter {
						stroke: var(--color-button-label);
					}
				}
			}
		}
	}
	.ql-bubble {
		.ql-toolbar {
			button {
				&:hover {
					&:not(.ql-active) {
						color: var(--color-button-label);
						.ql-fill {
							fill: var(--color-button-label);
						}
						.ql-stroke.ql-fill {
							fill: var(--color-button-label);
						}
						.ql-stroke {
							stroke: var(--color-button-label);
						}
						.ql-stroke-miter {
							stroke: var(--color-button-label);
						}
					}
				}
			}
		}
	}
}

@keyframes image-uploading-spinner {
	to {
		transform: rotate(360deg);
	}
}';
	return $__finalCompiled;
}
);