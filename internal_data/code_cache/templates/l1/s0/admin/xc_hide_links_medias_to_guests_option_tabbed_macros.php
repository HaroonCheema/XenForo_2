<?php
// FROM HASH: ca0f2f9a67d0eebe28cf6e1671607b1b
return array(
'macros' => array('option_form_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'options' => '!',
		'containerBeforeHtml' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	if (!$__templater->test($__vars['options'], 'empty', array())) {
		$__finalCompiled .= '

        ';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp1 .= '
                            ';
				if ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 100) {
					$__compilerTemp1 .= '
                                ' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
                            ';
				}
				$__compilerTemp1 .= '
                            ';
			}
		}
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp2 .= '
                            ';
				if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 100) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 200)) {
					$__compilerTemp2 .= '
                                ' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
                            ';
				}
				$__compilerTemp2 .= '
                            ';
			}
		}
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp3 .= '
                            ';
				if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 200) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 300)) {
					$__compilerTemp3 .= '
                                ' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
                            ';
				}
				$__compilerTemp3 .= '
                            ';
			}
		}
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp4 .= '
                            ';
				if (($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] >= 300) AND ($__vars['option']['Relations']['xc_hide_links_from_guests']['display_order'] < 400)) {
					$__compilerTemp4 .= '
                                ' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
                            ';
				}
				$__compilerTemp4 .= '
                            ';
			}
		}
		$__finalCompiled .= $__templater->form('
            ' . $__templater->filter($__vars['containerBeforeHtml'], array(array('raw', array()),), true) . '
            <div class="block-container">
                <h2 class="block-tabHeader tabs" data-xf-init="tabs" role="tablist">
					
                    <a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideLinkOptions">' . 'Hide links options' . '</a>
					<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideMediaOptions">' . 'Hide medias options' . '</a>
					<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideImageOptions">' . 'Hide images options' . '</a>
                    <a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="hideAttachOptions">' . 'Hide attach options' . '</a>
				</h2>
                <ul class="tabPanes">
                    <li class="is-active" role="tabpanel" id="hideLinkOptions">
                        <div class="block-body">
                            ' . $__compilerTemp1 . '
                        </div>
                    </li>
                    <li role="tabpanel" id="hideMediaOptions">
                        <div class="block-body">
                            ' . $__compilerTemp2 . '
                        </div>
                    </li>
					<li role="tabpanel" id="hideImageOptions">
                        <div class="block-body">
                            ' . $__compilerTemp3 . '
                        </div>
                    </li>
					<li role="tabpanel" id="hideAttachOptions">
                        <div class="block-body">
                            ' . $__compilerTemp4 . '
                        </div>
                    </li>
                </ul>
                ' . $__templater->formSubmitRow(array(
			'sticky' => 'true',
			'icon' => 'save',
		), array(
		)) . '
            </div>
        ', array(
			'action' => $__templater->func('link', array('options/update', ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);