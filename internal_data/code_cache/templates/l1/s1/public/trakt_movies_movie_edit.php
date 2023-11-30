<?php
// FROM HASH: 8293d59275541bd9c4294a4c2b3cec1e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('trakt_movies_edit_movie');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['movie']['comment']) {
		$__compilerTemp1 .= '
				' . $__templater->formEditorRow(array(
			'name' => 'message',
			'value' => $__vars['movie']['comment'],
			'attachments' => $__vars['attachmentData']['attachments'],
			'data-min-height' => '100',
			'maxlength' => $__vars['xf']['options']['messageMaxLength'],
		), array(
			'label' => 'Comment',
		)) . '

				';
		$__compilerTemp2 = '';
		if ($__vars['attachmentData']) {
			$__compilerTemp2 .= '
						' . $__templater->callMacro('helper_attach_upload', 'upload_block', array(
				'attachmentData' => $__vars['attachmentData'],
			), $__vars) . '
					';
		}
		$__compilerTemp1 .= $__templater->formRow('
					' . $__compilerTemp2 . '
					' . $__templater->button('', array(
			'class' => 'button--link u-jsOnly',
			'data-xf-click' => 'preview-click',
			'icon' => 'preview',
		), '', array(
		)) . '
				', array(
			'rowtype' => ($__vars['quickEdit'] ? 'fullWidth noLabel' : ''),
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if ($__vars['quickEdit']) {
		$__compilerTemp3 .= '
					' . $__templater->button('Cancel', array(
			'class' => 'js-cancelButton',
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_title',
		'value' => $__vars['movie']['trakt_title'],
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_tagline',
		'value' => $__vars['movie']['trakt_tagline'],
	), array(
		'label' => 'trakt_movies_tagline',
	)) . '
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_genres',
		'value' => $__vars['movie']['trakt_genres'],
	), array(
		'label' => 'trakt_movies_genre',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'trakt_director',
		'value' => $__vars['movie']['trakt_director'],
		'autosize' => 'true',
	), array(
		'label' => 'trakt_movies_director',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'trakt_cast',
		'value' => $__vars['movie']['trakt_cast'],
		'autosize' => 'true',
	), array(
		'label' => 'trakt_movies_cast',
	)) . '
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_status',
		'value' => $__vars['movie']['trakt_status'],
	), array(
		'label' => 'trakt_movies_status',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_release',
		'value' => $__vars['movie']['trakt_release'],
	), array(
		'label' => 'trakt_movies_release',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_runtime',
		'value' => $__vars['movie']['trakt_runtime'],
	), array(
		'label' => 'trakt_movies_runtime',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'trakt_plot',
		'value' => $__vars['movie']['trakt_plot'],
		'autosize' => 'true',
	), array(
		'label' => 'trakt_movies_plot',
	)) . '
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'trakt_trailer',
		'value' => $__vars['movie']['trakt_trailer'],
	), array(
		'label' => 'trakt_movies_trailer',
		'explain' => 'trakt_movies_trailer_explain',
	)) . '

			' . $__compilerTemp1 . '
	
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
		'rowtype' => ($__vars['quickEdit'] ? 'simple' : ''),
		'html' => '
				' . $__compilerTemp3 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('movies/edit', $__vars['movie'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'attachment-manager' . (($__templater->method($__vars['post'], 'isFirstPost', array()) AND $__templater->method($__vars['thread'], 'canEdit', array())) ? ' post-edit' : ''),
		'data-preview-url' => $__templater->func('link', array('posts/preview', $__vars['post'], ), false),
	));
	return $__finalCompiled;
}
);