<?php
// FROM HASH: 81cdb2936f59a7666fce11e4dcacd3ee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['videoitem']['video_id']) {
		$__compilerTemp1 .= ' ' . 'Edit video' . ' : ' . $__templater->escape($__vars['videoitem']['title']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit video'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add video' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add video'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '
';
	$__compilerTemp2 = '';
	if ($__vars['videoitem']['thumbnail'] AND $__vars['videoitem']['video_id']) {
		$__compilerTemp2 .= '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					<a href="' . $__templater->escape($__vars['videoitem']['thumbnail']) . '" target="_blank">
						<img src="' . $__templater->func('base_url', array($__vars['videoitem']['thumbnail'], ), true) . '" width="300" height="300" />
					</a>
				', array(
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['videoitem']['attachment_id'] AND $__vars['videoitem']['video_id']) {
		$__compilerTemp3 .= '

				<hr class="formRowSep" />

				' . $__templater->formRow('
					<a href="' . $__templater->escape($__vars['videoitem']['Attachment']['direct_url']) . '" target="_blank">
						<video data-xf-init="video-init" width="200" height="200">
							<source src="' . $__templater->escape($__vars['videoitem']['Attachment']['direct_url']) . '" />
						</video>
					</a>
				', array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['videoitem']['title'],
		'required' => 'required',
	), array(
		'label' => 'Title',
		'hint' => 'Required',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'type',
		'id' => 'key',
		'value' => ($__vars['videoitem']['video_id'] ? ($__vars['videoitem']['thumbnail'] ? '0' : '1') : '0'),
	), array(array(
		'value' => '0',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-navTypeForm--0',
		'data-hide' => 'true',
		'label' => 'Video URL',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'data-xf-init' => 'disabler',
		'data-container' => '.js-navTypeForm--1',
		'data-hide' => 'true',
		'label' => 'Upload video',
		'_type' => 'option',
	)), array(
		'label' => 'Type',
	)) . '

			<hr class="formRowSep" />

			<div class="js-navTypeForm js-navTypeForm--0">
				' . $__templater->formTextBoxRow(array(
		'name' => 'url',
		'value' => $__vars['videoitem']['url'],
		'placeholder' => 'https://www.youtube.com/',
		'required' => 'required',
	), array(
		'hint' => 'Required',
		'label' => 'Video URL',
	)) . ' 
			</div>

			<div class="js-navTypeForm js-navTypeForm--1">
				' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => 'video/*',
	), array(
		'label' => 'Upload video',
		'hint' => 'Required',
	)) . '
			</div>

			' . $__compilerTemp2 . '

			' . $__compilerTemp3 . '

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('yt-videos/save', $__vars['videoitem'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);