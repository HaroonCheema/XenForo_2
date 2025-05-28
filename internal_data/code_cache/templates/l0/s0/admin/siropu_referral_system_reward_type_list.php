<?php
// FROM HASH: 4bc1ee84f89d94571da909bafbe06488
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reward types');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	<div class="buttonGroup-buttonWrapper">
		' . $__templater->button('Add reward type', array(
		'class' => 'menuTrigger',
		'data-xf-click' => 'menu',
		'aria-expanded' => 'false',
		'aria-haspopup' => 'true',
		'icon' => 'add',
	), '', array(
	)) . '
		<div class="menu" data-menu="menu" aria-hidden="true">
			<div class="menu-content">
				<h4 class="menu-header">' . 'Type' . '</h4>
				<a href="' . $__templater->func('link', array('referral-system/reward-types/add', '', array('type' => 'trophy_points', ), ), true) . '" class="menu-linkRow">' . 'Trophy points' . '</a>
				<a href="' . $__templater->func('link', array('referral-system/reward-types/add', '', array('type' => 'dbtech_credits', ), ), true) . '" class="menu-linkRow">' . '[DBTech] Credits' . '</a>
			</div>
		</div>
	</div>
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['rewardTypes'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['rewardTypes'])) {
			foreach ($__vars['rewardTypes'] AS $__vars['rewardType']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['rewardType']['name']),
					'href' => $__templater->func('link', array('referral-system/reward-types/edit', $__vars['rewardType'], ), false),
					'hint' => $__templater->escape($__vars['rewardType']['type_phrase']),
					'delete' => $__templater->func('link', array('referral-system/reward-types/delete', $__vars['rewardType'], ), false),
					'dir' => 'auto',
				), array()) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'rewardTypes',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['rewardTypes'], $__vars['total'], ), true) . '</span>
				</div>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('referral-system/reward-types/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);