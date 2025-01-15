<?php
// FROM HASH: 05af2f654e7c42dbcd322ecb4a64df3d
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
	$__compilerTemp2 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['locations'])) {
		foreach ($__vars['locations'] AS $__vars['val']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['val']['location_id'],
				'label' => $__templater->escape($__vars['val']['location']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="menu-row">
		' . 'Username :' . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'fs_car_details_username',
		'value' => $__vars['conditions']['fs_car_details_username'],
		'ac' => 'single',
	)) . '
		</div>
	</div>

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
		<div class="u-inputSpacer">' . $__templater->formSelect(array(
		'name' => 'location_id',
		'value' => $__templater->filter($__vars['conditions']['location_id'], array(array('default', array(array(0, ), )),), false),
		'required' => 'required',
	), $__compilerTemp2) . '
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