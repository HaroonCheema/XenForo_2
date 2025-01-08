<?php
// FROM HASH: 873fa443005c86789527b5410dabaf41
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(' ' . 'Car details' . ' ');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
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
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('

				<ul class="inputList">
					<li>' . $__templater->formSelect(array(
		'name' => 'model_id',
		'value' => $__templater->filter($__vars['user']['model_id'], array(array('default', array(array(0, ), )),), false),
		'required' => 'required',
	), $__compilerTemp1) . '</li>
				</ul>
			', array(
		'rowtype' => 'input',
		'hint' => 'Required',
		'label' => 'Model',
		'explain' => 'Select your car model...!',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_colour',
		'value' => $__vars['user']['car_colour'],
		'required' => 'true',
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car colour here..!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Colour',
		'hint' => 'Required',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_trim',
		'value' => $__vars['user']['car_trim'],
		'required' => 'true',
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car trim  here...!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Trim',
		'hint' => 'Required',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_location',
		'value' => $__vars['user']['car_location'],
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your location here...!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Location',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_plaque_number',
		'value' => $__vars['user']['car_plaque_number'],
		'required' => 'true',
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car plaque number here...!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Plaque Number',
		'hint' => 'Required',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_reg_number',
		'value' => $__vars['user']['car_reg_number'],
		'required' => 'true',
	), array(
		'rowtype' => 'fullWidth',
		'explain' => 'Enter your car reg number here...!',
	)) . '
			', array(
		'rowtype' => 'input',
		'label' => 'Reg Number',
		'hint' => 'Required',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formDateInput(array(
		'name' => 'car_reg_date',
		'value' => ($__vars['user']['car_reg_date'] ? $__templater->func('date', array($__vars['user']['car_reg_date'], 'picker', ), false) : ''),
	)) . '

			', array(
		'rowtype' => 'input',
		'label' => 'Car Reg Date',
	)) . '

			' . $__templater->formRow('
				' . $__templater->formTextBoxRow(array(
		'name' => 'car_forum_name',
		'value' => $__vars['user']['car_forum_name'],
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
		'value' => $__vars['user']['car_unique_information'],
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
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('car-details/save', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);