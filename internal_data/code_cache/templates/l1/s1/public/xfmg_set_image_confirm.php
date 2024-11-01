<?php
// FROM HASH: c2de3f1c258bd492520d6e646aa78073
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['mediaItem'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="formInfoRow formInfoRow--confirm">
			' . 'Are you sure you want to set this image as album cover?' . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('media/saving-image', $__vars['mediaItem'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'method' => 'post',
	));
	return $__finalCompiled;
}
);