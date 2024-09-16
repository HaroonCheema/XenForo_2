<?php
// FROM HASH: aef844e708a2e91c70c6583942683a91
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'actions[auto_tag_from_title]',
		'label' => 'Auto-tag threads',
		'_type' => 'option',
	)), array(
		'explain' => 'Applies tags which match fragments of the thread title',
	)) . '

' . $__templater->formTokenInputRow(array(
		'name' => 'actions[add_tags]',
		'href' => $__templater->func('link_type', array('public', 'misc/tag-auto-complete', ), false),
		'min-length' => $__vars['xf']['options']['tagLength']['min'],
		'max-length' => $__vars['xf']['options']['tagLength']['max'],
		'max-tokens' => $__vars['xf']['options']['maxContentTags'],
	), array(
		'label' => 'Tags to add',
		'explain' => '
        ' . 'Multiple tags may be separated by commas.' . '
    ',
	)) . '

' . $__templater->formTokenInputRow(array(
		'name' => 'actions[remove_tags]',
		'href' => $__templater->func('link_type', array('public', 'misc/tag-auto-complete', ), false),
		'min-length' => $__vars['xf']['options']['tagLength']['min'],
		'max-length' => $__vars['xf']['options']['tagLength']['max'],
		'max-tokens' => $__vars['xf']['options']['maxContentTags'],
	), array(
		'label' => 'Tags to remove',
		'explain' => '
        ' . 'Multiple tags may be separated by commas.' . '
    ',
	)) . '

<hr class="formRowSep" />';
	return $__finalCompiled;
}
);