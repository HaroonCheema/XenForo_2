<?php
// FROM HASH: ebd0a35051ec6336cdd20ed0e1e3cfae
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['nodeTree'])) {
		foreach ($__vars['nodeTree'] AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['value'],
				'label' => $__templater->escape($__vars['treeEntry']['label']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<b>' . 'Automatically create articles from forum threads' . '</b>
			', array(
		'rowtype' => 'confirm',
	)) . '
			' . $__templater->formSelectRow(array(
		'name' => 'node_id',
		'value' => '0',
	), $__compilerTemp1, array(
		'label' => 'Forum',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'refresh',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/promote', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);