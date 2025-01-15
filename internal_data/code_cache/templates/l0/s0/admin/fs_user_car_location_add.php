<?php
// FROM HASH: cdb0d8c465d54e37df1842b14444f9c8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['location']['location_id']) {
		$__compilerTemp1 .= ' ' . 'Edit location' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Edit location'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= ' ' . 'Add location' . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Add location'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'location',
		'value' => $__vars['location']['location'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Location',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'save',
		'fa' => 'fa-save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('car-location/save', $__vars['location'], ), false),
		'class' => 'block',
		'ajax' => '1',
	));
	return $__finalCompiled;
}
);