<?php

return function($__templater, array $__vars, array $__options = [])
{
	$__widget = \XF::app()->widget()->widget('fs_custom_forum_widget', $__options)->render();

	return $__widget;
};