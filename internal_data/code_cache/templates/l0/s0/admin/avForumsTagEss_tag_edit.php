<?php
// FROM HASH: c57a080d2c35c0365d881576c60932af
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['categories']);
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'tagess_category_id',
		'value' => $__vars['tag']['tagess_category_id'],
	), $__compilerTemp1, array(
		'label' => 'Tag category',
	)) . '

' . $__templater->formCheckBoxRow(array(
		'name' => 'apply_node_ids',
	), array(array(
		'label' => 'Restrict addition of tag to threads in these forums' . $__vars['xf']['language']['label_separator'],
		'checked' => ($__vars['tag']['allowed_node_ids'] ? '1' : ''),
		'_dependent' => array('
			' . $__templater->callMacro('forum_selection_macros', 'select_forums', array(
		'nodeIds' => $__vars['tag']['allowed_node_ids'],
		'nodeTree' => $__vars['nodeTree'],
		'selectName' => 'allowed_node_ids',
		'withRow' => '0',
	), $__vars) . '
		'),
		'_type' => 'option',
	)), array(
	)) . '

';
	if ($__vars['tag']['SynonymOf']) {
		$__finalCompiled .= '
	' . $__templater->formRow('
		<a href="' . $__templater->func('link', array('tags/edit', $__vars['tag']['SynonymOf']['ParentTag'], ), true) . '">' . $__templater->escape($__vars['tag']['SynonymOf']['ParentTag']['tag']) . '</a>
	', array(
			'label' => 'Canonical tag',
		)) . '
';
	} else {
		$__finalCompiled .= '	
	' . $__templater->formTokenInputRow(array(
			'name' => 'synonyms',
			'value' => $__vars['tag']['SynonymsForInput'],
			'href' => $__templater->func('link_type', array('public', 'misc/synonym-auto-complete', null, array('tag' => $__vars['tag']['tag_id'], ), ), false),
		), array(
			'label' => 'Synonyms',
			'explain' => 'Multiple tags may be separated by commas.',
		)) . '
';
	}
	return $__finalCompiled;
}
);