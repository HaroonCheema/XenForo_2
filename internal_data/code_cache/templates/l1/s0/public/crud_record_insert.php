<?php
// FROM HASH: e948f3ec9fccc5be054b3ab9279ca0cb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['crud']['id']) {
		$__compilerTemp1 .= ' Edit Record ' . $__templater->escape($__vars['crud']['name']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit Record'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= ' Add new Record
		';
		$__templater->breadcrumb($__templater->preEscaped('Add Record'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'Crud/Upload.js',
	));
	$__templater->includeCss('fs_bunny_loader_style.less');
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . '' . '
			' . '' . '

			<span class="custom-file-upload">
				<label for="bunny_video" class="button button--link"><i class="fa fa-upload" aria-hidden="true" style="padding-right: 8px;"></i>' . 'Upload Video' . '</label>
				<input type="file" id="bunny_video" name="bunny_video" onchange="uploadFile()" accept=".mp4, .avi, .mov" style="display: none;" multiple/>
			</span>

			' . $__templater->formHiddenVal('bunnyVidId', '', array(
	)) . '

			<div id="overlay">
				<div class="loader" id="loader"></div>
			</div>
			' . $__templater->formTextBoxRow(array(
		'name' => 'name',
		'value' => $__vars['crud']['name'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Name',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'class',
		'value' => $__vars['crud']['class'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Class',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'rollNo',
		'value' => $__vars['crud']['rollNo'],
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Roll No',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'save',
		'fa' => 'fa-save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('crud/save', $__vars['crud'], ), false),
		'class' => 'block',
		'ajax' => '1',
	));
	return $__finalCompiled;
}
);