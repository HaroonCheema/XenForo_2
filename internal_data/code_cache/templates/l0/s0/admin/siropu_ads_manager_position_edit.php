<?php
// FROM HASH: 4961933ee39e97640fdf32b6296079c7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['position'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add position');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit position' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['position']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['position'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['position'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/positions/delete', $__vars['position'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['positionCategories']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__templater->fontAwesome('fas fa-info-circle', array(
	)) . ' ' . 'Instructions on how to use this position will be provided after the position is saved.' . '
			', array(
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'position_id',
		'value' => $__vars['position']['position_id'],
		'placeholder' => 'Example: your_position_id',
		'data-xf-init' => 'siropu-ads-manager-position-id',
		'required' => 'true',
	), array(
		'label' => 'Position Id',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['position']['title'],
		'required' => 'true',
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['position']['description'],
		'autosize' => 'true',
	), array(
		'label' => 'Description',
		'hint' => 'Optional',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'category_id',
		'value' => $__vars['position']['category_id'],
	), $__compilerTemp1, array(
		'label' => 'Position category',
	)) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['position']['display_order'],
	), $__vars) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/positions/save', $__vars['position'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);