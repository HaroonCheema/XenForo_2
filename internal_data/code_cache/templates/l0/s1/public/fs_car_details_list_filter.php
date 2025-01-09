<?php
// FROM HASH: dd84123467bf7c799576df8ea3b2dc84
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['models'])) {
		foreach ($__vars['models'] AS $__vars['val']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['val']['model_id'],
				'label' => $__templater->escape($__vars['val']['model']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="menu-row">
		' . 'Model :' . '
		<div class="u-inputSpacer">' . $__templater->formSelect(array(
		'name' => 'model_id',
		'value' => $__templater->filter($__vars['conditions']['model_id'], array(array('default', array(array(0, ), )),), false),
		'required' => 'required',
	), $__compilerTemp1) . '
		</div>
	</div>

	<div class="menu-row">
		' . 'Location :' . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'car_location',
		'value' => $__vars['conditions']['car_location'],
		'placeholder' => 'Filter by location...!',
	)) . '
		</div>
	</div>

	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
	</div>
	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('cars-list/', ), false),
	));
	return $__finalCompiled;
}
);