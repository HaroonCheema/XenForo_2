<?php
// FROM HASH: ef2e111015df3203bd1e823a79c3e8e0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Take away badge');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['userBadges'], 'empty', array())) {
		$__compilerTemp1 .= '
				';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['userBadges'])) {
			foreach ($__vars['userBadges'] AS $__vars['userBadge']) {
				$__compilerTemp2 .= '
						';
				$__compilerTemp3 = '';
				if ($__vars['userBadge']['Badge']['user_criteria']) {
					$__compilerTemp3 .= '
											' . $__templater->fontAwesome('fa-filter', array(
						'title' => 'Has user criteria',
						'data-xf-init' => 'tooltip',
						'class' => 'has-userCriteria',
					)) . '
										';
				}
				$__compilerTemp4 = '';
				if ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml']) {
					$__compilerTemp4 .= '
										' . $__templater->filter($__vars['userBadge']['reason'], array(array('raw', array()),), true) . '
									';
				} else {
					$__compilerTemp4 .= '
										' . $__templater->escape($__vars['userBadge']['reason']) . '
									';
				}
				$__compilerTemp5 = '';
				if ($__vars['userBadge']['Badge']['Category']) {
					$__compilerTemp5 .= '
									' . $__templater->escape($__vars['userBadge']['Badge']['Category']['title']) . '
								';
				} else {
					$__compilerTemp5 .= '
									' . 'Uncategorized' . '
								';
				}
				$__compilerTemp6 = '';
				if ($__vars['userBadge']['award_date']) {
					$__compilerTemp6 .= '
									' . $__templater->func('date_dynamic', array($__vars['userBadge']['award_date'], array(
					))) . '
								';
				} else {
					$__compilerTemp6 .= '
									' . 'N/A' . '
								';
				}
				$__compilerTemp2 .= $__templater->dataRow(array(
					'rowclass' => 'dataList-row--noHover',
				), array(array(
					'class' => 'dataList-cell--iconic',
					'_type' => 'cell',
					'html' => '
								' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_icon', array(
					'badge' => $__vars['userBadge']['Badge'],
				), $__vars) . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								<div class="dataList-mainRow" dir="auto">
									' . $__templater->escape($__vars['userBadge']['Badge']['title']) . '
									
									<span class="u-pullRight">
										' . $__compilerTemp3 . '
									</span>
								</div>
								<div class="dataList-subRow">
									' . $__compilerTemp4 . '
								</div>
							',
				),
				array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp5 . '
							',
				),
				array(
					'class' => 'dataList-cell--min',
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp6 . '
							',
				),
				array(
					'name' => 'user_badge_ids[]',
					'value' => $__vars['userBadge']['user_badge_id'],
					'class' => 'dataList-cell--separated dataList-cell--alt',
					'disabled' => (!$__templater->method($__vars['userBadge'], 'canDelete', array())),
					'_type' => 'toggle',
					'html' => '',
				))) . '
					';
			}
		}
		$__compilerTemp1 .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'_type' => 'cell',
			'html' => 'Badge',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Category',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => 'Award date',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '
							' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.dataList >',
			'data-xf-init' => 'tooltip',
			'title' => 'Select all',
			'_type' => 'option',
		))) . '
						',
		))) . '
					' . $__compilerTemp2 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			
			' . $__compilerTemp1 . '
			
		</div>
		' . $__templater->formSubmitRow(array(
		'fa' => 'fa-minus-square',
		'submit' => 'Take away',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('members/take-away-badge', $__vars['user'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);