<?php
// FROM HASH: 81e4a124bb723aadb7d662aa0d491560
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['fieldTypes'][$__vars['field']['field_type']]['options'] === 'choice') OR (!$__vars['field']['field_id'])) {
		$__finalCompiled .= '
    ' . $__templater->formRadioRow(array(
			'name' => 'filter_template',
			'value' => $__vars['field']['FieldData']['filter_template'],
		), array(array(
			'value' => 'checkbox',
			'label' => 'Check boxes',
			'_type' => 'option',
		),
		array(
			'value' => 'multiselect',
			'label' => 'Multiple-choice drop down',
			'_type' => 'option',
		),
		array(
			'value' => 'select',
			'label' => 'Drop down selection',
			'_type' => 'option',
		),
		array(
			'value' => 'radio',
			'label' => 'Radio buttons',
			'_type' => 'option',
		)), array(
			'label' => 'Show in filter form as',
			'explain' => 'Choose what kind of form element should be used to allow users to filter/search threads by this field. ',
		)) . '

    ' . $__templater->formRadioRow(array(
			'name' => 'default_match_type',
			'value' => $__vars['field']['FieldData']['default_match_type'],
		), array(array(
			'value' => 'OR',
			'label' => 'Match any option',
			'_type' => 'option',
		),
		array(
			'value' => 'AND',
			'label' => 'Match all options',
			'_type' => 'option',
		)), array(
			'label' => 'Default match type',
			'explain' => 'For fields with multiple-choice options, users will get an additional selection field to choose, if they want to find results matching ALL their choices or ANY of the choices. This option controls which value should be selected by default for this field. Users can still change it in the filter form.',
		)) . '
';
	}
	return $__finalCompiled;
}
);