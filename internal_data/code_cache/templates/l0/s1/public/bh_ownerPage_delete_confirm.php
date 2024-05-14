<?php
// FROM HASH: b63690fca2e471db6d65e132923f4ff7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xf/thread.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['contentUrl']) {
		$__compilerTemp1 .= '
					<strong><a href="' . $__templater->escape($__vars['contentUrl']) . '">' . $__templater->escape($__vars['contentTitle']) . '</a></strong>
				';
	} else {
		$__compilerTemp1 .= '
					<strong>' . $__templater->escape($__vars['contentTitle']) . '</strong>
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['deletionImportantPhrase']) {
		$__compilerTemp2 .= '
					<div class="blockMessage blockMessage--important blockMessage--iconic">
						' . $__templater->func('phrase_dynamic', array($__vars['deletionImportantPhrase'], ), true) . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				' . $__compilerTemp1 . '
				' . $__compilerTemp2 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__vars['confirmUrl'],
		'ajax' => 'true',
		'class' => 'block',
		'data-xf-init' => 'thread-edit-form',
		'data-item-selector' => '.js-itemPage-' . $__vars['item']['item_id'] . '-' . $__vars['page']->{'page_id'},
	));
	return $__finalCompiled;
}
);