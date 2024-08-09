<?php
// FROM HASH: 6194ec87cf779245d99c49386a34b4df
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['filter_location'] === 'above_thread_list') {
		$__finalCompiled .= '
    ';
		$__templater->includeCss('altf_above_thread_filter_container.less');
		$__finalCompiled .= '
    <div class="block filterAboveThreadList">
        <div class="block-outer">
            <div class="block-container">
                <h3 class="block-minorHeader block-filterBar">
                    ';
		if ($__vars['xf']['options']['altf_auto_collapse']) {
			$__finalCompiled .= '
                        <span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
                            ' . 'Filters' . '
                        </span>
                        ';
		} else {
			$__finalCompiled .= '
                        <span>
                            ' . 'Filters' . '
                        </span>
                    ';
		}
		$__finalCompiled .= '
                </h3>
                ' . '
                ' . $__templater->callMacro('altf_thread_filter_form_macros', 'field_form_setup', array(), $__vars) . '
                ';
		if ($__vars['xf']['options']['altf_auto_collapse']) {
			$__finalCompiled .= '
                    <div class="block-body block-body--collapsible">
                        ' . $__templater->includeTemplate('forum_filters', $__vars) . '
                    </div>
                    ';
		} else {
			$__finalCompiled .= '
                    <div class="block-body">
                        ' . $__templater->includeTemplate('forum_filters', $__vars) . '
                    </div>
                ';
		}
		$__finalCompiled .= '
            </div>
        </div>
    </div>
';
	}
	return $__finalCompiled;
}
);