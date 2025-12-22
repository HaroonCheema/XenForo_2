<?php
// FROM HASH: a2ac5d72fb0fc901c3606dfe0d86f71a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.porta-countdown .block-body
{
	display: flex;
	flex-flow: wrap;
	padding: 6px 5px;
	text-align: center;

	.unit
	{
		background-color: rgba(0,0,0,0.1);
		border-radius: 3px;
		flex: 1;
		margin: 5px;
		padding: 10px;

		.poll
		{
			color: white;
			font-family: fantasy;
			font-size: 36px;
			text-shadow:
				 1px  1px 0 black,
				 1px -1px 0 black,
				-1px  1px 0 black,
				-1px -1px 0 black;
		}
		.text
		{
			font-size: 10px;
			text-transform: lowercase;
		}
	}
	.unit.full { flex-basis: 100%; }
	.unit.inactive { display: none; }
	.days .poll { font-size: 96px; line-height: 100px; }
}';
	return $__finalCompiled;
}
);