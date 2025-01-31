<?php
// FROM HASH: bc95e103b891efaeea1af7670b9d898c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['models'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('FS\\UserCarDetails:Models', )), 'getModels', array());
	$__finalCompiled .= '
';
	$__vars['locations'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('FS\\UserCarDetails:Models', )), 'getLocations', array());
	$__finalCompiled .= '

<li role="tabpanel" id="car-details">
	<div class="block-body">
		';
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
	$__finalCompiled .= $__templater->formRow('

			<ul class="inputList">
				<li>' . $__templater->formSelect(array(
		'name' => 'model_id',
		'value' => $__templater->filter($__vars['user']['CarDetail']['model_id'], array(array('default', array(array(0, ), )),), false),
	), $__compilerTemp1) . '</li>
			</ul>
		', array(
		'rowtype' => 'input',
		'label' => 'Model',
		'explain' => 'Select your car model...!',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_colour',
		'value' => $__vars['user']['CarDetail']['car_colour'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car colour here..!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Colour',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_trim',
		'value' => $__vars['user']['CarDetail']['car_trim'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car trim  here...!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Trim',
	)) . '

		';
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
	$__finalCompiled .= $__templater->formRow('

			<ul class="inputList">
				<li>' . $__templater->formSelect(array(
		'name' => 'location_id',
		'value' => $__templater->filter($__vars['user']['CarDetail']['location_id'], array(array('default', array(array(0, ), )),), false),
	), $__compilerTemp2) . '</li>
			</ul>
		', array(
		'rowtype' => 'input',
		'label' => 'Location',
		'explain' => 'Select your car location...!',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_plaque_number',
		'value' => $__vars['user']['CarDetail']['car_plaque_number'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car plaque number here...!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Plaque Number',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_reg_number',
		'value' => $__vars['user']['CarDetail']['car_reg_number'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car reg number here...!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Reg Number',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formDateInput(array(
		'name' => 'car_reg_date',
		'value' => ($__vars['user']['CarDetail']['car_reg_date'] ? $__templater->func('date', array($__vars['user']['CarDetail']['car_reg_date'], 'picker', ), false) : ''),
	)) . '

		', array(
		'rowtype' => 'input',
		'label' => 'Car Reg Date',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_forum_name',
		'value' => $__vars['user']['CarDetail']['car_forum_name'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter forum name here...!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Forum Name',
	)) . '

		' . $__templater->formRow('
			' . $__templater->formTextBoxRow(array(
		'name' => 'car_unique_information',
		'value' => $__vars['user']['CarDetail']['car_unique_information'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter unique information here...!',
	)) . '
		', array(
		'rowtype' => 'input',
		'label' => 'Unique Information',
	)) . '
	</div>
	' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
</li>';
	return $__finalCompiled;
}
);