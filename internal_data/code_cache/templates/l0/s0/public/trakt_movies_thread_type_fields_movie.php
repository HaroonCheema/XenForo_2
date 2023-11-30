<?php
// FROM HASH: 7a1b51ded96121151b5efcba308b51ee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (($__vars['context'] == 'create') AND ($__vars['subContext'] == 'quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth noGutter mergeNext';
		$__finalCompiled .= '
';
	} else if (($__vars['context'] == 'edit') AND ($__vars['subContext'] == 'first_post_quick')) {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = 'fullWidth mergeNext';
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__vars['rowType'] = '';
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->formTextBoxRow(array(
		'name' => 'nick97_movies_trakt_id',
		'value' => $__vars['thread']['Movie']['trakt_id'],
		'disabled' => ($__vars['context'] == 'edit'),
	), array(
		'label' => 'trakt_movies_link_id',
		'explain' => 'trakt_movies_explain_link',
		'rowtype' => $__vars['rowType'],
	));
	return $__finalCompiled;
}
);