<?php

return function($__templater, array $__vars, array $__options = [])
{
	$__widget = \XF::app()->widget()->widget('search_article', $__options)->render();

	return $__widget;
};