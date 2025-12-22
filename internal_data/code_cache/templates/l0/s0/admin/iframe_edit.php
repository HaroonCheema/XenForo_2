<?php
// FROM HASH: 91ca58068dc47796369473a97b16c5e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['data'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Record');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Record:' . ' ' . $__templater->escape($__vars['data']['iframe_title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['data'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('brand/delete', $__vars['data'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '
';
	$__compilerTemp1 = array(array(
		'value' => $__vars['sponsor']['video_feature'],
		'selected' => true,
		'label' => $__templater->escape($__vars['sponsor']['video_feature']),
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
		'label' => 'Iframe URL',
	)) . '
	
			' . $__templater->formSelectRow(array(
		'name' => 'video_id',
		'value' => $__vars['data']['video_id'],
		'class' => '',
	), $__compilerTemp1, array(
		'label' => 'Brand Title',
		'explain' => 'Select one from Brand Title or Rons Interview ',
	)) . '
			
			' . $__templater->formSelectRow(array(
		'name' => 'display_day',
		'value' => $__vars['data']['display_day'],
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
          	 
				' . $__templater->formUploadRow(array(
		'name' => 'video_thumbnail',
		'accept' => '.jpeg,.jpg,.png',
	), array(
		'label' => 'Thumbnail',
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