<?php
// FROM HASH: ce1c209cd2253627e31ee3de8164bbea
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Coupons');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add coupon', array(
		'href' => $__templater->func('link', array('thmonetize-coupons/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['coupons'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['coupons'])) {
			foreach ($__vars['coupons'] AS $__vars['coupon']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['coupon']['code']) . ' - ' . $__templater->escape($__vars['coupon']['title']),
					'href' => $__templater->func('link', array('thmonetize-coupons/edit', $__vars['coupon'], ), false),
					'delete' => $__templater->func('link', array('thmonetize-coupons/delete', $__vars['coupon'], ), false),
				), array(array(
					'name' => 'active[' . $__vars['coupon']['coupon_id'] . ']',
					'selected' => $__vars['coupon']['active'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['coupon']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'coupons',
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
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['totalCoupons'], ), true) . '</span>
				</div>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('thmonetize-coupons/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->callMacro('option_macros', 'option_form_block', array(
		'options' => $__vars['options'],
	), $__vars);
	return $__finalCompiled;
}
);