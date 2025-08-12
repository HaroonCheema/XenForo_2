<?php
// FROM HASH: e24e63b77ff4d9c22ac9f0e1dc0328c9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['id']) {
		$__compilerTemp1 .= ' ' . 'Edit icon' . ' ';
	} else {
		$__compilerTemp1 .= ' ' . 'Add icon' . ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '
';
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['data'], 'getImgUrl', array()) AND $__vars['data']['id']) {
		$__compilerTemp2 .= '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					<img src="' . $__templater->func('base_url', array($__templater->method($__vars['data'], 'getImgUrl', array()), ), true) . '" />
				', array(
			'label' => 'Selected icon',
		)) . '

			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'fs_icon_url',
		'value' => $__vars['data']['fs_icon_url'],
		'autosize' => 'true',
		'required' => 'required',
		'row' => '5',
	), array(
		'label' => 'Icon url',
		'hint' => 'Required',
	)) . '

			' . $__templater->formUploadRow(array(
		'name' => 'image',
		'accept' => '.jpeg,.jpg,.jpe,.png,.svg',
		'required' => ($__vars['data']['id'] ? '' : 'required'),
	), array(
		'label' => 'Icon',
		'hint' => ($__vars['data']['id'] ? '' : 'Required'),
		'explain' => 'Add icon from here.',
	)) . '

			' . $__compilerTemp2 . '

			<hr class="formRowSep" />

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'enabled',
		'selected' => $__vars['data']['enabled'],
		'label' => 'Enabled',
		'_type' => 'option',
	)), array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('nav-icon/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);