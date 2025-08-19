<?php
// FROM HASH: e0eca96cad68a1c5375b77494e407abf
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Clone package' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['package']['title']));
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'This option allows you to create a new package with the same settings and criteria as "' . $__templater->escape($__vars['package']['title']) . '" package.' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" role="tablist">
			<span class="hScroller-scroll">
				<a class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="basicInformation">' . 'Basic information' . '</a>
				<a class="tabs-tab" role="tab" tabindex="0" aria-controls="advertising">' . 'Advertising' . '</a>
			</span>
		</h2>

		<ul class="tabPanes block-body">
			' . $__templater->callMacro('siropu_ads_manager_package_edit', 'basic_info_pane', array(
		'package' => $__vars['clone'],
	), $__vars) . '
			' . $__templater->callMacro('siropu_ads_manager_package_edit', 'advertising_pane', array(
		'package' => $__vars['clone'],
		'advertiserCriteria' => $__vars['advertiserCriteria'],
		'advertiserUserGroups' => $__vars['advertiserUserGroups'],
		'clone' => true,
	), $__vars) . '
		</ul>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'submit' => 'Clone',
		'sticky' => 'true',
	), array(
		'rowtype' => 'simple',
	)) . '
 	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/packages/clone', $__vars['package'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);