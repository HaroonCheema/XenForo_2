<?php

return function($__templater, array $__vars, array $__options = [])
{
	$__widget = \XF::app()->widget()->widget('fs_who_replied_thread_members', $__options)->render();

	return $__widget;
};