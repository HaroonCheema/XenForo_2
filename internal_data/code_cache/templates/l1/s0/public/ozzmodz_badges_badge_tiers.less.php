<?php
// FROM HASH: 52d0e07306a114a32de7e8159ea3d02c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.ozzmodzBadges-tiers
{
    display: flex;
    flex-wrap: wrap;
	&--message
	{	
		justify-content: center;
		margin: 5px 0;
		
		@media (max-width: @xf-messageSingleColumnWidth)
		{
			& when (@xf-ozzmodz_badges_tiers_show_on_mobile = 0)
			{
				display: none !important;
			}

			&:not(.ozzmodzBadges-tiers--member_view)
			{
				justify-content: flex-start;
			}
		}
	}
	
	&--member_view
	{
		@media (max-width: @xf-responsiveNarrow)
		{
			justify-content: center;
		}
	}
}

.ozzmodzBadges-tierLabel
{
	font-size: 75%;
	font-weight: @xf-fontWeightNormal;
	font-style: normal;
	padding: 1px @xf-paddingMedium;
	border: 1px solid transparent;
	border-radius: @xf-borderRadiusSmall;
	text-align: center;
	display: inline-block;
	margin: 3px;
}

';
	if ($__templater->isTraversable($__vars['ozzmodzBadgesBadgeTiers'])) {
		foreach ($__vars['ozzmodzBadgesBadgeTiers'] AS $__vars['id'] => $__vars['tier']) {
			$__finalCompiled .= '
	.ozzmodzBadges-tier--' . $__templater->escape($__vars['id']) . '
	{
		border-left: 3px solid ' . $__templater->filter($__vars['tier']['color'], array(array('raw', array()),), true) . ';
		' . $__templater->filter($__vars['tier']['css'], array(array('raw', array()),), true) . '
	}

	.ozzmodzBadges-tierLabel--' . $__templater->escape($__vars['id']) . '
	{
		background: ' . $__templater->filter($__vars['tier']['color'], array(array('raw', array()),), true) . ';
	}
';
		}
	}
	return $__finalCompiled;
}
);