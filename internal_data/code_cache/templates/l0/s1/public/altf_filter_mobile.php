<?php
// FROM HASH: 3335e92321d6ddd3c5bbe45d27f7d78f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['altf_off_canvas_filter'] AND $__vars['thread_fields_active']) {
		$__finalCompiled .= '
    ';
		$__templater->includeCss('altf_filter_mobile.less');
		$__finalCompiled .= '
    <div class="offCanvasMenu offCanvasMenu--nav js-headerOffCanvasFilter" data-menu="menu" aria-hidden="true"
         data-ocm-builder="navigation">
        <div class="offCanvasMenu-backdrop" data-menu-close="true"></div>
        <div class="offCanvasMenu-content">
            <div class="offCanvasMenu-header">
                ' . 'Filters' . '
                <a class="offCanvasMenu-closer" data-menu-close="true" role="button" tabindex="0"
                   aria-label="' . 'Close' . '"></a>
            </div>
            ' . '
            ' . $__templater->includeTemplate('forum_filters', $__vars) . '
        </div>
    </div>
';
	}
	return $__finalCompiled;
}
);