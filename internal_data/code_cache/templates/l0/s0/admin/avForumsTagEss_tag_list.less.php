<?php
// FROM HASH: 980cb804d32446f8d0881b2606b29b9f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@controlColor: xf-default(@xf-buttonPrimary--background-color, @xf-paletteColor4);
@controlColor--hover: xf-intensify(@controlColor, 25%);



.dataList-cell--iconic
{
	.dataList-blackList,
	.dataList-wiki
	{
		&:before
		{
			color: @controlColor;
		}
	}

	&:hover
	{
		.dataList-blackList,
		.dataList-wiki
		{
			&:before
			{
				color: @controlColor--hover;
			}
		}
	}
}';
	return $__finalCompiled;
}
);