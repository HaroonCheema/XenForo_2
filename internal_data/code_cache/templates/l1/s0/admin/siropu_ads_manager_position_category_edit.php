<?php
// FROM HASH: 4236f08cba6738e711924f5243c5112b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['positionCategory'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add position category');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit position category' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['positionCategory']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['positionCategory'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/position-categories/delete', $__vars['positionCategory'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['positionCategory']['title'],
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['positionCategory']['description'],
		'autosize' => 'true',
	), array(
		'label' => 'Description',
		'hint' => 'Optional',
	)) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['positionCategory']['display_order'],
	), $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/position-categories/save', $__vars['positionCategory'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);