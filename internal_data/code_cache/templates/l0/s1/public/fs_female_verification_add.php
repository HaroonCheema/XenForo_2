<?php
// FROM HASH: f18e62ad8022745be47b5fc787ec9eb2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Get Verified');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formInfoRow('
				' . 'Please submit the necessary documents to get verified. The documents are securely stored and are never shown publicly. You will receive an alert regrading your verification status once staff reviews your data. <b>The total size for all images cannot exceed ' . $__templater->escape($__vars['xf']['options']['fs_female_verification_images_size']) . 'MB.If the size is larger than this you will receive an error message.</b>' . '
			', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'govImage',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
		'data-required' => 'true',
	), array(
		'label' => 'Upload your identity',
		'hint' => 'Required',
		'explain' => 'upload gov or stayed ID ex: drivers license or passport.',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'selfiImage',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
		'data-required' => 'true',
	), array(
		'label' => 'Upload a current selfie',
		'hint' => 'Required',
		'explain' => 'Upload selfi holding ID face has to match.',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'paperImage',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
		'data-required' => 'true',
	), array(
		'label' => 'Upload a paper',
		'hint' => 'Required',
		'explain' => 'Upload blank peace of paper 📄 with today date written and username.',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Submit verification',
		'icon' => 'upload',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('female-verify/add', ), false),
		'class' => 'block',
		'ajax' => 'true',
		'novalidate' => 'false',
	));
	return $__finalCompiled;
}
);