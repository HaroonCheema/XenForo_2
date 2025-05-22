<?php
// FROM HASH: 2f74365efd601ba4dfb4ea86ff88eb72
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.pfEsSymbolList
{
	.m-listPlain();

	display: flex;
	flex-wrap: wrap;
	justify-content: flex-start;

	margin-right: -3px;
	margin-bottom: -3px;

	> li
	{
		min-width: 20px;
		margin-right: 3px;
		margin-bottom: 3px;
		
		border-radius: @xf-borderRadiusMedium;
		cursor: pointer;

		&:hover,
		&:focus
		{
			background-color: @xf-paletteColor2;
		}

		a
		{
			min-width: 20px;
			height: 20px;
			font-size: 18px;

			display: flex;
			justify-content: center;
			align-items: center;
			cursor: pointer;
			overflow: hidden;

			&:hover,
			&:focus
			{
				text-decoration: none;
			}
		}
	}
}';
	return $__finalCompiled;
}
);