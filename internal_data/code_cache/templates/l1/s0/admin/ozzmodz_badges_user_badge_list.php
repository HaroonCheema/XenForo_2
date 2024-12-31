<?php
// FROM HASH: be5a251ad664e456d55c3897a550d3ed
return array(
'macros' => array('entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'entry' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__vars['entry']['featured']) {
		$__compilerTemp1 .= '
				' . $__templater->fontAwesome('fa-bullhorn', array(
		)) . '
			';
	}
	$__compilerTemp2 = '';
	if ($__vars['entry']['AwardingUser']) {
		$__compilerTemp2 .= '
				' . $__templater->func('username_link', array($__vars['entry']['AwardingUser'], true, array(
			'notooltip' => 'true',
		))) . '
			';
	} else {
		$__compilerTemp2 .= '
				' . $__vars['xf']['language']['parenthesis_open'] . 'Unknown' . $__vars['xf']['language']['parenthesis_close'] . '
			';
	}
	$__finalCompiled .= $__templater->dataRow(array(
	), array(array(
		'name' => 'user_badge_ids[]',
		'value' => $__vars['entry']['user_badge_id'],
		'_type' => 'toggle',
		'html' => '',
	),
	array(
		'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
		'href' => $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), false),
		'_type' => 'cell',
		'html' => '
			' . $__templater->func('avatar', array($__vars['entry']['User'], 's', false, array(
		'href' => '',
	))) . '
		',
	),
	array(
		'class' => 'dataList-cell--min',
		'href' => $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), false),
		'_type' => 'cell',
		'html' => '
			' . $__templater->func('username_link', array($__vars['entry']['User'], true, array(
		'notooltip' => 'true',
		'href' => '',
	))) . '
		',
	),
	array(
		'class' => 'dataList-cell--min dataList-cell--iconic dataList-cell--image dataList-cell--imageSmall',
		'_type' => 'cell',
		'html' => '
			' . $__templater->callMacro('public:ozzmodz_badges_badge_macros', 'badge_icon', array(
		'badge' => $__vars['entry']['Badge'],
	), $__vars) . '
		',
	),
	array(
		'_type' => 'cell',
		'html' => '
			<a href="' . $__templater->func('link', array('ozzmodz-badges/edit', $__vars['entry']['Badge'], ), true) . '">' . $__templater->escape($__vars['entry']['Badge']['title']) . '</a>
			
			' . $__compilerTemp1 . '
		',
	),
	array(
		'_type' => 'cell',
		'html' => '
			' . $__templater->escape($__vars['entry']['reason']) . '
		',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '
			' . $__compilerTemp2 . '
		',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => $__templater->func('date_dynamic', array($__vars['entry']['award_date'], array(
	))),
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '
			' . ($__vars['entry']['featured'] ? 'Yes' : 'No') . '
		',
	),
	array(
		'href' => $__templater->func('link', array('ozzmodz-badges-user-badge/delete', $__vars['entry'], ), false),
		'_type' => 'delete',
		'html' => '',
	))) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Users awarded with badge');
	$__finalCompiled .= '

';
	if ($__vars['entries']) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['entries'])) {
			foreach ($__vars['entries'] AS $__vars['entry']) {
				$__compilerTemp1 .= '
						' . $__templater->callMacro(null, 'entry', array(
					'entry' => $__vars['entry'],
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">

			' . $__templater->callMacro(null, 'filter_macros::filter_bar', array(
			'route' => 'ozzmodz-badges-user-badge',
			'params' => $__vars['filters'],
			'menu' => 'ozzmodz-badges-user-badge/refine-search',
			'menuTitle' => 'Refine search',
		), $__vars) . '

			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'colspan' => '2',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Username',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'_type' => 'cell',
			'html' => 'Badge',
		),
		array(
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Awarded by',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Date',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Featured',
		),
		array(
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '

					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['entries'], $__vars['total'], ), true) . '</span>
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
						' . $__templater->formSelect(array(
			'class' => 'actionInput',
			'name' => 'action',
		), array(array(
			'value' => 'feature',
			'label' => 'Feature badge',
			'_type' => 'option',
		),
		array(
			'value' => 'unfeature',
			'label' => 'Unfeature badge',
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

						<span class="inputGroup-splitter"></span>
						' . $__templater->button('Proceed' . $__vars['xf']['language']['ellipsis'], array(
			'type' => 'submit',
		), '', array(
		)) . '
					</div>
				</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ozzmodz-badges-user-badge',
			'params' => $__vars['filters'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	', array(
			'action' => $__templater->func('link', array('ozzmodz-badges-user-badge/batch-update', ), false),
			'class' => 'block',
			'ajax' => 'true',
			'data-xf-init' => 'select-plus',
			'data-sp-checkbox' => 'input[name=\'user_badge_ids[]\']',
			'data-sp-container' => '.dataList-row',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There is nothing to display.' . '</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);