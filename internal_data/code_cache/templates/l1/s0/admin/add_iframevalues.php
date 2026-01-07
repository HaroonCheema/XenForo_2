<?php
// FROM HASH: 035be984b6874737feb9bded498e5478
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Iframe Videos');
	$__finalCompiled .= '
';
	$__compilerTemp1 = array(array(
		'value' => '',
		'selected' => true,
		'label' => 'Brand Title',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['iframeSites'])) {
		foreach ($__vars['iframeSites'] AS $__vars['sponsor']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['sponsor']['video_id'],
				'label' => $__templater->escape($__vars['sponsor']['video_feature']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'iframe_title',
		'value' => $__vars['data']['iframe_title'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'iframe_title', ), false),
	), array(
		'label' => 'Iframe Title',
	)) . '
			
            ' . $__templater->formTextBoxRow(array(
		'name' => 'iframe_URL',
		'type' => 'url',
		'value' => $__vars['data']['iframe_URL'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'iframe_URL', ), false),
	), array(
		'label' => 'Iframe Link',
	)) . '
	       
			' . $__templater->formSelectRow(array(
		'name' => 'video_id',
		'value' => ($__vars['data']['video_link'] ? $__vars['data']['video_link'] : 0),
		'class' => '',
	), $__compilerTemp1, array(
		'label' => 'Brand Title',
		'explain' => 'Select one from Brand Title or Rons Interview ',
	)) . '
			
			' . $__templater->formRadioRow(array(
		'name' => 'display_day',
		'value' => '7',
	), array(array(
		'value' => '7',
		'label' => 'Unknown',
		'_type' => 'option',
	),
	array(
		'value' => '0',
		'label' => 'Sunday',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'Monday',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'Tuesday',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'Wednesday',
		'_type' => 'option',
	),
	array(
		'value' => '4',
		'label' => 'Thursday',
		'_type' => 'option',
	),
	array(
		'value' => '5',
		'label' => 'Friday',
		'_type' => 'option',
	),
	array(
		'value' => '6',
		'label' => 'Saturday',
		'_type' => 'option',
	)), array(
		'label' => 'Display Day',
		'explain' => 'Select which day this video should display',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'for_days',
		'value' => $__vars['data']['for_days'],
		'min' => '1',
		'max' => '7',
		'step' => '1',
	), array(
		'label' => 'For days',
		'explain' => 'From here you can set more days for the same video...!',
	)) . '
			
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'rons',
		'value' => '1',
		'selected' => $__vars['data']['rons'],
		'label' => 'Rons Interview',
		'data-hide' => 'true',
		'_dependent' => array('
			' . $__templater->formCheckBox(array(
	), array(array(
		'name' => 'rons_featured',
		'value' => '1',
		'selected' => $__vars['data']['rons_featured'],
		'label' => 'Rons Featured',
		'_type' => 'option',
	))) . '
					
					
				'),
		'_type' => 'option',
	)), array(
	)) . '
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'feature',
		'value' => '1',
		'selected' => $__vars['data']['feature'],
		'label' => 'Feature Video',
		'_type' => 'option',
	)), array(
	)) . '
			</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('iframe/save', $__vars['data'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);