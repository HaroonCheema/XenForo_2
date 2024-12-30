<?php
// FROM HASH: 6f50df10b7ec394c1f157fd927b3022e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('public:color_picker.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('snog_forms.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/color_picker.js',
	));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['form'], 'isUpdate', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Form' . ': ' . $__templater->escape($__vars['form']['position']));
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add New Form');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', 'snogForms');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Questions', array(
		'href' => $__templater->func('link', array('form-editquestions/formquestions', $__vars['form'], ), false),
		'fa' => 'fa-question-circle',
	), '', array(
	)) . '
	' . $__templater->button('Delete', array(
		'href' => $__templater->func('link', array('form-forms/delete', $__vars['form'], ), false),
		'icon' => 'delete',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '


';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			';
	if (!$__templater->test($__vars['errorUsernames'], 'empty', array())) {
		$__compilerTemp1 .= '
				<div>' . 'You can not start a conversation with the following users because of their privacy settings: ' . $__templater->filter($__vars['errorUsernames'], array(array('join', array(', ', )),), true) . '.' . '</div>
			';
	}
	$__compilerTemp1 .= '

			';
	if (!$__templater->test($__vars['notFoundUsernames'], 'empty', array())) {
		$__compilerTemp1 .= '
				<div>' . 'The following users could not be found: ' . $__templater->filter($__vars['notFoundUsernames'], array(array('join', array(', ', )),), true) . '.' . '</div>
			';
	}
	$__compilerTemp1 .= '

			';
	if ($__vars['recipientLimit']) {
		$__compilerTemp1 .= '
				<div>' . 'You have exceeded the allowed number of recipients (' . $__templater->escape($__vars['recipientLimit']) . ') for this message.' . '</div>
			';
	}
	$__compilerTemp1 .= '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--error">
		' . $__compilerTemp1 . '
	</div>
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp2 = '';
	if ($__vars['copyform']) {
		$__compilerTemp2 .= '<input type="hidden" name="copyform" value="' . $__templater->escape($__vars['copyform']) . '">';
	}
	$__finalCompiled .= $__templater->form('
	' . '
	
	<div class="block-container">
		<h2 class="block-tabHeader tabs hScroller" data-xf-init="tabs h-scroller" data-state="replace" role="tablist">
			<span class="hScroller-scroll">
				' . '
				<a href="#form-data" id="form-data" class="tabs-tab is-active" role="tab" tabindex="0" aria-controls="form-data">' . 'Form' . '</a>
				<a href="#form-criteria" id="form-criteria" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-criteria">' . 'User criteria' . '</a>
				<a href="#form-report" id="form-report" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-report">' . 'Report type' . '</a>
				<a href="#form-redirect" id="form-redirect" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-redirect">' . 'Redirect options' . '</a>
				<a href="#form-promote" id="form-promote" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-promote">' . 'Promotion options' . '</a>
				<a href="#form-poll" id="form-poll" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-poll">' . 'Normal poll' . '</a>
				<a href="#form-misc" id="form-misc" class="tabs-tab" role="tab" tabindex="0" aria-controls="form-misc">' . 'Misc. options' . '</a>
				' . '
			</span>
		</h2>
		
		<ul class="tabPanes block-body">
			' . '
			<li class="is-active" role="tabpanel" id="form-data">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_data', $__vars) . '
			</li>

			<li role="tabpanel" id="form-criteria">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_criteria', $__vars) . '
			</li>

			<li role="tabpanel" id="form-report">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_report', $__vars) . '
			</li>
			
			<li role="tabpanel" id="form-redirect">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_redirect', $__vars) . '
			</li>
			
			<li role="tabpanel" id="form-promote">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_promote', $__vars) . '
			</li>
			
			<li role="tabpanel" id="form-poll">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_poll', $__vars) . '
			</li>
			
			<li role="tabpanel" id="form-misc">
				' . $__templater->includeTemplate('snog_forms_form_edit_tab_pane_misc', $__vars) . '
			</li>
			
			' . '

			' . $__compilerTemp2 . '
			
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
		</ul>
	</div>
', array(
		'action' => $__templater->func('link', array('form-forms/save', $__vars['form'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);