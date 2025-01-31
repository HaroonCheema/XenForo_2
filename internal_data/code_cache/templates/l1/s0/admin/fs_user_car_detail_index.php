<?php
// FROM HASH: 1368020dc8b5b0927a5253f7cb7fa36c
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
		'html' => ' ' . 'Username' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Model' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Colour' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Trim' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Location' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Plaque Number' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Reg Number' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Car Reg Date' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Forum Name' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Unique Information' . ' ',
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
		foreach ($__vars['data'] AS $__vars['val']) {
			$__finalCompiled .= '
		';
			$__compilerTemp1 = '';
			if ($__vars['val']['username']) {
				$__compilerTemp1 .= ' ' . $__templater->func('username_link', array($__vars['val']['User'], true, array(
					'class' => '',
				))) . ' ';
			} else {
				$__compilerTemp1 .= ' ' . 'Unknown' . ' ';
			}
			$__compilerTemp2 = '';
			if ($__vars['val']['car_reg_date']) {
				$__compilerTemp2 .= ' ' . $__templater->func('date_dynamic', array($__vars['val']['car_reg_date'], array(
				))) . ' ';
			} else {
				$__compilerTemp2 .= ' - ';
			}
			$__finalCompiled .= $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => ' ' . $__compilerTemp1 . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['Model']['model']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_colour']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_trim']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['Location']['location']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_plaque_number']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_reg_number']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => $__compilerTemp2,
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_forum_name']) . ' ',
			),
			array(
				'href' => $__templater->func('link', array('car-details/unique-info', $__vars['val'], array('car_unique_information' => $__vars['val']['car_unique_information'], ), ), false),
				'title' => $__vars['val']['car_unique_information'],
				'overlay' => 'true',
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('snippet', array($__vars['val']['car_unique_information'], 10, array('stripBbCode' => true, ), ), true) . ' ',
			),
			array(
				'href' => $__templater->func('link', array('car-details/edit', $__vars['val'], ), false),
				'_type' => 'action',
				'html' => 'Edit',
			),
			array(
				'href' => $__templater->func('link', array('car-details/delete', $__vars['val'], ), false),
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Car Details');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add car', array(
		'href' => $__templater->func('link', array('car-details/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '
';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['cars'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'table_list', array(
			'data' => $__vars['cars'],
		), $__vars) . '


				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['cars'], $__vars['total'], ), true) . '</span
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
		'key' => 'car-details',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>


	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'car-details',
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