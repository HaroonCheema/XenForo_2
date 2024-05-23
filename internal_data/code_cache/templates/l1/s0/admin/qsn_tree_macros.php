<?php
// FROM HASH: 3eb56534fef9c43fd6c5c4fb2acff99b
return array(
'macros' => array('page_action' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'linkPrefix' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		<div class="buttonGroup">
			' . $__templater->button('Add Question', array(
		'href' => $__templater->func('link', array($__vars['linkPrefix'] . '/addEdit', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		</div>
	');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'qsn_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'qsnTree' => '!',
		'filterKey' => '!',
		'linkPrefix' => '!',
		'idKey' => 'question_id',
	); },
'global' => true,
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['qsnTree'], 'count', array()) > 0) {
		$__finalCompiled .= '
		<div class="block">
			<div class="block-outer">
				' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => $__vars['filterKey'],
			'class' => 'block-outer-opposite',
		), $__vars) . '
			</div>
			<div class="block-container">
				<div class="block-body">
					';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['qsnTree'])) {
			foreach ($__vars['qsnTree'] AS $__vars['treeEntry']) {
				$__compilerTemp1 .= '
							';
				$__vars['question'] = $__vars['treeEntry'];
				$__compilerTemp1 .= '
							';
				$__compilerTemp2 = array(array(
					'class' => 'dataList-cell--link dataList-cell--main',
					'hash' => $__vars['question'][$__vars['idKey']],
					'_type' => 'cell',
					'html' => '
									<a href="' . $__templater->func('link', array('quiz-qsn/addEdit', $__vars['question'], ), true) . '">
										<div class="u-depth' . $__templater->escape($__vars['question']) . '">
											<div class="dataList-mainRow">' . $__templater->escape($__vars['treeEntry']['question_title']) . '</div>
										</div>
									</a>
								',
				));
				if ($__vars['question'] != null) {
					$__compilerTemp2[] = array(
						'class' => ($__vars['question']['question_type'] ? 'dataList-cell--highlighted' : ''),
						'href' => $__templater->func('link', array($__vars['linkPrefix'] . '/addEdit', $__vars['question'], ), false),
						'_type' => 'action',
						'html' => '
										' . $__templater->escape($__vars['treeEntry']['question_type']) . '
									',
					);
				}
				$__compilerTemp2[] = array(
					'href' => $__templater->func('link', array($__vars['linkPrefix'] . '/confirm', $__vars['question'], ), false),
					'_type' => 'delete',
					'html' => '',
				);
				$__compilerTemp1 .= $__templater->dataRow(array(
				), $__compilerTemp2) . '
						';
			}
		}
		$__finalCompiled .= $__templater->dataList('
						' . $__compilerTemp1 . '
					', array(
		)) . '
				</div>
			</div>
		</div>
	';
	} else {
		$__finalCompiled .= '
		<div class="blockMessage">' . 'No items have been created yet.' . '</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'sortable_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'categoryTree' => '!',
		'linkPrefix' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">
				<div class="nestable-container" data-xf-init="nestable">
					' . $__templater->callMacro(null, 'sortable_list', array(
		'children' => $__vars['quizTree'],
	), $__vars) . '
					' . $__templater->formHiddenVal('categories', '', array(
	)) . '
				</div>
			</div>
			' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
		</div>
	', array(
		'action' => $__templater->func('link', array($__vars['linkPrefix'] . 'quiz-question/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
';
	return $__finalCompiled;
}
),
'sortable_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ol class="nestable-list">
		';
	if ($__templater->isTraversable($__vars['children'])) {
		foreach ($__vars['children'] AS $__vars['id'] => $__vars['child']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'sortable_list_entry', array(
				'child' => $__vars['child'],
				'children' => $__vars['child']['children'],
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= '
	</ol>
';
	return $__finalCompiled;
}
),
'sortable_list_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'child' => '!',
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="nestable-item" data-id="' . $__templater->escape($__vars['child']['id']) . '">
		<div class="nestable-handle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '">' . $__templater->fontAwesome('fa-bars', array(
	)) . '</div>
		<div class="nestable-content">' . $__templater->escape($__vars['child']['record']['title']) . '</div>
		';
	if (!$__templater->test($__vars['child']['children'], 'empty', array())) {
		$__finalCompiled .= '
			' . $__templater->callMacro(null, 'sortable_list', array(
			'children' => $__vars['child']['children'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
),
'parent_category_select_row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'category' => '!',
		'categoryTree' => '!',
		'idKey' => 'category_id',
		'parentIdKey' => 'parent_category_id',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['categoryTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry'][$__vars['idKey']],
				'label' => $__templater->func('repeat', array('--', $__vars['treeEntry']['depth'], ), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => $__vars['parentIdKey'],
		'value' => $__vars['category'][$__vars['parentIdKey']],
	), $__compilerTemp1, array(
		'label' => 'Parent category',
	)) . '
';
	return $__finalCompiled;
}
),
'qsn_delete_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'linkPrefix' => '!',
		'category' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->form('

		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
					<strong><a href="' . $__templater->func('link', array($__vars['linkPrefix'] . '/edit', $__vars['category'], ), true) . '">' . $__templater->escape($__vars['qsnTree']['question_title']) . '</a></strong>
				', array(
		'rowtype' => 'confirm',
	)) . '
			</div>
			' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => ((!$__vars['qsnTree']) ? 'simple' : ''),
	)) . '
		</div>
		' . $__templater->func('redirect_input', array(null, null, true)) . '

	', array(
		'action' => $__templater->func('link', array($__vars['linkPrefix'] . '/delete', $__vars['qsnTree'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '
' . '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);