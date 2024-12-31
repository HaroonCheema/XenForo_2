<?php
// FROM HASH: 0716944a62848c421ee64a99d519d26a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '//
// This stylesheet is for featured badges layout purposes only.
// DO NOT USE IT FOR STYLING! (use ozzmodz_badges.less instead)
//

.featuredBadges
{
    display: flex;
    flex-wrap: wrap;
	
	.featuredBadgesGridParams(@xf-ozzmodz_badges_message_badge_size, @xf-ozzmodz_badges_message_badges_gap);

	margin-top: 5px;
	
	.featuredBadge
	{
		position: relative;
		text-align: center;
		
		.label
		{
			position: absolute;
			.xf-ozzmodz_badges_featured_badges_label();
		}
	}
	
	&--message
	{	
		justify-content: center;
		margin: 5px 0;
		
		.badgeIcon { max-width: @xf-ozzmodz_badges_message_badge_size; }
		
		@media (max-width: @xf-messageSingleColumnWidth)
		{
			.badgeIcon { max-width: @xf-ozzmodz_badges_message_badge_size_single !important; }
			
			& when (@xf-ozzmodz_badges_show_on_mobile = 1)
			{
				& when (@xf-ozzmodz_badges_show_on_mobile_inline = 1)
				{
					width: 100%;
					justify-content: left;
				}
				& when (@xf-ozzmodz_badges_show_on_mobile_inline = 0)
				{
					position: sticky;
					float: right;
					//top: 10px;
					//left: 50px;
				}
    		}
			
			& when (@xf-ozzmodz_badges_show_on_mobile = 0) {
        		display: none;
			}
		}
	}
	
	&--member_view
	{
		.featuredBadgesGridParams(@xf-ozzmodz_badges_profile_badge_size, @xf-ozzmodz_badges_profile_badges_gap);
		
		@media (max-width: @xf-responsiveNarrow)
		{
			.badgeIcon { max-width: @xf-ozzmodz_badges_profile_badge_size_mobile !important; }
			
			justify-content: center;
		}
	}
	
	&--member_tooltip
	{
		.featuredBadgesGridParams(@xf-ozzmodz_badges_tooltip_badge_size, @xf-ozzmodz_badges_tooltip_badges_gap);
	}
	
	.tooltip-element { display: none; }
}

.featuredBadgesGridParams(@badgeSize, @gapSize)
{
	grid-template-columns: repeat(auto-fit, @badgeSize);
	gap: @gapSize;

	.featuredBadge
	{
		width: @badgeSize;
		height: @badgeSize;
		
		.badgeIcon--fa, .badgeIcon--mdi
		{
			font-size: @badgeSize;
			line-height: 1;
		}
	}
}';
	return $__finalCompiled;
}
);