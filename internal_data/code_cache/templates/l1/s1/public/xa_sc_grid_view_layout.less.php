<?php
// FROM HASH: 874b96123e4bbf9aed4370a30d215054
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.gridContainerScGridView .sc-grid-view
{
	.m-listPlain();
	.m-clearFix();
	display: flex;
	flex-wrap: wrap;
	margin: 3px;

	.grid-image-link
	{
		display: block;
		position: relative;
		overflow: hidden;
		background: #ccc;
		min-height: 260px;
		transition: all .5s;
		&:hover
		{
			transform: scale(1.07);
		}
	}

	.grid-container
	{
		flex: 1 1 33%;  
		max-width: 33%; 
		padding: 5px;

		@media (max-width: 1850px) { flex: 1 1 50%; max-width: 50%;}
		@media (max-width: @xf-responsiveWide) { flex: 1 1 50%; max-width: 50%;}
		@media (max-width: @xf-responsiveMedium) { flex: 1 1 100%; max-width: 100%;}
		@media (max-width: @xf-responsiveNarrow) { flex: 1 1 100%; max-width: 100%;}
		
		&.is-unread
		{
			.grid-caption .grid-item-heading
			{
				font-weight: @xf-fontWeightHeavy;
			}
		}	
		&.is-mod-selected
		{
			background: @xf-inlineModHighlightColor !important;
			opacity: 1;
		}
		&.is-moderated
		{
			background: @xf-contentHighlightBg;
			
			.grid-caption .grid-item-heading
			{
				font-style: italic;
			}
		}
		&.is-deleted
		{
			opacity: .7;

			.grid-caption .grid-item-heading
			{
				text-decoration: line-through;
			}
		}		
	}

	.grid-item
	{
		position: relative;
		overflow: hidden;
		&.large-grid-item
		{
			.grid-image-link:after
			{
				height: 60%;
			}
		}
	}

	.grid-caption
	{
		max-width: 100%;
		position: relative;
		padding: 10px 0px;
		bottom: 0px;
		display: block;
		pointer-events: auto;
		&.grid-caption-small
		{
			max-width: initial;
		}
		.grid-item-category-title-header
		{
			padding-bottom: 5px;
			font-size: @xf-fontSizeSmaller;
			font-style: italic;
			color: @xf-textColorMuted;
		}			
		.grid-item-heading
		{
			display: block;
			padding-bottom: 5px;
			font-size: @xf-fontSizeLarge;
			font-weight: @xf-fontWeightNormal;
			line-height: 1.4;
			color: @xf-linkColor;

		}
		h3
		{
			padding: 0;
			margin: 0;
		}
		.grid-item-location
		{
			font-size: @xf-fontSizeSmaller;
			color: @xf-textColorDimmed;
			padding-bottom: @xf-paddingMedium;

			.grid-item-location-icon
			{
				font-size: @xf-fontSizeSmall;
				padding-left: @xf-paddingSmall;
			}
		}
		.grid-description
		{
			padding-top: @xf-paddingMedium;
			padding-bottom: @xf-paddingMedium;	
		}	
		.listInline.listInline--bullet
		{
			color: @xf-textColorDimmed;
			font-size: @xf-fontSizeSmaller;
		}
		.publish-date,
		.category-title	
		{
			color: @xf-textColorDimmed;
			font-size: @xf-fontSizeSmaller;
		}
		.grid-item-minor
		{
			font-size: @xf-fontSizeSmaller;
			color: @xf-textColorMuted;

			.m-hiddenLinks();
		}
		.grid-item-extraInfo
		{
			.m-listPlain();
			float: right;

			> li
			{
				float: left;
				margin-left: 8px;
			}

			input[type=checkbox]
			{
				.m-checkboxAligner();
			}
		}
		.grid-item-ScItemCustomFieldsOnList
		{
			font-size: @xf-fontSizeSmaller;
			margin-top: @xf-paddingSmall;
			margin-bottom: @xf-paddingSmall;
		}		
	}
}

@media (max-width:800px)
{
	.gridContainerScGridView .sc-grid-view .grid-image-link
	{
		min-height: 240px;
	}

	.gridContainerScGridView .sc-grid-view .grid-caption
	{
		padding: 8px;
		max-width: 100%;
		bottom: 0;
	}

	.gridContainerScGridView .sc-grid-view .grid-caption .grid-item-heading
	{
		padding-bottom: 0px;
		font-size: @xf-fontSizeLarge;
	}
}

@media (max-width:650px)
{
	.gridContainerScGridView .sc-grid-view .grid-container
	{
		float: none;
		width: auto;
		padding: 0;
		margin-bottom: 10px;
	}
}';
	return $__finalCompiled;
}
);