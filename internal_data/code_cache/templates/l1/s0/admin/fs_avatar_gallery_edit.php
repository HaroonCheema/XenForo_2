<?php
// FROM HASH: f38f7355131ce0c3f0ddd1181d9eee99
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
		'name' => 'img_path[]',
		'accept' => '.jpeg,.jpg,.png',
		'multiple' => 'true',
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