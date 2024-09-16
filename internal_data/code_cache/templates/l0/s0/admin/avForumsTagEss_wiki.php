<?php
// FROM HASH: eafbb936fa2a7d5df67986997fd6da30
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Wiki' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['tag']['tag']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'tagess_wiki_tagline',
		'value' => $__vars['tag']['tagess_wiki_tagline'],
		'maxlength' => $__templater->func('max_length', array($__vars['tag'], 'tagess_wiki_tagline', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Tagline',
	)) . '

			' . $__templater->formEditorRow(array(
		'name' => 'tagess_wiki_description',
		'value' => $__vars['tag']['tagess_wiki_description'],
	), array(
		'rowtype' => '',
		'label' => 'Description',
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('tags/wiki', $__vars['tag'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);