<?php
// FROM HASH: 34bfa9aa3da9787650293d8ef5c3fd70
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@media (min-width: @xf-responsiveMedium)
{
	.node-extra .node-extra-icon--prefix when (ispixel(@xf-fontSizeSmall) = true)
	{
		@fontSizeInPx: @xf-fontSizeSmall;
		margin-bottom: max(0, @avatar-s - @fontSizeInPx * 3);
	}

	.node-extra .node-extra-icon--prefix when (ispixel(@xf-fontSizeSmall) = false)
	{
		@emInPx: 16px;
		@fontSizeInPx: unit(unit(@xf-fontSizeSmall) * @emInPx, px);
		margin-bottom: max(0, @avatar-s - @fontSizeInPx * 3);
	}
}';
	return $__finalCompiled;
}
);