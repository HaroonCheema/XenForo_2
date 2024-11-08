<?php
// FROM HASH: f1215adfb972c8b07ae9554f182f5b41
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['id']) {
		$__compilerTemp1 .= ' ' . 'Edit logo' . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit logo'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add logo' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add logo'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '
';
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['data'], 'getImgUrl', array()) AND $__vars['data']['id']) {
		$__compilerTemp2 .= '
				' . $__templater->formRow('
					<img src="' . $__templater->func('base_url', array($__templater->method($__vars['data'], 'getImgUrl', array()), ), true) . '" />
				', array(
			'label' => 'Selected logo',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'logo_url',
		'value' => $__vars['data']['logo_url'],
		'autosize' => 'true',
		'required' => 'required',
		'row' => '5',
	), array(
		'label' => 'Logo url',
		'hint' => 'Required',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'image',
		'accept' => '.jpeg,.jpg,.jpe,.png',
		'required' => ($__vars['data']['id'] ? '' : 'required'),
	), array(
		'label' => 'Select logo',
		'hint' => ($__vars['data']['id'] ? '' : 'Required'),
		'explain' => 'Select logo from here...!',
	)) . '

			' . $__compilerTemp2 . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('logo-slider/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);