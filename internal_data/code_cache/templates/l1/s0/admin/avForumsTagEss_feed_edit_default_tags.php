<?php
// FROM HASH: c8e96830cb147b9d5c47da98587d4edb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTokenInputRow(array(
		'name' => 'tagess_tags',
		'value' => $__templater->filter($__vars['feed']['DefaultTags'], array(array('pluck', array('tag', )),array('join', array(', ', )),), false),
		'href' => $__templater->func('link_type', array('public', 'misc/tag-auto-complete', ), false),
	), array(
		'label' => 'Default tags',
		'explain' => 'Multiple tags may be separated by commas.',
	));
	return $__finalCompiled;
}
);