<?php
// FROM HASH: 41ebb08d632e0159a98c5c344ff181a8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.button,
a.button // needed for specificity over a:link
{
	&.button--provider
	{
		&--nick_trakt
		{
			.m-buttonColorVariation(#7289DA, white);
			.button-text::before {
				background: url(styles/nick97/TraktLogo/trakt-icon-red.svg);
				width: 20px;
				height: 20px;
				background-size: 20px 20px;
				background-position: center;
				content: \' \';
				display: inline-block;
				margin-left: -3px;
				margin-top: -8px;
				margin-right: 0;
			}
		}
	}
}';
	return $__finalCompiled;
}
);