<?php
// FROM HASH: 4107598716e61f9c79cabb23ea8d1d01
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['altf_off_canvas_filter'] AND ($__vars['thread_fields_active'] AND ($__vars['xf']['options']['altf_filter_icon_location'] === 'search_icon'))) {
		$__finalCompiled .= '
    ';
		$__templater->includeCss('altf_filter_mobile.less');
		$__finalCompiled .= '
    <a class="p-navgroup-link p-navgroup-link--iconic p-navgroup-link--filter" data-xf-click="off-canvas"
       data-menu=".js-headerOffCanvasFilter" role="button" tabindex="0">
        <i aria-hidden="true"></i>
        <span class="p-navgroup-linkText">' . 'Filters' . '</span>
    </a>
';
	}
	return $__finalCompiled;
}
);