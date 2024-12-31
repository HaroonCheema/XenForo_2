<?php
// FROM HASH: 21c2223da93995c91af9a09ba3237b96
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Badge tiers');
	$__finalCompiled .= '

';
	$__templater->includeCss('ozzmodz_badges_badge_tiers.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add', array(
		'href' => $__templater->func('link', array('ozzmodz-badges-tiers/add', ), false),
		'data-xf-click' => 'overlay',
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['badgeTiers'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'faq-content',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['badgeTiers'])) {
			foreach ($__vars['badgeTiers'] AS $__vars['badgeTier']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('ozzmodz-badges-tiers/edit', $__vars['badgeTier'], ), false),
					'class' => 'dataList-cell--main ' . ($__vars['badgeTier']['badge_tier_id'] ? ('ozzmodzBadges-tier--' . $__vars['badgeTier']['badge_tier_id']) : ''),
					'_type' => 'cell',
					'html' => '
								' . $__templater->escape($__vars['badgeTier']['title']) . '
							',
				),
				array(
					'href' => $__templater->func('link', array('ozzmodz-badges-tiers/delete', $__vars['badgeTier'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
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
	return $__finalCompiled;
}
);