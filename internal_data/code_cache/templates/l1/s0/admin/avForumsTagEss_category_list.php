<?php
// FROM HASH: 2581b110da0f82dc8e784354b128811d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Tag Categories');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add category', array(
		'href' => $__templater->func('link', array('tags/add-category', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['tagCategories'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['tagCategories'])) {
			foreach ($__vars['tagCategories'] AS $__vars['tagCategoryId'] => $__vars['tagCategoryTitle']) {
				$__compilerTemp2 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('tags/edit-category', null, array('category_id' => $__vars['tagCategoryId'], ), ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['tagCategoryId']),
				),
				array(
					'href' => $__templater->func('link', array('tags/edit-category', null, array('category_id' => $__vars['tagCategoryId'], ), ), false),
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['tagCategoryTitle']),
				),
				array(
					'href' => $__templater->func('link', array('tags/delete-category', null, array('category_id' => $__vars['tagCategoryId'], ), ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
					';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Category Id',
		),
		array(
			'_type' => 'cell',
			'html' => 'Title',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
					
					' . $__compilerTemp2 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['tagCategories'], $__vars['total'], ), true) . '</span>
			</div>
		';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No tag categories found' . '</div>
		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		' . $__compilerTemp1 . '
	</div>
', array(
		'action' => $__templater->func('link', array('tags/categories', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);