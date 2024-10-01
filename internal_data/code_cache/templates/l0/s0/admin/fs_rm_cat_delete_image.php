<?php
// FROM HASH: db583031055ba1bfb8cfae2f5cdc0d89
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Delete Image');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				
				' . $__templater->formRow('
					<img src="' . $__templater->func('base_url', array($__templater->method($__vars['category'], 'getCatImage', array()), ), true) . '" style="width: 175px;"/>
				', array(
		'rowtype' => 'fullWidth noLabel',
	)) . '
			', array(
		'rowtype' => 'confirm',
	)) . '
			' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('resource-manager/categories/delete-image', $__vars['category'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);