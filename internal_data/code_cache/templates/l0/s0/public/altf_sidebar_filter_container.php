<?php
// FROM HASH: e3615c98427d5989fdbe596f313acb2a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block filterSideBar" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
    <div class="block-container">
        <h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
        <div class="block-body">
            ' . '
            ' . $__templater->callMacro('altf_thread_filter_form_macros', 'field_form_setup', array(), $__vars) . '
            ' . $__templater->includeTemplate('forum_filters', $__vars) . '
        </div>
    </div>
</div>';
	return $__finalCompiled;
}
);