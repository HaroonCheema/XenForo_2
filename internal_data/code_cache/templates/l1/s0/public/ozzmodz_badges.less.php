<?php
// FROM HASH: 5dc4594e3d015854ecc0d4ec1a947b78
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.category-icon
{
	text-align: center;
	border-right: 1px solid @xf-borderColorFaint;

	padding-right: 10px;
	margin-right: 5px;
	
	&--fa { }
	
	&--mdi { line-height: 1; }
	
	&--img
	{
		width: ~\'calc(22px + 10px)\';
		height: 22px;
		
		position: relative;
		top: 3px;
		text-indent: 100%;
    	white-space: nowrap;
    	overflow: hidden;
	}
}

.badge-extra
{
	.reason a
	{
		text-decoration: underline;
	}

	.edit-reason
	{
		opacity: 0;
		transition: opacity .2s;
	
		.badgeItem:hover &
		{
			opacity: 1;
		}
	}
	
	.extra-item:not(:last-child)
	{
		margin-right: @xf-paddingMedium;
	}
}

.badgeItem
{
	.contentRow-figureIcon i
	{
		font-size: 3em;
		overflow: visible;
	}
	
	.contentRow-badgeStack
	{
		li { margin-right: 5px; }
		i { font-size: 2em; }
		img { width: 32px; }
		svg { width: 32px; }
		
		.badge-stacked
		{
			position: relative;
		}
	}
	
	&:hover .featureIcon
	{
		opacity: 0.65;
	}
	
	.featureIcon
	{
		margin-left: @xf-paddingSmall;
		
		color: @xf-textColorMuted;
		font-size: @xf-fontSizeSmall;
		opacity: 0.3;
		transition: opacity 0.2s;
		
		&:hover
		{
			opacity: 1;
		}
		
		&--featured
		{
			opacity: 1 !important;
			color: @xf-textColorAttention;
		}
		
		&--stacked
		{
			position: absolute;
			top: -10px;
			right: -10px;
			font-size: 0.5em;
		}
	}
}

//
// Badge icon + title on new line when in menu
//

.menu-row .badgeAlert
{
	display: block;
	margin: @xf-paddingSmall 0;
}

//
// Badge icon
//

.badgeIcon
{	
	&--fa
	{
		color: @xf-textColorFeature;
		text-align: center;
		
		&.badgeIcon-context--alert
		{
			position: relative;
			top: -1px;
		}
	}
	
	// Alert
	
	&.badgeIcon-context--alert
	{
		vertical-align: middle;
		width: 22px;
	}
	
	&--image
	{
		text-indent: 100%;
    	white-space: nowrap;
    	overflow: hidden;
	}

}

.contentRow-figureIcon
{
	.badgeIcon--mdi
	{
		display: inline-block;
		width: 64px;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal;
		border-radius: @xf-borderRadiusMedium;
	}
	
	.badgeIcon.badgeIcon--html svg
	{
		width: 64px;
	}
}';
	return $__finalCompiled;
}
);