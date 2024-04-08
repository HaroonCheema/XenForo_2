<?php
// FROM HASH: 8ff70b77abaef08028bca84db5f88073
return array(
'macros' => array('table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . 'Title' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Image Path' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Num type repeat' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Minimum Posts' . ' ',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['value']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['title']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['img_path']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['type_repeat']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['mini_post']) . ' ',
			),
			array(
				'href' => $__templater->func('link', array('batch/edit', $__vars['value'], ), false),
				'_type' => 'action',
				'html' => 'Edit',
			),
			array(
				'href' => $__templater->func('link', array('batch/delete', $__vars['value'], ), false),
				'overlay' => 'true',
				'_type' => 'delete',
				'html' => '',
			))) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Batch');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add Batch', array(
		'href' => $__templater->func('link', array('batch/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '
';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '


				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
						>
				</div>

			</div>
			';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No items have been created yet.' . '</div>

		';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'batch',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>


	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'batch',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array($__vars['prefix'] . '/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
';
	return $__finalCompiled;
}
);