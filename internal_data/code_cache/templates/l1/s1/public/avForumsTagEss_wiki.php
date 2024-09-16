<?php
// FROM HASH: 0c0d516a14b9363635bae8d01e8263f0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['tag']['tag']));
	$__finalCompiled .= '

' . $__templater->callMacro('avForumsTagEss_macros', 'tag_view_header', array(
		'tag' => $__vars['tag'],
		'activePage' => 'viewInformation',
	), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__vars['tag']['tagess_wiki_tagline']) {
		$__compilerTemp1 .= '
				' . $__templater->formRow('
					' . $__templater->escape($__vars['tag']['tagess_wiki_tagline']) . '
				', array(
			'label' => 'Tagline',
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['tag']['tagess_wiki_description']) {
		$__compilerTemp2 .= '
					' . $__templater->func('bb_code', array($__vars['tag']['tagess_wiki_description'], 'tag_wiki', $__vars['tag'], ), true) . '
				';
	} else {
		$__compilerTemp2 .= '
					' . 'No Wikipedia entry exists for this tag' . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
			
			' . $__templater->formRow('
				' . $__compilerTemp2 . '
			', array(
		'label' => 'Description',
	)) . '
		</div>
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