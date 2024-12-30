<?php
// FROM HASH: 9d89af5265b5885783ea5179844df27c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('', array(
		'rowtype' => 'fullWidth noLabel',
		'explain' => 'A user must meet the criteria set here to view and fill out this form (including admins)',
	)) . '

<div class="block-body">

	' . '

	' . $__templater->formRow('
		<div class="inputGroup">
			<div class="inputGroup inputGroup--numbers inputNumber" data-xf-init="number-box">
				' . $__templater->formTextBox(array(
		'name' => 'formlimit',
		'value' => (($__vars['form']['formlimit'] >= 1) ? $__vars['form']['formlimit'] : 0),
		'type' => 'number',
		'min' => '0',
		'class' => 'input input--number js-numberBoxTextInput js-permissionIntInput',
	)) . '
			</div>
		</div>
	', array(
		'label' => 'Form use limit',
		'explain' => 'Select the number of times a user may fill out this form. Zero = unlimited<br /><font style="color:blue;"><b>NOTE:</b></font> This DOES NOT work with Unregistered users.',
		'rowtype' => 'input',
	)) . '
	
	' . '

	' . $__templater->filter($__vars['userCriteriaRendered'], array(array('raw', array()),), true) . '
</div>';
	return $__finalCompiled;
}
);