<?php
// FROM HASH: 97072065d9cce64cd5e3393674cfdf62
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit media item');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['mediaItem'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '
';
	$__templater->includeCss('ts_mgm_additional.less');
	$__finalCompiled .= '
' . $__templater->includeTemplate('ts_mgm_additional.js', $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__vars['mediaItem']['media_type'] == 'embed') {
		$__compilerTemp1 .= '
				' . $__templater->formTextBoxRow(array(
			'name' => 'media_embed_url',
			'value' => $__vars['mediaItem']['media_embed_url'],
			'type' => 'url',
		), array(
			'label' => 'Enter media URL',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= '
					' . $__templater->callMacro('custom_fields_macros', 'custom_fields_edit', array(
		'type' => 'xfmgMediaFields',
		'set' => $__vars['mediaItem']['custom_fields'],
		'editMode' => $__templater->method($__vars['mediaItem'], 'getFieldEditMode', array()),
		'onlyInclude' => ($__vars['mediaItem']['category_id'] ? $__vars['mediaItem']['Category']['field_cache'] : $__vars['mediaItem']['Album']['field_cache']),
	), $__vars) . '
				';
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
				<hr class="formRowSep" />

				' . $__compilerTemp3 . '
			';
	}
	$__compilerTemp4 = '';
	if ($__templater->method($__vars['mediaItem'], 'canSendModeratorActionAlert', array())) {
		$__compilerTemp4 .= '
				<hr class="formRowSep" />

				' . $__templater->callMacro('helper_action', 'author_alert', array(), $__vars) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['mediaItem']['title_'],
		'maxlength' => $__templater->func('max_length', array($__vars['mediaItem'], 'title', ), false),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formEditorRow(array(
		'name' => 'description',
		'value' => $__vars['mediaItem']['description_'],
		'maxlength' => $__templater->func('max_length', array($__vars['mediaItem'], 'description', ), false),
		'removebuttons' => $__vars['disabledButtons'],
	), array(
		'label' => 'Description',
	)) . '

			' . $__compilerTemp1 . '

			' . $__compilerTemp2 . '

			' . $__compilerTemp4 . '
' . $__templater->callMacro('ts_mgm_additional_checkboxes', 'addCheckboxes2', array(
		'additional' => $__vars['additional'],
		'namePrefix' => $__vars['namePrefix'],
		'mediaItemAdditionals' => $__templater->method($__vars['mediaItem'], 'getAdditionalCategories', array()),
	), $__vars) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('media/edit', $__vars['mediaItem'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);