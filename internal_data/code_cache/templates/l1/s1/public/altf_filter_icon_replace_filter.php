<?php
// FROM HASH: b814f1749f4cec4952abb93e8726f8c3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['altf_off_canvas_filter'] AND ($__vars['xf']['options']['altf_filter_icon_location'] === 'replace_filter')) {
		$__finalCompiled .= '
    ';
		$__templater->includeCss('altf_filter_mobile.less');
		$__finalCompiled .= '
    <a class="p-filter-link p-filter-link--iconic p-filter-link--filter" data-xf-click="off-canvas"
       data-menu=".js-headerOffCanvasFilter" role="button" tabindex="0">
        <i aria-hidden="true"></i>
        <span class="p-filter-linkText">' . 'Filters' . '</span>
    </a>
';
	}
	return $__finalCompiled;
}
);