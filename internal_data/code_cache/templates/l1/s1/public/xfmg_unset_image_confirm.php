<?php
// FROM HASH: e60e76ec38eaf7c8b727ca0a8d8035ac
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
			' . 'Are you sure you want to unset this image from album cover?' . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('media/unset-image', $__vars['mediaItem'], ), false),
		'class' => 'block',
		'ajax' => 'true',
		'method' => 'post',
	));
	return $__finalCompiled;
}
);