<?php
// FROM HASH: ea1b73d791443dda54d855a2561e7684
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Manually give credit package to user');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'ac' => 'single',
	), array(
		'label' => 'Username',
	)) . '

			' . $__templater->formRow($__templater->escape($__vars['creditPackage']['title']), array(
		'label' => 'Credit package',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'end_type',
	), array(array(
		'value' => 'permanent',
		'selected' => !$__vars['endDate'],
		'label' => 'Never',
		'_type' => 'option',
	),
	array(
		'value' => 'date',
		'selected' => $__vars['endDate'],
		'label' => 'Date' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formDateInput(array(
		'name' => 'end_date',
		'value' => ($__vars['endDate'] ? $__templater->func('date', array($__vars['endDate'], 'picker', ), false) : $__templater->func('date', array($__vars['xf']['time'], 'picker', ), false)),
	))),
		'_type' => 'option',
	)), array(
		'label' => 'Credits expire',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('thtc-credit-package/manual', $__vars['creditPackage'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);