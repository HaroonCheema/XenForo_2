<?php
// FROM HASH: e69bfccddf60bfda1dc381886d729bb1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Coupons');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('Add coupon', array(
		'href' => $__templater->func('link', array('paid-registrations/coupons/add', ), false),
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
                        ';
				$__compilerTemp2 = '';
				if ($__vars['coupon']['discount_type'] == 'percent') {
					$__compilerTemp2 .= '
                                    ' . $__templater->escape($__vars['coupon']['discount_value']) . '%
                                ';
				} else if ($__vars['coupon']['discount_type'] == 'flat') {
					$__compilerTemp2 .= '
                                    ' . $__templater->filter($__vars['coupon']['discount_value'], array(array('number', array(2, )),), true) . ' (' . 'Flat amount' . ')
                                ';
				}
				$__compilerTemp3 = '';
				if ($__vars['coupon']['end_date']) {
					$__compilerTemp3 .= '
                                    ' . $__templater->func('date_dynamic', array($__vars['coupon']['end_date'], array(
						'data-full-date' => 'true',
					))) . '
                                ';
				} else {
					$__compilerTemp3 .= '
                                    ' . 'Never' . '
                                ';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'hash' => $__vars['coupon']['coupon_id'],
					'href' => $__templater->func('link', array('paid-registrations/coupons/edit', $__vars['coupon'], ), false),
					'label' => $__templater->escape($__vars['coupon']['title']),
					'hint' => $__templater->escape($__vars['coupon']['coupon_code']),
					'explain' => '
                                ',
					'_type' => 'main',
					'html' => '',
				),
				array(
					'_type' => 'cell',
					'html' => '
                                ' . $__compilerTemp2 . '
                            ',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['coupon']['start_date'], array(
					'data-full-date' => 'true',
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
                                ' . $__compilerTemp3 . '
                            ',
				),
				array(
					'name' => 'active[' . $__vars['coupon']['coupon_id'] . ']',
					'selected' => $__vars['coupon']['active'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['coupon']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				),
				array(
					'href' => $__templater->func('link', array('paid-registrations/coupons/delete', $__vars['coupon'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
                    ';
			}
		}
		$__finalCompiled .= $__templater->form('
        <div class="block-outer">
            ' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'cron',
			'class' => 'block-outer-opposite',
		), $__vars) . '
        </div>
        <div class="block-container">
            <div class="block-body">
                ' . $__templater->dataList('
                    ' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => '',
		),
		array(
			'_type' => 'cell',
			'html' => 'Discount',
		),
		array(
			'_type' => 'cell',
			'html' => 'Start date',
		),
		array(
			'_type' => 'cell',
			'html' => 'End date',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		),
		array(
			'_type' => 'cell',
			'html' => '',
		))) . '
                    ' . $__compilerTemp1 . '
                ', array(
		)) . '
            </div>
            <div class="block-footer">
                <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['coupons'], ), true) . '</span>
            </div>
        </div>
    ', array(
			'action' => $__templater->func('link', array('paid-registrations/coupons/toggle', ), false),
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