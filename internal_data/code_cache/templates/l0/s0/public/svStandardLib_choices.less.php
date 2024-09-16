<?php
// FROM HASH: 48d3dd821c9a9d0d5e588ce9b86f31a3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.choices {
  position: relative;
  overflow: hidden;
  //margin-bottom: 24px;
}
.choices:last-child {
  margin-bottom: 0;
}
.choices.is-open {
  overflow: visible;
}
.choices.is-disabled .choices__inner,
.choices.is-disabled .choices__input {
  color: @xf-textColorMuted;
  background-color: @xf-pageBg;
  cursor: not-allowed;
  -webkit-user-select: none;
          user-select: none;
}
.choices.is-disabled .choices__item {
  cursor: not-allowed;
}
.choices [hidden] {
  display: none !important;
}

.choices__list {
	margin: 0;
	padding-left: 0;
	list-style: none;
}
.choices__list--single {
  display: inline-block;
  padding: 4px 16px 4px 4px;
  width: 100%;
}
[dir=rtl] .choices__list--single {
  padding-right: 4px;
  padding-left: 16px;
}
.choices__list--single .choices__item {
  width: 100%;
}

.choices__list--multiple {
  display: inline;
}
.choices__list--multiple .choices__item {
	display: inline-block;
	vertical-align: middle;
	border-radius: 20px;
	padding: @xf-paddingSmall @xf-paddingSmall;
	font-size: 0.75rem;
	font-weight: 500;
	margin-right: 3.75px;
	word-break: break-all;
	box-sizing: border-box;
	align-items: center;
	font-size: 15px;
	border-radius: @xf-borderRadiusMedium;
	.xf-chip();
}
[dir=rtl] .choices__list--multiple .choices__item {
  margin-right: 0;
  margin-left: 3.75px;
}
.choices__list--multiple .choices__item.is-highlighted {
  background-color: @xf-contentHighlightBg;
  border: 1px solid @xf-borderColorLight;
}
.is-disabled .choices__list--multiple .choices__item {
  color: @xf-textColorMuted;
  border: 1px solid @xf-borderColorHeavy;
}

.choices__list--dropdown, .choices__list[aria-expanded] {
  visibility: hidden;
  z-index: 999;
  position: absolute;
  width: 100%;
  background-color: @xf-inputFocusBgColor;
  border: 1px solid @xf-borderColor;
  top: 100%;
  margin-top: -1px;
  border-bottom-left-radius: 2.5px;
  border-bottom-right-radius: 2.5px;
  overflow: hidden;
  word-break: break-all;
  will-change: visibility;
}
.is-active.choices__list--dropdown, .is-active.choices__list[aria-expanded] {
  visibility: visible;
}
.is-open .choices__list--dropdown, .is-open .choices__list[aria-expanded] {
  border-color: @xf-borderColor;
}
' . '
.choices__list--dropdown .choices__list, .choices__list[aria-expanded] .choices__list {
  position: relative;
  max-height: 300px;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  will-change: scroll-position;
}
.choices__list--dropdown .choices__item, .choices__list[aria-expanded] .choices__item {
  position: relative;
  padding: 10px;
  font-size: 0.875rem;
}
[dir=rtl] .choices__list--dropdown .choices__item, [dir=rtl] .choices__list[aria-expanded] .choices__item {
  text-align: right;
}

@media (min-width: 640px)
{
	.svChoices--select-prompt
	{
		.choices__list--dropdown .choices__item--selectable, .choices__list[aria-expanded] .choices__item--selectable {
			padding-right: 100px;
		}
		.choices__list--dropdown .choices__item--selectable::after, 
		.choices__list[aria-expanded] .choices__item--selectable::after {
			content: attr(data-select-text);
			font-size: 0.75rem;
			opacity: 0;
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
		}
		[dir=rtl] .choices__list--dropdown .choices__item--selectable, 
		[dir=rtl] .choices__list[aria-expanded] .choices__item--selectable {
			text-align: right;
			padding-left: 100px;
			padding-right: 10px;
		}
		[dir=rtl] .choices__list--dropdown .choices__item--selectable::after, 
		[dir=rtl] .choices__list[aria-expanded] .choices__item--selectable::after {
			right: auto;
			left: 10px;
		}
	}
}

.choices__list--dropdown .choices__item--selectable.is-highlighted, .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
  background-color: @xf-contentHighlightBg;
}
.choices__list--dropdown .choices__item--selectable.is-highlighted::after, .choices__list[aria-expanded] .choices__item--selectable.is-highlighted::after {
  opacity: 0.5;
}

.choices__item {
  cursor: default;
}

.choices__item--selectable {
  cursor: pointer;
}

.choices__item--disabled {
  cursor: not-allowed;
  -webkit-user-select: none;
          user-select: none;
  opacity: 0.5;
}

.choices__heading {
	padding: @xf-paddingMedium  @xf-paddingNormal;
	margin: 0;
	font-size: @xf-fontSizeSmallest;
	font-weight: @xf-fontWeightNormal;
	color: @xf-majorHeadingTextColor;
	text-decoration: none;
	background: @xf-majorHeadingBg;
	border-top: @xf-borderSize solid @xf-borderColorLight;
	border-bottom: @xf-borderSize solid @xf-borderColorLight;
}

.choices__button {
  border: 0;
  background-color: transparent;
  background-repeat: no-repeat;
  background-position: center;
  cursor: pointer;
}
.choices__button:focus {
  outline: none;
}

.choices__input {
  display: inline-block;
  vertical-align: baseline;
  background-color: @xf-inputBgColor;
  font-size: 0.875rem;
  border: 0;
  border-radius: 0;
  max-width: 100%;
  padding: 4px 0 4px 2px;
}
.choices__input:focus {
  outline: 0;
}
.choices__input::-webkit-search-decoration, .choices__input::-webkit-search-cancel-button, .choices__input::-webkit-search-results-button, .choices__input::-webkit-search-results-decoration {
  display: none;
}
.choices__input::-ms-clear, .choices__input::-ms-reveal {
  display: none;
  width: 0;
  height: 0;
}
[dir=rtl] .choices__input {
  padding-right: 2px;
  padding-left: 0;
}

.choices__placeholder {
  opacity: 0.5;
}

.svChoices--inputGroup
{
	position: relative;
	&.is-open
	{
		> .input
		{
			border-bottom-left-radius: 0px;
			border-bottom-right-radius: 0px;
		}
	}

	.choices__inner .choices__item > * 
	{
		vertical-align: middle;
	}

	.choices__item--choice
	{
		.choices__description
		{
			color: @xf-textColorMuted;
			display: block;
			margin-top: @xf-paddingSmall;
		}

		&.is-selected
		{
			> .label
			{
				.xf-chip();
			}
		}
	}

	.choices__item
	{
		.choices__button
		{
			padding-left:0;
		}
		.choices__button:after
		{
			color: @xf-textColorMuted;
			';
	if ($__vars['xf']['versionId'] < 2030000) {
		$__finalCompiled .= '
			.m-faBase();
			';
	}
	$__finalCompiled .= '
			.m-faContent(@fa-var-times-circle);
			transition: all .2s ease-in;

			&:hover
			{
				color: @xf-textColorDimmed;
			}
		}
	}
}';
	return $__finalCompiled;
}
);