<?php
// FROM HASH: 20882e159eaca5defe4014d8cb407cf8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@samItem: .' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamItemCssClass']) . ';
@samCodeUnit: .' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamCodeUnitCssClass']) . ';
@samBannerUnit: .' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamBannerUnitCssClass']) . ';
@samTextUnit: .' . $__templater->escape($__vars['xf']['options']['siropuAdsManagerSamTextUnitCssClass']) . ';

@{samCodeUnit},
@{samBannerUnit},
@{samTextUnit}
{
	margin: 10px 0;

	.samCarousel&
	{
		margin: 0;
	}
	&[data-position="embed"]
	{
		margin: 0;
	}
	&[data-position="container_content_above"], &[data-position="forum_overview_top"]
	{
		margin-top: 0;
	}
	.itemList-item &
	{
		margin: 0;
	}
	&:not(.samCarousel)
	{
		.p-header &
		{
			float: right;
			max-width: 728px;
		}
	}
}
.p-header .sam-swiper-container
{
	max-width: 728px;
	float: right;
	margin: 5px 0;
}
@{samCodeUnit}, @{samBannerUnit}
{
	width: 100%;
}
@{samTextUnit}
{
	.xf-contentBase();
	.xf-blockBorder();

	border-radius: @xf-blockBorderRadius;
	padding: 10px;
	display: flex;
	align-items: flex-start;

	@{samItem}, .samAdvertiseHereLink
	{
		margin-right: 20px;
		flex-grow: 1;
  		flex-basis: 0;

		&:last-child
		{
			margin-right: 0;
		}
	}
	.samItemBanner
	{
		.samItemContent, .samAdminActions
		{
			margin-left: 160px;
		}
	}
	.samItemImage
	{
		float: left;
		width: 150px;
		margin-right: 10px;
	}
	.samItemTitle
	{
		color: @xf-linkColor;
		font-weight: bold;
		font-size: 16px;
		margin-bottom: 5px;
	}
	&:after
	{
		content: "";
		display: block;
		clear: both;
	}
	.samAdvertiseHereLink
	{
		font-weight: bold;
	}
	&.samAlignCenter
	{
		text-align: left;
	}
}
@{samItem}
{
	width: inherit;
	height: inherit;

	.samDisplayInlineBlock &
	{
		width: auto;
		display: inline-block;
		margin-right: 10px;

		&:last-child
		{
			margin-right: 0;
		}
	}
	.samDisplayInline &
	{
		width: auto;
		display: inline;
		margin-right: 10px;

		&:last-child
		{
			margin-right: 0;
		}
	}
	.samDisplayFlexbox &
	{
		flex: 1;
		margin-right: 5px;

		&:last-child
		{
			margin-right: 0;
		}
	}
}
.samDisplayFlexbox
{
	display: flex;
	flex-wrap: wrap;

	.samAdvertiseHereLink
	{
		flex-basis: 100%;
	}
}
.samUnitContent
{
	.samDisplayFlexbox &
	{
		 width: 100%;
	}
}
.samResponsiveItems()
{
	@{samTextUnit}
	{
		display: block;

		@{samItem}
		{
			margin-bottom: 15px;

			&:last-child
			{
				margin-bottom: 0;
			}
		}
		.samItemImage
		{
			float: none;
			margin: 0 auto;
		}
		.samItemBanner
		{
			.samItemContent, .samAdminActions
			{
				margin-left: 0;
			}
		}
	}
}
.p-body-sidebar
{
	.samResponsiveItems();
}
.samUnitWrapper
{
	@{samTextUnit}
	{
		background: none;
		border: 0;
		border-radius: 0;
	}
	&.block-row
	{
		> div
		{
			padding: 0;
			margin: 0;
		}
	}
	&.structItem,
	&.message
	{
		> div
		{
			margin: 0 auto;
			padding: 10px;
		}
	}
}
.samMediaViewContainer
{
	position: absolute;
	width: 100%;
	bottom: 0;
	z-index: 99;
}
.samAlignLeft
{
	text-align: left;
}
.samAlignRight
{
	text-align: right;
	margin: 10px 0 10px auto;

	.samCarousel&
	{
		margin: 0 0 0 auto;
	}
}
.samAlignCenter
{
	text-align: center;
	margin: 10px auto;

	.samCarousel&
	{
		margin: 0 auto;
	}
}
.samPositionPreview
{
	background: @xf-borderColorAccentContent;
	border-radius: 4px;
	border: 1px solid @xf-borderColorAttention;
	padding: 10px;
	margin: 10px 0;
	text-align: center;
	color: @xf-textColor;
}
.samCustomSize
{
	position: relative;

	@{samBannerUnit} @{samItem}
	{
		height: 100%;
	}
	.samAdminActions
	{
		position: absolute;
		left: 5px;
		bottom: 0;
	}
}
.samAdminActions
{
	margin: 5px 0;

	.button
	{
		padding: 0 10px;
		margin-right: 1px;
	}
	.button:last-child
	{
		margin-right: 0;
	}
}
.samBackground
{
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-size: cover;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
}
.samBackgroundItem
{
	position: fixed;
	height: 100%;
}
.samSupportUs
{
	.xf-siropuAdsManagerAdBlockReplaceMessage();
}
[data-position^="post_above_content_"]
{
	.samAlignLeft&
	{
		float: left;
		margin: 0 10px 0 0;
	}
	.samAlignRight&
	{
		float: right;
		margin: 0 0 0 10px;
		width: auto;
	}
}
[data-position^="node_title_above_"]
{
	.samAlignRight&
	{
		float: right;
		margin: 0 0 0 10px;
		width: auto;
	}
}
img[data-xf-init="sam-lazy"]
{
	display: none;
}
.samAdBlockDetected
{
	.p-body-pageContent, .p-body-sideNav, .p-body-sidebar
	{
		opacity: 0.15;
	}
}
#samNotice
{
	.xf-siropuAdsManagerAdBlockNotice();

	#samDismiss
	{
		.xf-siropuAdsManagerAdBlockNoticeDismiss();

		&:hover
		{
			text-decoration: none;
		}
	}
}
.samVideoOverlay
{
	position: absolute;
	width: 100%;
	height: 100%;
	z-index: 10;
	background-color: #000;
	opacity: 0.5;
	top: 0;
}
div[data-position="below_bb_code_attachment"]
{
	clear: both;
}
div[data-position="over_bb_code_video_attachment"]
{
	position: absolute;
	left: 0;
	right: 0;
	bottom: 25px;
	z-index: 11;
	text-align: center;
}
div[data-position="footer_fixed"]
{
	position: fixed;
	left: 0;
	right: 0;
	bottom: 0;
	margin-bottom: 0;
	z-index: 100;

	@{samItem}
	{
		position: relative;
	}
}
.samCloseButton
{
	position: absolute;
	top: 0;
	margin: -2px 0 0 -15px;
	z-index: 10;

	i
	{
		font-size: 20px;
		color: black;
		opacity: 0.5;
		
		&:hover
		{
			color: crimson;
			opacity: 1;
		}
	}
	.samLazyLoading &
	{
		display: none;
	}
}
.samOverlayCloseButton
{
	display: block;
}
.samResponsive
{
	&, @{samItem}
	{
		width: 100% !important;
		height: auto !important;
	}
}
@media (max-width: @xf-responsiveNarrow)
{
	.samResponsiveItems();

	.samCustomSize:not(.samCarousel), .samCustomSize:not(.samCarousel) @{samItem}
	{
		width: 100% !important;
		height: auto !important;
	}
	[data-position^="post_above_content_"]
	{
		.samAlignLeft&, .samAlignRight&
		{
			float: none;
			margin-bottom: 10px;
		}
	}
}
@media (max-width: @xf-responsiveMedium)
{
	.samDisplayFlexbox @{samItem}
	{
		flex: 100%;
		margin-right: 0;
	}
}
.swiper-container.sam-swiper-container
{
	width: 100%;
	margin-bottom: 20px;

	@{samItem}.swiper-slide
	{
		margin-top: 0 !important;
		height: auto !important;
	}
}
.samOverlayDisableClose .js-overlayClose
{
	display: none;
}
ins.adsbygoogle[data-ad-status="unfilled"]
{
    display: none !important;
}';
	return $__finalCompiled;
}
);