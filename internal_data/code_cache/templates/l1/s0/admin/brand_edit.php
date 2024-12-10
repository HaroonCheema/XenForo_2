<?php
// FROM HASH: 3b277ebebf338c65a2ce724680927e5a
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
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Record:' . ' ' . $__templater->escape($__vars['data']['video_feature']));
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
	$__compilerTemp1 = '';
	if ($__vars['data']['video_logo']) {
		$__compilerTemp1 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_logo',
			'accept' => '.jpeg,.jpg,.png',
		), array(
			'label' => 'Brand Logo',
		)) . '
				' . $__templater->formInfoRow('
					<img src="' . $__templater->escape($__vars['data']['video_logo']) . '" value="' . $__templater->escape($__vars['data']['video_logo']) . '" alt="logo image" width="250" height="300"/>
				', array(
			'rowtype' => 'confirm',
		)) . '
			';
	} else {
		$__compilerTemp1 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_logo',
			'accept' => '.jpeg,.jpg,.png',
			'required' => 'true',
		), array(
			'label' => 'Brand Logo',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['data']['video_sideimg']) {
		$__compilerTemp2 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_sideimg',
			'accept' => '.jpeg,.jpg,.png',
		), array(
			'label' => 'Brand Side Image',
		)) . '
				' . $__templater->formInfoRow('
					<img src="' . $__templater->escape($__vars['data']['video_sideimg']) . '"  alt="side image" width="250" height="300"/>
				', array(
			'rowtype' => 'confirm',
		)) . '
			   ';
	} else {
		$__compilerTemp2 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_sideimg',
			'accept' => '.jpeg,.jpg,.png',
			'required' => 'true',
		), array(
			'label' => 'Brand Side Image',
		)) . '
			    ';
	}
	$__compilerTemp3 = '';
	if ($__vars['data']['video_img']) {
		$__compilerTemp3 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_img',
			'accept' => '.jpeg,.jpg,.png',
		), array(
			'label' => ' Main Image',
		)) . '
				' . $__templater->formInfoRow('
					<img src="' . $__templater->escape($__vars['data']['video_img']) . '"  alt="image" width="250" height="300"/>
				', array(
			'rowtype' => 'confirm',
		)) . '
			    ';
	} else {
		$__compilerTemp3 .= '
				' . $__templater->formUploadRow(array(
			'name' => 'video_img',
			'accept' => '.jpeg,.jpg,.png',
			'required' => 'true',
		), array(
			'label' => ' Main Image',
		)) . '
			    ';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			
            ' . $__templater->formTextBoxRow(array(
		'name' => 'video_feature',
		'value' => $__vars['data']['video_feature'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_feature', ), false),
	), array(
		'label' => 'Link Name',
	)) . '
						 
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'video_link',
		'type' => 'url',
		'value' => $__vars['data']['video_link'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_link', ), false),
	), array(
		'label' => ' Feature Video',
	)) . '
			
			' . $__compilerTemp1 . '
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'video_intro',
		'value' => $__vars['p_intro'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_intro', ), false),
	), array(
		'label' => 'Intro',
	)) . '
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'video_desc',
		'value' => $__vars['p_desc'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_desc', ), false),
	), array(
		'label' => 'Description',
	)) . '
			
						' . $__compilerTemp2 . '
			
				' . $__compilerTemp3 . '
	

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
	</div>
', array(
		'action' => $__templater->func('link', array('brand/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);