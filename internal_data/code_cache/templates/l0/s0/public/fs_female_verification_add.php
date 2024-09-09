<?php
// FROM HASH: 21236240ccd7c2be43e9e1df9720fd16
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

			' . $__templater->formRadioRow(array(
		'name' => 'female_identity_type',
	), array(array(
		'value' => 'images',
		'selected' => true,
		'label' => 'Upload images',
		'data-xf-init' => 'disabler',
		'data-container' => '.identity-images',
		'data-hide' => 'yes',
		'_type' => 'option',
	),
	array(
		'value' => 'boxes',
		'label' => 'P411',
		'data-xf-init' => 'disabler',
		'data-container' => '.identity-boxes',
		'data-hide' => 'yes',
		'_type' => 'option',
	)), array(
		'label' => 'Verification type',
	)) . '

			<div class="identity-images">

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

			<div class="identity-boxes">

				' . $__templater->formTextBoxRow(array(
		'name' => 'boxOne',
		'required' => 'required',
	), array(
		'hint' => 'Required',
		'explain' => 'Enter your name, phone or email here...!',
		'label' => 'Name, phone or email',
	)) . '

				' . $__templater->formTextBoxRow(array(
		'name' => 'boxTwo',
		'required' => 'required',
	), array(
		'hint' => 'Required',
		'explain' => 'Enter your handle or website name here...!',
		'label' => 'Handle or site name',
	)) . '

			</div>

		</div>
		
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'upload',
		'submit' => 'Submit verification',
	), array(
		'html' => '
				' . $__templater->button('Cancel', array(
		'href' => $__templater->func('link', array('members', $__vars['xf']['visitor'], ), false),
		'icon' => 'cancel',
		'name' => 'exit',
	), '', array(
	)) . '
				<input type="hidden" name="_page" value="' . $__templater->escape($__vars['_page']) . '" />
			',
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