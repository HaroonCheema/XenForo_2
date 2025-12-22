<?php
// FROM HASH: b2d6cd4634ce1270ed731128509c708d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['category']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add category');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit category' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['category']['category_name']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Categories'), $__templater->func('link', array('ewr-porta/categories', ), false), array(
	));
	$__finalCompiled .= '

';
	if ($__vars['category']) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ewr-porta/categories/delete', $__vars['category'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	$__compilerTemp2 = $__templater->method($__vars['styleTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['style_id'],
				'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__templater->formTextBoxRow(array(
		'name' => 'category[category_name]',
		'value' => $__vars['category']['category_name'],
	), array(
		'label' => 'Category',
	)) . '
			' . $__templater->formTextAreaRow(array(
		'name' => 'category[category_description]',
		'value' => $__vars['category']['category_description'],
		'autosize' => 'true',
	), array(
		'label' => 'Description',
	)) . '
			
			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'style_override',
		'selected' => $__vars['category']['style_id'],
		'label' => 'Override user style choice',
		'explain' => 'If specified, all visitors will view this item and its contents using the selected style, regardless of their personal style preference.',
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'category[style_id]',
		'value' => $__vars['category']['style_id'],
	), $__compilerTemp1)),
		'_type' => 'option',
	)), array(
	)) . '
				
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ewr-porta/categories/save', $__vars['category'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);