<?php
// FROM HASH: 2614c9ec5649c7c15ce535522631fee1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['type'], 'isUpdate', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Type' . ': ' . $__templater->escape($__vars['type']['type']));
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Form Type');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->setPageParam('section', 'snogTypes');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . '
			' . $__templater->formTextBoxRow(array(
		'name' => 'type',
		'value' => $__vars['type']['type'],
		'maxlength' => $__templater->func('max_length', array($__vars['type'], 'type', ), false),
	), array(
		'label' => 'Type name',
		'explain' => 'Enter the name of this form type.',
	)) . '

			' . '
			' . $__templater->formRow('
				<div class="inputGroup">
					<div class="inputGroup inputGroup--numbers inputNumber" data-xf-init="number-box">
						' . $__templater->formTextBox(array(
		'name' => 'display',
		'value' => (($__vars['type']['display'] >= 1) ? $__vars['type']['display'] : 1),
		'type' => 'number',
		'min' => '1',
		'class' => 'input input--number js-numberBoxTextInput js-permissionIntInput',
	)) . '
					</div>
				</div>
			', array(
		'label' => 'Display order',
		'rowtype' => 'input',
	)) . '
			
			' . '
			' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'name' => 'active',
		'selected' => $__vars['type']['active'],
		'_type' => 'option',
	)), array(
		'label' => 'This type is active',
		'explain' => 'Check this box to activate this form type.<br />If this type is not active, all forms that use this type will not be shown even if the form itself is active.',
	)) . '

			' . '
			' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'name' => 'sidebar',
		'selected' => $__vars['type']['sidebar'],
		'_type' => 'option',
	)), array(
		'label' => 'Show in widget',
		'explain' => 'Check this box to show this type in the forms widget',
	)) . '
			
			' . '
			' . $__templater->formCheckBoxRow(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'name' => 'navtab',
		'selected' => $__vars['type']['navtab'],
		'_type' => 'option',
	)), array(
		'label' => 'Show in navigation tab',
		'explain' => 'Check this box to show this type in the forms list when the forms navigation tab is selected.',
	)) . '
			
			<h3 class="block-formSectionHeader">
				<span class="block-formSectionHeader-aligner"><b>' . 'User criteria' . '</b></span>
			</h3>
				
			<div class="block-body">
				' . $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'A user must meet the criteria set here to view this form type and fill out all forms in this form type (including admins)',
	)) . '

				' . $__templater->filter($__vars['userCriteriaRendered'], array(array('raw', array()),), true) . '
			</div>
			
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('form-types/save', $__vars['type'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);