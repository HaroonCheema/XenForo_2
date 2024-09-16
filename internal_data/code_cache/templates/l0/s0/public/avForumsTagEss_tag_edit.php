<?php
// FROM HASH: 23d7540cbce27d462734555043d542c8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit tag' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['tag']['tag']));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['tag'], 'canEditWiki', array())) {
		$__compilerTemp1 .= '
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
			';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['tag'], 'canEditCategory', array())) {
		$__compilerTemp2 .= '
				';
		$__compilerTemp3 = array(array(
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		));
		$__compilerTemp3 = $__templater->mergeChoiceOptions($__compilerTemp3, $__vars['categories']);
		$__compilerTemp2 .= $__templater->formSelectRow(array(
			'name' => 'tagess_category_id',
			'value' => $__vars['tag']['tagess_category_id'],
		), $__compilerTemp3, array(
			'label' => 'Tag category',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			
			' . $__compilerTemp2 . '
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('tags/save', $__vars['tag'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);