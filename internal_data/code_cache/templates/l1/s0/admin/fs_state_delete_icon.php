<?php
// FROM HASH: 95559dfc8cbe7ade344dbd19ec8ed191
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Please confirm delete icon');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '

				' . $__templater->formRow('
					<img src="' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getStateIcon', array()), ), true) . '" style="width: 250px; height: 250px;"/>
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
		'action' => $__templater->func('link', array('categories/delete-icon', $__vars['node'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);