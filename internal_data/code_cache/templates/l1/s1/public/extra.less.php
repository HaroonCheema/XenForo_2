<?php
// FROM HASH: d41d8cd98f00b204e9800998ecf8427e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
' . $__templater->includeTemplate('Fs_NodeIcon_icon.less', $__vars) . '

.itemFavouriteClr
{
color: #1d9f1d !important;
}

.itemFavouriteClrBtn
{
background-color: #1d9f1d !important;
color: #fff !important;
}

.a-slider-heading
{
display: none;
}

.owl-carousel:has(.xb-item-block) .owl-dots {
    margin-top: 10px;
}

.owl-carousel:has(.xb-item-block) .owl-dots .owl-dot span {
    display: none;
}

.owl-carousel:has(.sliding-carousel-block) .owl-dots {
    margin-top: 10px;
}

.owl-carousel:has(.sliding-carousel-block) .owl-dots .owl-dot {
    display: none;
}';
	return $__finalCompiled;
}
);