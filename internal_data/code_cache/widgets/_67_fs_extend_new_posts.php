<?php

return function($__templater, array $__vars, array $__options = [])
{
	$__widget = \XF::app()->widget()->widget('fs_extend_new_posts', $__options)->render();

	return $__widget;
};