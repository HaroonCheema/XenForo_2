<?php
// FROM HASH: 5c5b4349674aa30fae1572c06769dc8b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Brand Video');
	$__finalCompiled .= '
' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			
            ' . $__templater->formTextBoxRow(array(
		'name' => 'video_feature',
		'value' => $__vars['data']['video_feature'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_feature', ), false),
	), array(
		'label' => ' Link Name',
	)) . '
						   
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'video_link',
		'type' => 'url',
		'value' => $__vars['data']['video_link'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_link', ), false),
	), array(
		'label' => ' Feature Video',
	)) . '
			
			 			
			' . $__templater->formUploadRow(array(
		'name' => 'video_logo',
		'accept' => '.jpeg,.jpg,.png',
		'value' => $__vars['data']['video_logo'],
	), array(
		'label' => 'Logo',
		'explain' => 'Upload Brand Logo',
	)) . '
			
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'video_intro',
		'value' => $__vars['data']['video_intro'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_intro', ), false),
	), array(
		'label' => 'Intro',
	)) . '
			
			' . $__templater->formTextAreaRow(array(
		'name' => 'video_desc',
		'value' => $__vars['data']['video_desc'],
		'maxlength' => $__templater->func('max_length', array($__vars['data'], 'video_desc', ), false),
	), array(
		'label' => 'Description',
	)) . '
			
			' . $__templater->formUploadRow(array(
		'name' => 'video_sideimg',
		'accept' => '.jpeg,.jpg,.png',
		'value' => $__vars['data']['video_sideimg'],
	), array(
		'label' => 'Side Image',
		'explain' => 'Upload Brand Side Image',
	)) . '
			
			' . $__templater->formUploadRow(array(
		'name' => 'video_img',
		'accept' => '.jpeg,.jpg,.png',
		'value' => $__vars['data']['video_img'],
	), array(
		'label' => 'Main Image',
		'explain' => 'Upload Main Image',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('brand/save', $__vars['data'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);