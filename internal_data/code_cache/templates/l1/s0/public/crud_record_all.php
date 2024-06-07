<?php
// FROM HASH: 1eb9e7b49c2f71791a9bd5c708c46c8e
return array(
'macros' => array('search_menu' => array(
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
				 data-href="' . $__templater->func('link', array('crud/refine-search', null, $__vars['conditions'], ), true) . '"
				 data-load-target=".js-filterMenuBody"
				 >
				<div class="menu-content">
					<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
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
		'html' => ' Name ',
	),
	array(
		'_type' => 'cell',
		'html' => ' Class ',
	),
	array(
		'_type' => 'cell',
		'html' => ' Roll No ',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => ' Action ',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('crud/edit', $__vars['val'], ), false),
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['name']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['class']) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['val']['rollNo']) . ' ',
			),
			array(
				'href' => $__templater->func('link', array('crud/delete-record', $__vars['val'], ), false),
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('CRUD');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('CRUD'), '#', array(
	));
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add Record', array(
		'href' => $__templater->func('link', array('crud/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '

	' . $__templater->button('Leave Rating', array(
		'href' => $__templater->func('link', array('package-rating', ), false),
		'icon' => 'rate',
		'overlay' => 'true',
	), '', array(
	)) . '
	' . $__templater->func('csrf_input') . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['purchased'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h2 class="block-header">' . 'Purchased upgrades' . '</h2>

			<ul class="block-body listPlain">
				';
		if ($__templater->isTraversable($__vars['purchased'])) {
			foreach ($__vars['purchased'] AS $__vars['upgrade']) {
				$__finalCompiled .= '
					<li>
						<div>
							';
				$__vars['active'] = $__vars['upgrade']['Active'][$__vars['xf']['visitor']['user_id']];
				$__finalCompiled .= '
							';
				$__compilerTemp1 = '';
				if ($__vars['active']['end_date']) {
					$__compilerTemp1 .= '
									' . 'Expires' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['active']['end_date'], array(
					))) . '
									';
				} else {
					$__compilerTemp1 .= '
									' . 'Expires: Never' . '
								';
				}
				$__compilerTemp2 = '';
				if ($__vars['upgrade']['length_unit'] AND ($__vars['upgrade']['recurring'] AND $__vars['active']['PurchaseRequest'])) {
					$__compilerTemp2 .= '
									';
					$__vars['provider'] = $__vars['active']['PurchaseRequest']['PaymentProfile']['Provider'];
					$__compilerTemp2 .= '
									' . $__templater->filter($__templater->method($__vars['provider'], 'renderCancellation', array($__vars['active'], )), array(array('raw', array()),), true) . '
								';
				}
				$__finalCompiled .= $__templater->formRow('

								' . $__compilerTemp1 . '

								' . $__compilerTemp2 . '
							', array(
					'label' => $__templater->escape($__vars['upgrade']['title']),
					'hint' => $__templater->escape($__vars['upgrade']['cost_phrase']),
					'explain' => $__templater->filter($__vars['upgrade']['description'], array(array('raw', array()),), true),
				)) . '
						</div>
					</li>
					' . $__templater->formRow('
						' . $__templater->button('Cancel Subscription', array(
					'href' => $__templater->func('link', array('account/downgrade', null, array('user_upgrade_record_id' => $__vars['active']['user_upgrade_record_id'], ), ), false),
					'icon' => 'cancel',
					'class' => 'button--link',
					'overlay' => 'true',
				), '', array(
				)) . '
					', array(
					'rowtype' => 'button',
				)) . '
				';
			}
		}
		$__finalCompiled .= '
			</ul>



		</div>
	</div>
';
	}
	$__finalCompiled .= '

<div class="block">

	<div class="block-outer">
		' . $__templater->callMacro('filter_macro', 'quick_filter', array(
		'key' => 'crud',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<!-- filter macro -->

		' . $__templater->callMacro(null, 'search_menu', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '

		<!-- filter macro -->
		<div class="block-body">

			<!--       < Records >  -->

			';
	$__compilerTemp3 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp3 .= '
					<!-- list macro -->

					' . $__templater->callMacro(null, 'record_table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '

					<!-- list macro -->
					';
	} else {
		$__compilerTemp3 .= '
					<div class="blockMessage">
						' . 'No items have been created yet.' . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp3 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
			' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'crud',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '
			<!--       </ Records > -->
		</div>

		<!-- <div class="block-footer">
  <span class="block-footer-counter">footer</span>
   </div> -->
	</div>
</div>

<!-- All macros is here define in below -->

<!-- Filter Bar Macro Start -->

' . '

<!-- Filter Bar Macro End -->

<!-- Record Table List Start -->

' . '

<!-- Record Table List End -->';
	return $__finalCompiled;
}
);