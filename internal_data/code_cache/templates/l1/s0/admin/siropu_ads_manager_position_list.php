<?php
// FROM HASH: 2fca1f2b0a398d2029269709c8e98392
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Positions');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup">
		' . $__templater->button('Add position', array(
		'href' => $__templater->func('link', array('ads-manager/positions/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
		' . $__templater->button('Add category', array(
		'href' => $__templater->func('link', array('ads-manager/position-categories/add', ), false),
		'icon' => 'add',
		'overlay' => 'true',
	), '', array(
	)) . '

		<div class="buttonGroup-buttonWrapper">
			' . $__templater->button('&#8226;&#8226;&#8226;', array(
		'class' => 'menuTrigger',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'title' => $__templater->filter('More options', array(array('for_attr', array()),), false),
	), '', array(
	)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h4 class="menu-header">' . 'More options' . '</h4>
					<a href="' . $__templater->func('link', array('ads-manager/positions/sort', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Sort' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/positions/reset', ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Reset positions' . '</a>
				</div>
			</div>
		</div>
	</div>
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		<div class="block-outer-main">
			<a class="menuTrigger button button--link"
			   data-xf-click="menu"
			   role="button"
			   tabindex="0"
			   aria-expanded="false"
			   aria-haspopup="true">
				' . 'Type' . $__vars['xf']['language']['label_separator'] . '
				';
	if ($__vars['type'] == 'default') {
		$__finalCompiled .= '
					' . 'Default' . '
				';
	} else if ($__vars['type'] == 'custom') {
		$__finalCompiled .= '
					' . 'Custom' . '
				';
	} else {
		$__finalCompiled .= '
					' . $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'] . '
				';
	}
	$__finalCompiled .= '
			</a>

			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					<h3 class="menu-header">' . 'Position types' . '</h3>
					<a href="' . $__templater->func('link', array('ads-manager/positions', ), true) . '" class="menu-linkRow ' . ((!$__vars['type']) ? 'is-selected' : '') . '">(' . 'Any' . ')</a>
					<a href="' . $__templater->func('link', array('ads-manager/positions', '', array('type' => 'default', ), ), true) . '" class="menu-linkRow ' . (($__vars['type'] == 'default') ? 'is-selected' : '') . '">' . 'Default' . '</a>
					<a href="' . $__templater->func('link', array('ads-manager/positions', '', array('type' => 'custom', ), ), true) . '" class="menu-linkRow ' . (($__vars['type'] == 'custom') ? 'is-selected' : '') . '">' . 'Custom' . '</a>
				</div>
			</div>
		</div>
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'positions',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['positionData']['positionCategories'])) {
		foreach ($__vars['positionData']['positionCategories'] AS $__vars['positionCategoryId'] => $__vars['positionCategory']) {
			$__compilerTemp1 .= '
					<tbody class="dataList-rowGroup">
						';
			if (($__templater->func('count', array($__vars['positionData']['positionCategories'], ), false) > 1)) {
				$__compilerTemp1 .= '
							';
				$__vars['positionCount'] = $__templater->filter($__templater->func('count', array($__vars['positionData']['positions'][$__vars['positionCategoryId']], ), false), array(array('number', array()),), false);
				$__compilerTemp1 .= '
							';
				$__compilerTemp2 = array();
				if (($__vars['positionCategoryId'] > 0)) {
					$__compilerTemp3 = '';
					if ($__vars['positionCategory']['description']) {
						$__compilerTemp3 .= '
											<div class="dataList-subRow">' . $__templater->filter($__vars['positionCategory']['description'], array(array('raw', array()),), true) . '</div>
										';
					}
					$__compilerTemp2[] = array(
						'href' => $__templater->func('link', array('ads-manager/position-categories/edit', $__vars['positionCategory'], ), false),
						'_type' => 'cell',
						'html' => '
										<div class="dataList-mainRow">' . $__templater->escape($__vars['positionCategory']['title']) . ' (' . $__templater->escape($__vars['positionCount']) . ')</div>
										' . $__compilerTemp3 . '
									',
					);
					$__compilerTemp2[] = array(
						'href' => $__templater->func('link', array('ads-manager/position-categories/delete', $__vars['positionCategory'], ), false),
						'overlay' => 'true',
						'_type' => 'delete',
						'html' => '',
					);
				} else {
					$__compilerTemp2[] = array(
						'colspan' => '2',
						'_type' => 'cell',
						'html' => 'Uncategorized positions' . ' (' . $__templater->escape($__vars['positionCount']) . ')',
					);
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'rowtype' => 'subsection',
					'rowclass' => ((!$__vars['positionCategoryId']) ? 'dataList-row--noHover' : ''),
				), $__compilerTemp2) . '
						';
			}
			$__compilerTemp1 .= '

						';
			$__compilerTemp4 = true;
			if ($__templater->isTraversable($__vars['positionData']['positions'][$__vars['positionCategoryId']])) {
				foreach ($__vars['positionData']['positions'][$__vars['positionCategoryId']] AS $__vars['positionId'] => $__vars['position']) {
					$__compilerTemp4 = false;
					$__compilerTemp1 .= '
							' . $__templater->dataRow(array(
						'hash' => $__vars['position']['position_id'],
						'href' => $__templater->func('link', array('ads-manager/positions/edit', $__vars['position'], ), false),
						'label' => $__templater->escape($__vars['position']['title']),
						'hint' => $__templater->escape($__vars['position']['description']),
						'delete' => $__templater->func('link', array('ads-manager/positions/delete', $__vars['position'], ), false),
						'dir' => 'auto',
					), array()) . '
							';
				}
			}
			if ($__compilerTemp4) {
				$__compilerTemp1 .= '
							';
				$__compilerTemp5 = '';
				if (($__templater->func('count', array($__vars['positionCategories'], ), false) > 1)) {
					$__compilerTemp5 .= '
										' . 'No positions have been added to this category yet.' . '
									';
				} else if (($__vars['positionCategoryId'] == 10) AND (!$__templater->func('is_addon_active', array('XFMG', ), false))) {
					$__compilerTemp5 .= '
										' . 'Media Gallery is not installed.' . '
									';
				} else if (($__vars['positionCategoryId'] == 11) AND (!$__templater->func('is_addon_active', array('XFRM', ), false))) {
					$__compilerTemp5 .= '
										' . 'Resource Manager is not installed.' . '
									';
				} else if (($__vars['positionCategoryId'] == 12) AND (!$__templater->func('is_addon_active', array('XenAddons/AMS', ), false))) {
					$__compilerTemp5 .= '
										' . 'Article Management System is not installed.' . '
									';
				} else {
					$__compilerTemp5 .= '
										' . 'No positions have been added yet.' . '
									';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
					'rowclass' => 'dataList-row--noHover dataList-row--note',
				), array(array(
					'class' => 'dataList-cell--noSearch',
					'_type' => 'cell',
					'html' => '
									' . $__compilerTemp5 . '
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
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['positionData']['totalPositions'], ), true) . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);