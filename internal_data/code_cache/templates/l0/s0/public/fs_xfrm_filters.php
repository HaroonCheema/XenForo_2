<?php
// FROM HASH: 873d9596d1843ad94ca1287f955a911d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['controlId'] = $__templater->preEscaped($__templater->func('unique_id', array(), true));
	$__vars['categoriesControlId'] = $__templater->func('unique_id', array(), false);
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'All categories',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['categoryTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['resource_category_id'],
				'label' => $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="menu-row menu-row--separated">
		<div class="inputGroup u-inputSpacer">

			' . '' . '

			' . $__templater->formTextBox(array(
		'type' => 'search',
		'placeholder' => 'Search Resource...',
		'name' => 'keywords',
		'value' => $__vars['input']['keywords'],
		'autofocus' => 'autofocus',
		'id' => $__vars['controlId'],
	)) . '
			<span class="inputGroup-splitter"></span>

			' . '' . '
			' . $__templater->formSelect(array(
		'name' => 'c[categories][]',
		'value' => $__templater->filter($__vars['input']['c']['categories'], array(array('default', array(array(0, ), )),), false),
		'id' => $__vars['categoriesControlId'],
	), $__compilerTemp1) . '

			<span class="inputGroup-splitter"></span>


			' . $__templater->button('Search', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</div>
	</div>


	' . $__templater->formHiddenVal('search_type', 'resource', array(
	)) . '
	' . $__templater->formHiddenVal('c[child_categories]', 'true', array(
	)) . '
	' . $__templater->formHiddenVal('c[title_only]', '', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('search/search', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

';
	return $__finalCompiled;
}
);