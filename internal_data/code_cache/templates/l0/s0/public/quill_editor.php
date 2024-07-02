<?php
// FROM HASH: a7e1eb9c31b16946979148a9dd697704
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('quill_editor.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'bs/quill_editor/vendor/quill.1.3.7-modified.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'bs/quill_editor/vendor/quill.imageUploader.1.3.0.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'bs/quill_editor/editor.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'bs/quill_editor/matchers.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	if ($__templater->func('in_array', array('smilie', $__vars['formats'], ), false)) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'bs/quill_editor/smilie-embed.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('in_array', array('blockquote', $__vars['formats'], ), false)) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'bs/quill_editor/quotes.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
';
	if ($__templater->func('in_array', array('mention', $__vars['formats'], ), false)) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'bs/quill_editor/vendor/quill.mention.4.0.0.min.js',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'bs/quill_editor/mentions.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

<div class="js-quillEditorContainer quill-editor-container ' . $__templater->escape($__vars['containerClasses']) . '" ' . $__templater->filter($__vars['containerAttrsHtml'], array(array('raw', array()),), true) . '>
	' . $__templater->filter($__vars['prepend'], array(array('raw', array()),), true) . '

	<div class="quill-wrapper">
		<div class="ql-buttons ql-buttons--left">
			' . $__templater->filter($__vars['leftButtons'], array(array('raw', array()),), true) . '
		</div>

		<div class="quill-editor-wrapper">
			<div class="js-quillEditor quill-editor ' . $__templater->escape($__vars['classes']) . '" 
				 data-xf-init="' . $__templater->escape($__vars['preInit']) . ' quill-editor ' . $__templater->escape($__vars['init']) . '" 
				 data-toolbar="' . $__templater->filter($__vars['toolbar'], array(array('json', array()),), true) . '"
				 data-formats="' . $__templater->filter($__vars['formats'], array(array('json', array()),), true) . '"
				 data-active="' . ($__vars['active'] ? 'true' : 'false') . '"
				 data-submit-by-enter="' . ($__vars['submitByEnter'] ? 'true' : 'false') . '"
				 data-placeholder="' . $__templater->escape($__vars['placeholder']) . '"
				 data-name="' . $__templater->escape($__vars['name']) . '"
				 ' . $__templater->filter($__vars['attrsHtml'], array(array('raw', array()),), true) . '
			>
				' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '
			</div>
		</div>

		<div class="ql-buttons ql-buttons--right">
			' . $__templater->filter($__vars['rightButtons'], array(array('raw', array()),), true) . '
		</div>
	</div>
	
	' . $__templater->escape($__vars['append']) . '
</div>';
	return $__finalCompiled;
}
);