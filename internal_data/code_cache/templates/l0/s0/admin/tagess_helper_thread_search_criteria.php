<?php
// FROM HASH: 717749d7a6ceea4cb2eba1196dc067b0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formTokenInputRow(array(
		'name' => 'criteria[tags]',
		'value' => $__vars['criteria']['tags'],
		'href' => $__templater->func('link_type', array('public', 'misc/tag-auto-complete', ), false),
		'min-length' => $__vars['xf']['options']['tagLength']['min'],
		'max-length' => $__vars['xf']['options']['tagLength']['max'],
		'max-tokens' => $__vars['xf']['options']['maxContentTags'],
	), array(
		'label' => 'Search tags',
		'explain' => '
		' . 'Multiple tags may be separated by commas.' . '
	',
	));
	return $__finalCompiled;
}
);