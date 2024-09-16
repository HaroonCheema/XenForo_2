<?php
// FROM HASH: 7d9041300203bf91426a2010260e6046
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['tag']['SynonymOf']) {
		$__finalCompiled .= '
	' . $__templater->button('<i class="fa fa-caret-square-o-left" aria-hidden="true"></i> ' . 'Synonym of \'' . $__templater->escape($__vars['tag']['SynonymOf']['ParentTag']['tag']) . '\'', array(
			'href' => $__templater->func('link', array('tags/edit', $__vars['tag']['SynonymOf']['ParentTag'], ), false),
		), '', array(
		)) . '
';
	}
	$__finalCompiled .= '

' . $__templater->button('<i class="fa fa-ban" aria-hidden="true"></i> ' . 'Blacklist', array(
		'href' => $__templater->func('link', array('tags/blacklist', null, array('existing_tag_id' => $__vars['tag']['tag_id'], ), ), false),
	), '', array(
	));
	return $__finalCompiled;
}
);