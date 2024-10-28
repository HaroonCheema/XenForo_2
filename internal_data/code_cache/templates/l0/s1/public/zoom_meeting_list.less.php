<?php
// FROM HASH: 8c8b0bb9f3f28bf3c7a5c6f2abf5ddcc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_structItem-avatarSize: 36px;
@_structItem-avatarSizeExpanded: 48px;
@_structItem-avatarSizeEnd: @avatar-xxs;
@_structItem-cellPaddingH: ((@xf-paddingMedium) + (@xf-paddingLarge)) / 2; // average
@_structItem-cellPaddingV: @xf-paddingLarge;

.meeting_start_time{
	padding-bottom:8px !important;
}
.structItemContainer
{
	border-collapse: collapse;
	list-style: none;
	margin: 0;
	padding: 0;
	width: 100%;
}

.structItemContainer-group
{
}

.structItemContainer > .structItem:first-child,
.structItemContainer > .structItemContainer-group:first-child > .structItem:first-child
{
	border-top: none;
}

.structItem
{
	display: table;
	table-layout: fixed;
	border-collapse: collapse;
	border-top: @xf-borderSize solid @xf-borderColorFaint;
	list-style: none;
	margin: 0;
	padding: 0;
	width: 100%;

	&.is-highlighted,
	&.is-moderated
	{
		background: @xf-contentHighlightBg;
	}

	&.is-deleted
	{
		opacity: .7;

		.structItem-title > *
		{
			text-decoration: line-through;
		}
	}

	&.is-mod-selected
	{
		background: @xf-inlineModHighlightColor;
		opacity: 1;
	}
}

.structItem-cell
{
	display: table-cell;
	vertical-align: top;
	padding: @_structItem-cellPaddingV @_structItem-cellPaddingH;

	.structItem--middle &
	{
		vertical-align: middle;
	}

	&.structItem-cell--vote
	{
		width: (40px + (@_structItem-cellPaddingH) * 2);
	}

	&.structItem-cell--icon
	{
		width: ((@_structItem-avatarSize) + (@_structItem-cellPaddingH) * 2);
		position: relative;

		&.structItem-cell--iconExpanded
		{
			width: ((@_structItem-avatarSizeExpanded) + (@_structItem-cellPaddingH) * 2);
		}

		&.structItem-cell--iconEnd
		{
			width: ((@_structItem-avatarSizeEnd) + (@_structItem-cellPaddingH) * 2);
			padding-left: @_structItem-cellPaddingH / 2;

			.structItem-iconContainer
			{
				padding-top: @xf-paddingMedium;
			}
		}

		&.structItem-cell--iconFixedSmall
		{
			width: (60px + (@_structItem-cellPaddingH) * 2);
		}

		&.structItem-cell--iconFixedSmallest
		{
			width: ((@_structItem-avatarSizeEnd) + (@_structItem-cellPaddingH) * 2);
		}

		.solutionIcon
		{
			padding-left: 0;
			padding-right: 0;
		}
	}

	&.structItem-cell--meta
	{
		width: 135px;
	}

	&.structItem-cell--latest
	{
		width: 190px;
		text-align: right;
	}
}

.structItem-iconContainer
{
	position: relative;

	img
	{
		display: block;
		width: 100%;
	}

	.avatar
	{
		.m-avatarSize(@_structItem-avatarSize);

		&.avatar--xxs
		{
			.m-avatarSize(@_structItem-avatarSizeEnd);
		}
	}

	.structItem-secondaryIcon
	{
		position: absolute;
		right: -5px;
		bottom: -5px;

		.m-avatarSize(@_structItem-avatarSize / 2  + 2px);
	}

	.structItem-cell--iconExpanded &
	{
		.avatar
		{
			.m-avatarSize(@_structItem-avatarSizeExpanded);
		}

		.structItem-secondaryIcon
		{
			.m-avatarSize(@_structItem-avatarSizeExpanded / 2 - 2px);
		}
	}
}

.structItem-title
{
	font-size: @xf-fontSizeLarge;
	font-weight: @xf-fontWeightNormal;
	margin: 0;
	padding: 0;

	.label
	{
		font-weight: @xf-fontWeightNormal;
	}

	.is-unread &
	{
		font-weight: @xf-fontWeightHeavy;
	}
}

.structItem-minor
{
	font-size: @xf-fontSizeSmaller;
	color: @xf-textColorMuted;

	.m-hiddenLinks();
}

.structItem-parts
{
	.m-listPlain();
	display: inline;

	> li
	{
		display: inline;
		margin: 0;
		padding: 0;

		&:nth-child(even)
		{
			color: @xf-textColorDimmed;
		}

		&:before
		{
			content: "\\00B7\\20";
		}

		&:first-child:before
		{
			content: "";
			display: none;
		}
	}
}

.structItem-pageJump
{
	margin-left: 8px;
	font-size: @xf-fontSizeSmallest;

	a
	{
		.xf-chip();
		text-decoration: none;
		border-radius: @xf-borderRadiusSmall;
		padding: 0 3px;
		opacity: .5;
		.m-transition();

		.structItem:hover &,
		.has-touchevents &
		{
			opacity: 1;
		}

		&:hover
		{
			text-decoration: none;
			.xf-chipHover();
		}
	}
}

.structItem-statuses,
.structItem-extraInfo
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

.structItem-statuses .reactionSummary
{
	vertical-align: -2px;
}

.structItem-extraInfo .reactionSummary
{
	vertical-align: middle;
}

.structItem-status
{
	&::before
	{
		.m-faBase();
		display: inline-block;
		font-size: 90%;
		color: @xf-textColorMuted;
	}

	&--deleted::before { .m-faContent(@fa-var-trash-alt, .875em); }
	&--locked::before { .m-faContent(@fa-var-lock, .875em); }
	&--moderated::before { .m-faContent(@fa-var-shield, 1em); color: @xf-textColorAttention; }
	&--redirect::before { .m-faContent(@fa-var-external-link, 1em); }
	&--starred::before { .m-faContent(@fa-var-star, 1.125em); color: @xf-starFullColor; }
	&--sticky::before { .m-faContent(@fa-var-thumbtack, .75em); }
	&--watched::before { .m-faContent(@fa-var-bell, .875em); }

	&--solved::before { .m-faContent(@fa-var-check-circle, 1em); color: @xf-votePositiveColor; }
	&--attention::before { .m-faContent(@fa-var-bullhorn, 1.125em); color: @xf-textColorAttention; }
	&--upvoted::before { .m-faContent(@fa-var-thumbs-up, 1em); }
	&--downvoted::before { .m-faContent(@fa-var-thumbs-down, 1em); }
}

.structItem.structItem--note
{
	.xf-contentHighlightBase();
	color: @xf-textColorFeature;

	.structItem-cell
	{
		padding-top: @_structItem-cellPaddingV / 2;
		padding-bottom: @_structItem-cellPaddingV / 2;
		font-size: @xf-fontSizeSmaller;
		text-align: center;
	}
}

@media (max-width: @xf-responsiveWide)
{
	.structItem-cell
	{
		vertical-align: top;

		&.structItem-cell--meta
		{
			width: 115px;
			font-size: @xf-fontSizeSmaller;
		}

		&.structItem-cell--latest
		{
			width: 140px;
			font-size: @xf-fontSizeSmaller;
		}
	}
}

@media (max-width: @xf-responsiveMedium)
{
	.structItem-cell
	{
		//padding: (@_structItem-cellPaddingV) / 2 @_structItem-cellPaddingH;

		&.structItem-cell--icon
		{
			.structItem-cell + &
			{
				padding-left: 0;
				width: ((@_structItem-avatarSize) + (@_structItem-cellPaddingH));
			}
		}

		&.structItem-cell--main,
		&.structItem-cell--newThread
		{
			display: block;
			padding-bottom: .2em;

			.structItem-cell + &
			{
				padding-left: 0;
			}
		}

		&.structItem-cell--meta
		{
			display: block;
			width: auto;
			float: left;
			padding-top: 0;
			padding-left: 0;
			padding-right: 0;
			color: @xf-textColorMuted;

			.structItem-minor
			{
				display: none;
			}

			.pairs
			{
				> dt,
				> dd
				{
					display: inline;
					float: none;
					margin: 0;
				}
			}
		}

		&.structItem-cell--latest
		{
			display: block;
			width: auto;
			float: left;
			padding-top: 0;
			padding-left: 0;

			&:before
			{
				content: "\\00A0\\00B7\\20";
				color: @xf-textColorMuted;
			}

			a
			{
				color: @xf-textColorMuted;
			}

			.structItem-minor
			{
				display: none;
			}
		}

		&.structItem-cell--iconEnd
		{
			display: none;
		}
	}

	.structItem-pageJump,
	.structItem-extraInfoMinor
	{
		display: none;
	}

	.is-unread .structItem-latestDate
	{
		font-weight: @xf-fontWeightNormal;
	}
}

@media (max-width: @xf-responsiveNarrow)
{
	.structItem-parts
	{
		.structItem-startDate
		{
			display: none;
		}
	}

	.structItem.structItem--quickCreate
	{
		.structItem-cell--icon,
		.structItem-cell--vote
		{
			display: none;
		}

		.structItem-cell--newThread
		{
			padding-left: @_structItem-cellPaddingH;
			padding-bottom: @_structItem-cellPaddingH;
		}
	}
}

// ############################ RESOURCE LIST ######################

.structItem-resourceTagLine
{
	font-size: @xf-fontSizeSmaller;
	margin-top: @xf-paddingSmall;
}

.structItem-cell.structItem-cell--resourceMeta
{
	width: 238px;

	.structItem-metaItem
	{
		margin-top: 3px;

		&:first-child
		{
			margin-top: 0;
		}
	}
}

.structItem-metaItem--rating
{
	font-size: @xf-fontSizeSmall;
}

.structItem-status
{
	&--team::before { .m-faContent(@fa-var-users-crown); color: @xf-textColorAttention; }
}

@media (max-width: @xf-responsiveWide)
{
	.structItem-cell.structItem-cell--resourceMeta
	{
		width: 200px;
		font-size: @xf-fontSizeSmaller;
	}
}

@media (max-width: @xf-responsiveMedium)
{
	.structItem-cell.structItem-cell--resourceMeta
	{
		display: block;
		width: auto;
		float: left;
		padding-top: 0;
		padding-left: 0;
		padding-right: 0;
		color: @xf-textColorMuted;

		.pairs
		{
			display: inline;

			&:before,
			&:after
			{
				display: none;
			}

			> dt,
			> dd
			{
				display: inline;
				float: none;
				margin: 0;
			}
		}

		.structItem-metaItem
		{
			display: inline;
			margin-top: 0;
		}

		.ratingStarsRow
		{
			display: inline;

			.ratingStarsRow-text
			{
				display: none;
			}
		}

		.ratingStars
		{
			font-size: 110%;
			vertical-align: -.2em;
		}

		.structItem-metaItem--lastUpdate > dt
		{
			display: none;
		}

		.structItem-metaItem + .structItem-metaItem:before
		{
			display: inline;
			content: "\\20\\00B7\\20";
			color: @xf-textColorMuted;
		}
	}
}

// #################################### RESOURCE BODY / VIEW ########################

.resourceBody
{
	display: flex;
}

.resourceBody-main
{
	flex: 1;
	min-width: 0;
	padding: @xf-blockPaddingV @xf-blockPaddingH;
}

.resourceBody-main .bbWrapper
{
	.m-clearFix();
}

.resourceBody-sidebar
{
	flex: 0 0 auto;
	width: 250px;
	.xf-contentAltBase();
	border-left: @xf-borderSize solid @xf-borderColor;
	padding: @xf-blockPaddingV @xf-blockPaddingH;
	font-size: @xf-fontSizeSmall;

	> :first-child
	{
		margin-top: 0;
	}

	> :last-child
	{
		margin-bottom: 0;
	}
}

.resourceBody-fields
{
	&.resourceBody-fields--before
	{
		margin-bottom: @xf-paddingLarge;
		padding-bottom: @xf-paddingMedium;
		border-bottom: @xf-borderSize solid @xf-borderColorLight;
	}

	&.resourceBody-fields--after
	{
		margin-top: @xf-paddingLarge;
		padding-top: @xf-paddingMedium;
		border-top: @xf-borderSize solid @xf-borderColorLight;
	}
}

.resourceBody-attachments
{
	margin: .5em 0;
}

.resourceBody .actionBar-set
{
	margin-top: @xf-messagePadding;
	font-size: @xf-fontSizeSmall;
}

.resourceSidebarGroup
{
	margin-bottom: @xf-elementSpacer;

	&.resourceSidebarGroup--buttons
	{
		> .button
		{
			display: block;
			margin: 5px 0;

			&:first-child
			{
				margin-top: 0;
			}

			&:last-child
			{
				margin-bottom: 0;
			}
		}
	}
}

.resourceSidebarGroup-title
{
	margin: 0;
	padding: 0;

	font-size: @xf-fontSizeLarge;
	font-weight: @xf-fontWeightNormal;
	color: @xf-textColorFeature;
	padding-bottom: @xf-paddingMedium;

	.m-hiddenLinks();
}

.resourceSidebarList
{
	.m-listPlain();

	> li
	{
		padding: @xf-paddingSmall 0;

		&:first-child
		{
			padding-top: 0;
		}

		&:last-child
		{
			padding-bottom: 0;
		}
	}
}

@media (max-width: @xf-responsiveWide)
{
	.resourceBody
	{
		display: block;
	}

	.resourceBody-sidebar
	{
		width: auto;
		border-left: none;
		border-top: @xf-borderSize solid @xf-borderColor;
	}

	.resourceSidebarGroup
	{
		max-width: 600px;
		margin-left: auto;
		margin-right: auto;
	}
}';
	return $__finalCompiled;
}
);