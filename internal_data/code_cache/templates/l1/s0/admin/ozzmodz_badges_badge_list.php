<?php
// FROM HASH: dfbb8e3b6a35800623b1efd3157d4dc7
return array(
'extensions' => array('badge_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
					' . $__templater->callMacro(null, 'badge_data_list', array(
		'badgeData' => $__vars['badgeData'],
		'totalCategories' => $__vars['totalCategories'],
	), $__vars) . '
				';
	return $__finalCompiled;
},
'actions' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
							' . $__templater->formSelect(array(
		'class' => 'actionInput',
		'name' => 'action',
	), array(array(
		'value' => 'disable',
		'label' => 'Disable',
		'_type' => 'option',
	),
	array(
		'value' => 'enable',
		'label' => 'Enable',
		'_type' => 'option',
	),
	array(
		'value' => 'export',
		'label' => 'Export',
		'_type' => 'option',
	),
	array(
		'label' => '&nbsp;',
		'_type' => 'option',
	),
	array(
		'value' => 'delete',
		'label' => 'Delete',
		'_type' => 'option',
	))) . '
						';
	return $__finalCompiled;
}),
'macros' => array('badge_data_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'badgeData' => '!',
		'totalCategories' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['badgeData']['badgeCategories'])) {
		foreach ($__vars['badgeData']['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
			$__compilerTemp1 .= '
			';
			$__vars['catActionDelete'] = ($__vars['catId'] > 0);
			$__compilerTemp1 .= '
			';
			$__vars['catHasActions'] = $__vars['catActionDelete'];
			$__compilerTemp1 .= '
			';
			$__vars['catSpan'] = ((1 + ((!$__vars['category']['icon_type']) ? 1 : 0)) + ((!$__vars['catHasActions']) ? 1 : 0));
			$__compilerTemp1 .= '
			';
			$__vars['catHref'] = (($__vars['catId'] != 0) ? $__templater->func('link', array('ozzmodz-badges-categories/edit', $__vars['category'], ), false) : '');
			$__compilerTemp1 .= '

			<tbody class="dataList-rowGroup">

				';
			if ($__vars['totalCategories'] != 1) {
				$__compilerTemp1 .= '
					';
				$__compilerTemp2 = array(array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
							' . $__templater->formCheckBox(array(
					'standalone' => 'true',
				), array(array(
					'check-all' => '.badgeLi--' . $__vars['catId'],
					'_type' => 'option',
				))) . '
						',
				));
				if ($__vars['category']['icon_type']) {
					$__compilerTemp2[] = array(
						'class' => 'icon dataList-cell--min',
						'href' => $__vars['catHref'],
						'_type' => 'cell',
						'html' => '
								' . $__templater->callMacro('public:ozzmodz_badges_badge_macros', 'category_icon', array(
						'category' => $__vars['category'],
					), $__vars) . '
							',
					);
				}
				$__compilerTemp3 = '';
				if ($__vars['catId'] == 0) {
					$__compilerTemp3 .= '
								' . 'Uncategorized' . '
							';
				} else {
					$__compilerTemp3 .= '
								' . $__templater->escape($__vars['category']['title']) . '
							';
				}
				$__compilerTemp2[] = array(
					'colspan' => $__vars['catSpan'],
					'href' => $__vars['catHref'],
					'_type' => 'cell',
					'html' => '
							' . $__compilerTemp3 . '
						',
				);
				if ($__vars['catHasActions']) {
					$__compilerTemp4 = '';
					if ($__vars['catActionDelete']) {
						$__compilerTemp4 .= '
											<a href="' . $__templater->func('link', array('ozzmodz-badges-categories/delete', $__vars['category'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
												' . 'Delete category' . '
											</a>
										';
					}
					$__compilerTemp2[] = array(
						'label' => '&#8226;&#8226;&#8226;',
						'_type' => 'popup',
						'html' => '
								<div class="menu" data-menu="menu" aria-hidden="true" data-menu-builder="dataList">
									<div class="menu-content">
										<h3 class="menu-header">' . 'Actions' . '</h3>
										' . $__compilerTemp4 . '
									</div>
								</div>
							',
					);
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'rowtype' => 'subsection',
					'rowclass' => 'category',
				), $__compilerTemp2) . '
				';
			}
			$__compilerTemp1 .= '

				';
			$__compilerTemp5 = true;
			if ($__templater->isTraversable($__vars['badgeData']['badges'][$__vars['catId']])) {
				foreach ($__vars['badgeData']['badges'][$__vars['catId']] AS $__vars['badgeId'] => $__vars['badge']) {
					$__compilerTemp5 = false;
					$__compilerTemp1 .= '
					';
					$__vars['badgeSpan'] = 1;
					$__compilerTemp1 .= '
					';
					$__vars['badgeHref'] = $__templater->func('link', array('ozzmodz-badges/edit', $__vars['badge'], ), false);
					$__compilerTemp1 .= '

					';
					$__compilerTemp6 = array(array(
						'name' => 'badge_ids[]',
						'value' => $__vars['badge']['badge_id'],
						'class' => ($__vars['badge']['badge_tier_id'] ? ('ozzmodzBadges-tier--' . $__vars['badge']['badge_tier_id']) : ''),
						'_type' => 'toggle',
						'html' => '',
					));
					if ($__vars['badge']['icon_type']) {
						$__compilerTemp6[] = array(
							'class' => 'icon dataList-cell--min',
							'href' => $__vars['badgeHref'],
							'_type' => 'cell',
							'html' => '
								' . $__templater->callMacro('public:ozzmodz_badges_badge_macros', 'badge_icon', array(
							'badge' => $__vars['badge'],
						), $__vars) . '
							',
						);
					}
					$__compilerTemp7 = '';
					if ($__vars['badge']['StackingBadge']) {
						$__compilerTemp7 .= '
									' . 'Stacked with' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['badge']['StackingBadge']['title']) . '
								';
					}
					$__compilerTemp8 = '';
					if ($__vars['badge']['user_criteria']) {
						$__compilerTemp8 .= '
									' . $__templater->fontAwesome('fa-filter', array(
							'title' => 'Has user criteria',
							'data-xf-init' => 'tooltip',
							'class' => 'has-userCriteria',
						)) . '
								';
					}
					$__compilerTemp9 = '';
					if ($__vars['badge']['is_repetitive']) {
						$__compilerTemp9 .= '
									' . $__templater->fontAwesome('fa-sync', array(
							'title' => 'Repetitive',
							'data-xf-init' => 'tooltip',
							'class' => 'isRepetitive',
						)) . '
								';
					}
					$__compilerTemp6[] = array(
						'colspan' => $__vars['badgeSpan'],
						'href' => $__vars['badgeHref'],
						'label' => $__templater->escape($__vars['badge']['title']),
						'hint' => '
								' . $__compilerTemp7 . '

								' . $__compilerTemp8 . '
								' . $__compilerTemp9 . '
							',
						'_type' => 'main',
						'html' => '',
					);
					$__compilerTemp6[] = array(
						'href' => $__templater->func('link', array('ozzmodz-badges/delete', $__vars['badge'], ), false),
						'_type' => 'delete',
						'html' => '',
					);
					$__compilerTemp1 .= $__templater->dataRow(array(
						'rowclass' => 'badgeLi badgeLi--' . $__vars['catId'] . ' ' . ((!$__vars['badge']['active']) ? 'dataList-row--deleted' : ''),
					), $__compilerTemp6) . '
				';
				}
			}
			if ($__compilerTemp5) {
				$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
					'rowclass' => 'dataList-row--noHover dataList-row--note',
				), array(array(
					'colspan' => '3',
					'class' => 'dataList-cell--noSearch',
					'_type' => 'cell',
					'html' => '
							' . 'No badges have been added to this category yet.' . '
						',
				))) . '
				';
			}
			$__compilerTemp1 .= '

			</tbody>
		';
		}
	}
	$__finalCompiled .= $__templater->dataList('
		' . $__compilerTemp1 . '

	', array(
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Badges');
	$__finalCompiled .= '

';
	$__templater->includeCss('ozzmodz_badges.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('ozzmodz_badges_badge_tiers.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add badge', array(
		'href' => $__templater->func('link', array('ozzmodz-badges/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		' . $__templater->button('Add badge category', array(
		'href' => $__templater->func('link', array('ozzmodz-badges-categories/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '

		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('&#8226;&#8226;&#8226;', array(
		'class' => 'menuTrigger',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'title' => 'More options',
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'More options' . '</h4>
					<a href="' . $__templater->func('link', array('ozzmodz-badges/award', ), true) . '" class="menu-linkRow">' . 'Award users...' . '</a>
					<a href="' . $__templater->func('link', array('ozzmodz-badges/unaward', ), true) . '" class="menu-linkRow">' . 'Unaward users...' . '</a>
					<a href="' . $__templater->func('link', array('ozzmodz-badges/sort', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Sort' . '</a>
					<a href="' . $__templater->func('link', array('ozzmodz-badges/import', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Import' . '</a>
				</div>
			</div>
		</div>
	</div>
');
	$__finalCompiled .= '

';
	if (($__vars['totalCategories'] == 1) AND (!$__vars['totalBadges'])) {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No badges have been created yet.' . '</div>
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'badges',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>

		' . $__templater->form('

			<div class="block-body badge-list">
				' . $__templater->renderExtension('badge_list', $__vars, $__extensions) . '
			</div>

			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['totalBadges'], ), true) . '</span>
				
				<span class="block-footer-select">
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '< .block-container',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '
				</span>
				<span class="block-footer-controls">
					<div class="inputGroup">

						' . $__templater->renderExtension('actions', $__vars, $__extensions) . '
						
						<span class="inputGroup-splitter"></span>
						' . $__templater->button('Proceed' . $__vars['xf']['language']['ellipsis'], array(
			'type' => 'submit',
		), '', array(
		)) . '
					</div>
				</span>
				
			</div>
		', array(
			'class' => 'block-container',
			'action' => $__templater->func('link', array('ozzmodz-badges/batch-update', ), false),
			'data-xf-init' => 'select-plus',
			'data-sp-checkbox' => '.dataList-cell--toggle input:checkbox',
			'ajax' => 'true',
		)) . '
	</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);