<?php
// FROM HASH: 1e86c07ba472d4c4dc5aef55e3b3f962
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add avatar');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->formUploadRow(array(
		'name' => 'img_path',
		'accept' => '.jpeg,.jpg,.png',
		'required' => 'true',
	), array(
		'label' => 'Avatar',
		'explain' => 'Upload image for avatar gallery.',
	)) . '

		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ag/save', $__vars['avatar'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);