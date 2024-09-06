<?php
// FROM HASH: ab683a49d0661ced193f8c4355ed920e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.withdrawalQueue
{
	.block-container.withdrawalQueue-item--sent
	{
		.message,
		.message-cell--user,
		.message-cell--extra
		{
			background: @xf-inlineModHighlightColor;
		}

		.message .message-userArrow:after
		{
			border-right-color: @xf-inlineModHighlightColor;
		}
	}

	.block-container.withdrawalQueue-item--rejected
	{
		.message-cell--user,
		.message-cell--main
		{
			opacity: 0.25;
		}
	}
}';
	return $__finalCompiled;
}
);