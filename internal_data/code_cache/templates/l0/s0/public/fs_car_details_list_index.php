<?php
// FROM HASH: b4876e4eb6344c3f8f27a920c10d6df8
return array(
'macros' => array('car_details_filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'conditions' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-filterBar">
		<div class="filterBar">
			<a
			   class="filterBar-menuTrigger"
			   data-xf-click="menu"
			   role="button"
			   tabindex="0"
			   aria-expanded="false"
			   aria-haspopup="true"
			   >' . 'Filters' . '</a
				>
			<div
				 class="menu menu--wide"
				 data-menu="menu"
				 aria-hidden="true"
				 data-href="' . $__templater->func('link', array('cars-list/refine-search', null, $__vars['conditions'], ), true) . '"
				 data-load-target=".js-filterMenuBody"
				 >
				<div class="menu-content">
					<h4 class="menu-header">' . 'Show only:' . '</h4>
					<div class="js-filterMenuBody">
						<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => $__vars['data'],
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
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
		'html' => ' ' . 'Reg number' . ' ',
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
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
			$__finalCompiled .= '
		';
			$__compilerTemp1 = '';
			if ($__vars['val']['car_reg_date']) {
				$__compilerTemp1 .= ' ' . $__templater->func('date_dynamic', array($__vars['val']['car_reg_date'], array(
				))) . ' ';
			} else {
				$__compilerTemp1 .= ' - ';
			}
			$__finalCompiled .= $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('members/', $__vars['val'], ), false),
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['CarModel']['model']) . ' ',
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
				'html' => ' ' . $__templater->escape($__vars['val']['car_location']) . ' ',
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
				'html' => $__compilerTemp1,
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['car_forum_name']) . ' ',
			),
			array(
				'title' => $__vars['val']['car_unique_information'],
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('snippet', array($__vars['val']['car_unique_information'], 30, array('stripBbCode' => true, ), ), true) . ' ',
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(' ' . 'Car Details' . ' ');
	$__finalCompiled .= '

<div class="block">

	<div class="block-container">

		' . $__templater->callMacro(null, 'car_details_filter', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '

		<div class="block-body">

			';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '

					' . $__templater->callMacro(null, 'record_table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '
					';
	} else {
		$__compilerTemp1 .= '
					<div class="blockMessage">
						' . 'No items have been created yet.' . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>

		<div class="block-footer">
			<span class="block-footer-counter"
				  >' . $__templater->func('display_totals', array($__vars['data'], $__vars['total'], ), true) . '</span
				>
		</div>

	</div>
	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'cars-list',
		'data' => $__vars['data'],
		'params' => $__vars['conditions'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>

' . '

';
	return $__finalCompiled;
}
);