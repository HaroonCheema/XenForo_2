<?php
// FROM HASH: 13890ad7cbfb76e0efc0c6beb713a61a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['car']['car_id']) {
		$__compilerTemp1 .= ' ' . 'Edit Car Detail' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Edit Car Detail'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= ' ' . 'Add Car Detail' . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Add Car Detail'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	$__vars['models'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('FS\\UserCarDetails:Models', )), 'getModels', array());
	$__finalCompiled .= '
';
	$__vars['locations'] = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('FS\\UserCarDetails:Models', )), 'getLocations', array());
	$__finalCompiled .= '

';
	$__compilerTemp2 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['models'])) {
		foreach ($__vars['models'] AS $__vars['val']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['val']['model_id'],
				'label' => $__templater->escape($__vars['val']['model']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp3 = array(array(
		'value' => '0',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['locations'])) {
		foreach ($__vars['locations'] AS $__vars['val']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['val']['location_id'],
				'label' => $__templater->escape($__vars['val']['location']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'username',
		'value' => $__vars['car']['username'],
		'ac' => 'single',
	), array(
		'rowtype' => 'fullWidth',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Username',
	)) . '

			' . $__templater->formRow('

				<ul class="inputList">
					<li>' . $__templater->formSelect(array(
		'name' => 'model_id',
		'value' => $__templater->filter($__vars['car']['model_id'], array(array('default', array(array(0, ), )),), false),
	), $__compilerTemp2) . '</li>
				</ul>
			', array(
		'rowtype' => 'input',
		'label' => 'Model',
		'explain' => 'Select your car model...!',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_colour',
		'value' => $__vars['car']['car_colour'],
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
		'value' => $__vars['car']['car_trim'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car trim  here...!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Trim',
	)) . '

			' . $__templater->formRow('

				<ul class="inputList">
					<li>' . $__templater->formSelect(array(
		'name' => 'location_id',
		'value' => $__templater->filter($__vars['car']['location_id'], array(array('default', array(array(0, ), )),), false),
	), $__compilerTemp3) . '</li>
				</ul>
			', array(
		'rowtype' => 'input',
		'label' => 'Location',
		'explain' => 'Select your car location...!',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_plaque_number',
		'value' => $__vars['car']['car_plaque_number'],
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
		'value' => $__vars['car']['car_reg_number'],
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
		'value' => ($__vars['car']['car_reg_date'] ? $__templater->func('date', array($__vars['car']['car_reg_date'], 'picker', ), false) : ''),
	)) . '

			', array(
		'rowtype' => 'input',
		'label' => 'Car Reg Date',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_forum_name',
		'value' => $__vars['car']['car_forum_name'],
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
		'value' => $__vars['car']['car_unique_information'],
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
		'submit' => 'save',
		'fa' => 'fa-save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('car-details/save', $__vars['car'], ), false),
		'class' => 'block',
		'ajax' => '1',
	));
	return $__finalCompiled;
}
);