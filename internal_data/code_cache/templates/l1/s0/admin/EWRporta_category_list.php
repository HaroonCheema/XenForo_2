<?php
// FROM HASH: 233559a158fe19bf5a4ca60557200f7f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Categories');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add category', array(
		'href' => $__templater->func('link', array('ewr-porta/categories/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'games',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<h3 class="block-header">' . 'Categories' . '</h3>
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	$__compilerTemp2 = true;
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__compilerTemp2 = false;
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'hash' => $__vars['category']['category_id'],
				'href' => $__templater->func('link', array('ewr-porta/categories/edit', $__vars['category'], ), false),
				'label' => $__templater->escape($__vars['category']['category_name']),
				'_type' => 'main',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/categories/edit', $__vars['category'], ), false),
				'_type' => 'cell',
				'html' => '
							<span class="dataList-hint">' . $__templater->escape($__vars['category']['category_description']) . '</span>
						',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/categories/delete', $__vars['category'], ), false),
				'_type' => 'delete',
				'html' => '',
			))) . '
				';
		}
	}
	if ($__compilerTemp2) {
		$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			'rowclass' => 'dataList-row--noHover dataList-row--note',
		), array(array(
			'class' => 'dataList-cell--noSearch',
			'_type' => 'cell',
			'html' => '
							' . 'No items to display' . '
						',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);