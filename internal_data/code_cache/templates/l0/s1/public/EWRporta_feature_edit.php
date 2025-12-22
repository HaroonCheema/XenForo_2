<?php
// FROM HASH: 29aad2a6e39194e8ed4a7d161f0316e7
return array(
'macros' => array('edit_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'feature' => '!',
		'thread' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-body" data-xf-init="porta-upload">
		' . $__templater->formUploadRow(array(
		'name' => 'upload',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Image',
		'explain' => 'It is recommended that you use an image that is at least ' . $__templater->escape($__vars['xf']['options']['EWRporta_feature_dimensions']['width']) . 'x' . $__templater->escape($__vars['xf']['options']['EWRporta_feature_dimensions']['height']) . ' pixels.',
	)) . '

		';
	if ($__vars['feature']['image']) {
		$__finalCompiled .= '
			' . $__templater->formRow('
				<img src="' . $__templater->func('base_url', array($__vars['feature']['image'], ), true) . '" />
			', array(
			'rowtype' => 'fullWidth noLabel',
		)) . '
		';
	}
	$__finalCompiled .= '

		' . $__templater->formTextBoxRow(array(
		'name' => 'feature[feature_media]',
		'value' => $__vars['feature']['feature_media'],
	), array(
		'label' => 'Media',
		'explain' => 'Embed a YouTube video directly into the fold by adding the <b>VIDEO ID</b> here.',
	)) . '

		' . $__templater->formRow('
			<div class="inputGroup">
				' . $__templater->formDateInput(array(
		'name' => 'date',
		'value' => $__templater->func('date', array(($__vars['feature'] ? $__vars['feature']['feature_date'] : $__vars['thread']['post_date']), 'picker', ), false),
	)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
		'type' => 'time',
		'name' => 'time',
		'value' => $__templater->func('date', array(($__vars['feature'] ? $__vars['feature']['feature_date'] : $__vars['thread']['post_date']), 'H:i', ), false),
	)) . '
			</div>
		', array(
		'label' => 'Date',
		'rowtype' => 'input',
	)) . '
	</div>

	<h2 class="block-formSectionHeader">
		<span class="collapseTrigger collapseTrigger--block' . ($__vars['feature']['feature_title'] ? ' is-active' : '') . '"
				data-xf-click="toggle" data-target="< :up :next">
			<span class="block-formSectionHeader-aligner">' . 'Excerpt' . '</span>
		</span>
	</h2>
	<div class="block-body block-body--collapsible' . ($__vars['feature']['feature_title'] ? ' is-active' : '') . '">
		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'custom_excerpt',
		'value' => '1',
		'checked' => ($__vars['feature']['feature_title'] ? true : false),
		'data-xf-init' => 'disabler',
		'data-container' => '#Excerpt',
		'data-hide' => 'false',
		'label' => 'Use custom title and excerpt',
		'_type' => 'option',
	)), array(
	)) . '

		<div id="Excerpt">
			' . $__templater->formTextBoxRow(array(
		'name' => 'feature[feature_title]',
		'maxlength' => $__templater->func('max_length', array('XF:Thread', 'title', ), false),
		'value' => ($__vars['feature']['feature_title'] ?: $__vars['thread']['title']),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'feature[feature_excerpt]',
		'rows' => '6',
		'autosize' => 'true',
		'maxlength' => $__vars['xf']['options']['messageMaxLength'],
		'placeholder' => $__vars['thread']['FirstPost']['message'],
		'value' => ($__vars['feature']['feature_excerpt'] ?: ($__vars['xf']['options']['EWRporta_articles_prefill'] ? $__vars['thread']['FirstPost']['message'] : '')),
	), array(
		'label' => 'Message',
	)) . '
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['feature']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Promote to feature');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit feature promotion');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => '8wayrun/porta/portal.js',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['feature'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('EWRporta', 'modFeatures', ))) {
		$__compilerTemp1 .= '
					' . $__templater->button('Delete' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('threads/feature/delete', $__vars['thread'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		
		' . $__templater->callMacro(null, 'edit_block', array(
		'feature' => $__vars['feature'],
		'thread' => $__vars['thread'],
	), $__vars) . '

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
		'html' => '
				' . $__compilerTemp1 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('threads/feature-edit', $__vars['thread'], ), false) . ') }}',
		'class' => 'block',
		'upload' => 'true',
		'ajax' => 'true',
	)) . '




';
	return $__finalCompiled;
}
);