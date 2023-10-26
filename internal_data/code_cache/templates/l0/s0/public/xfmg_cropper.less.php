<?php
// FROM HASH: 234e93bae159a7cb5690ec57e2da48df
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/*!
 * Cropper v3.0.0-rc.3
 * https://github.com/fengyuanchen/cropper
 *
 * Copyright (c) 2017 Fengyuan Chen
 * Released under the MIT license
 *
 * Date: 2017-07-07T13:00:47.346Z
 */

.cropper-container {
	font-size: 0;
	line-height: 0;

	position: relative;

	-webkit-user-select: none;

	-moz-user-select: none;

	-ms-user-select: none;

	user-select: none;

	direction: ltr;
	-ms-touch-action: none;
	touch-action: none
}

.cropper-container img {
	/* Avoid margin top issue (Occur only when margin-top <= -height) */
	display: block;
	min-width: 0 !important;
	max-width: none !important;
	min-height: 0 !important;
	max-height: none !important;
	width: 100%;
	height: 100%;
	image-orientation: 0deg
}

.cropper-wrap-box,
.cropper-canvas,
.cropper-drag-box,
.cropper-crop-box,
.cropper-modal {
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
}

.cropper-wrap-box {
	overflow: hidden;
}

.cropper-drag-box {
	opacity: 0;
	background-color: #fff;
}

.cropper-modal {
	opacity: .5;
	background-color: #000;
}

.cropper-view-box {
	display: block;
	overflow: hidden;

	width: 100%;
	height: 100%;

	outline: 1px solid #39f;
	outline-color: rgba(51, 153, 255, 0.75);
}

.cropper-dashed {
	position: absolute;

	display: block;

	opacity: .5;
	border: 0 dashed #eee
}

.cropper-dashed.dashed-h {
	top: 33.33333%;
	left: 0;
	width: 100%;
	height: 33.33333%;
	border-top-width: 1px;
	border-bottom-width: 1px
}

.cropper-dashed.dashed-v {
	top: 0;
	left: 33.33333%;
	width: 33.33333%;
	height: 100%;
	border-right-width: 1px;
	border-left-width: 1px
}

.cropper-center {
	position: absolute;
	top: 50%;
	left: 50%;

	display: block;

	width: 0;
	height: 0;

	opacity: .75
}

.cropper-center:before,
.cropper-center:after {
	position: absolute;
	display: block;
	content: \' \';
	background-color: #eee
}

.cropper-center:before {
	top: 0;
	left: -3px;
	width: 7px;
	height: 1px
}

.cropper-center:after {
	top: -3px;
	left: 0;
	width: 1px;
	height: 7px
}

.cropper-face,
.cropper-line,
.cropper-point {
	position: absolute;

	display: block;

	width: 100%;
	height: 100%;

	opacity: .1;
}

.cropper-face {
	top: 0;
	left: 0;

	background-color: #fff;
}

.cropper-line {
	background-color: #39f
}

.cropper-line.line-e {
	top: 0;
	right: -3px;
	width: 5px;
	cursor: e-resize
}

.cropper-line.line-n {
	top: -3px;
	left: 0;
	height: 5px;
	cursor: n-resize
}

.cropper-line.line-w {
	top: 0;
	left: -3px;
	width: 5px;
	cursor: w-resize
}

.cropper-line.line-s {
	bottom: -3px;
	left: 0;
	height: 5px;
	cursor: s-resize
}

.cropper-point {
	width: 5px;
	height: 5px;

	opacity: .75;
	background-color: #39f
}

.cropper-point.point-e {
	top: 50%;
	right: -3px;
	margin-top: -3px;
	cursor: e-resize
}

.cropper-point.point-n {
	top: -3px;
	left: 50%;
	margin-left: -3px;
	cursor: n-resize
}

.cropper-point.point-w {
	top: 50%;
	left: -3px;
	margin-top: -3px;
	cursor: w-resize
}

.cropper-point.point-s {
	bottom: -3px;
	left: 50%;
	margin-left: -3px;
	cursor: s-resize
}

.cropper-point.point-ne {
	top: -3px;
	right: -3px;
	cursor: ne-resize
}

.cropper-point.point-nw {
	top: -3px;
	left: -3px;
	cursor: nw-resize
}

.cropper-point.point-sw {
	bottom: -3px;
	left: -3px;
	cursor: sw-resize
}

.cropper-point.point-se {
	right: -3px;
	bottom: -3px;
	width: 20px;
	height: 20px;
	cursor: se-resize;
	opacity: 1
}

@media (min-width: 768px) {

	.cropper-point.point-se {
		width: 15px;
		height: 15px
	}
}

@media (min-width: 992px) {

	.cropper-point.point-se {
		width: 10px;
		height: 10px
	}
}

@media (min-width: 1200px) {

	.cropper-point.point-se {
		width: 5px;
		height: 5px;
		opacity: .75
	}
}

.cropper-point.point-se:before {
	position: absolute;
	right: -50%;
	bottom: -50%;
	display: block;
	width: 200%;
	height: 200%;
	content: \' \';
	opacity: 0;
	background-color: #39f
}

.cropper-invisible {
	opacity: 0;
}

.cropper-bg {
	background-image: url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAA3NCSVQICAjb4U/gAAAABlBMVEXMzMz////TjRV2AAAACXBIWXMAAArrAAAK6wGCiw1aAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABFJREFUCJlj+M/AgBVhF/0PAH6/D/HkDxOGAAAAAElFTkSuQmCC\');
}

.cropper-hide {
	position: absolute;

	display: block;

	width: 0;
	height: 0;
}

.cropper-hidden {
	display: none !important;
}

.cropper-move {
	cursor: move;
}

.cropper-crop {
	cursor: crosshair;
}

.cropper-disabled .cropper-drag-box,
.cropper-disabled .cropper-face,
.cropper-disabled .cropper-line,
.cropper-disabled .cropper-point {
	cursor: not-allowed;
}

/*!
 * XF overrides
 */

@baseColor: @xf-paletteColor3;

.cropper-view-box
{
	outline: 1px solid @baseColor;
	outline-color: fade(@baseColor, 75%);
}

.cropper-line
{
	background-color: @baseColor;
}

.cropper-point
{
	background-color: @baseColor;
}

.cropper-point.point-se:before
{
	background-color: @baseColor;
}';
	return $__finalCompiled;
}
);