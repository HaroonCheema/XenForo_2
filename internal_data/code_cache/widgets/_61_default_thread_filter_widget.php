<?php

return function($__templater, array $__vars, array $__options = [])
{
	$__widget = \XF::app()->widget()->widget('default_thread_filter_widget', $__options)->render();

	return $__widget;
};