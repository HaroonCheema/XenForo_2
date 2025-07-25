<?php
// FROM HASH: 956a00748a8f0861640c5c1604e8ca3b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('listing : ' . $__templater->escape($__vars['mailingList']['title']) . '');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('Return ', array(
		'href' => $__templater->func('link', array('mailing-lists', ), false),
		'icon' => 'back',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
    ';
	if (!$__templater->test($__vars['queueItems'], 'empty', array())) {
		$__finalCompiled .= '
        <div class="block-outer">
            ' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'mail-queue',
			'class' => 'block-outer-opposite',
		), $__vars) . '
        </div>
    ';
	}
	$__finalCompiled .= '

    <div class="block-container">
        ';
	if (!$__templater->test($__vars['queueItems'], 'empty', array())) {
		$__finalCompiled .= '
            ';
		$__compilerTemp1 = array(array(
			'_type' => 'cell',
			'html' => 'Email',
		));
		if ($__vars['mailingList']['type']) {
			$__compilerTemp1[] = array(
				'_type' => 'cell',
				'html' => 'User',
			);
		}
		$__compilerTemp1[] = array(
			'_type' => 'cell',
			'html' => 'Status',
		);
		$__compilerTemp1[] = array(
			'_type' => 'cell',
			'html' => 'Date',
		);
		$__compilerTemp1[] = array(
			'_type' => 'cell',
			'html' => 'Attempts',
		);
		$__compilerTemp1[] = array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		);
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['queueItems'])) {
			foreach ($__vars['queueItems'] AS $__vars['item']) {
				$__compilerTemp2 .= '
                            ';
				$__compilerTemp3 = array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['email']),
				));
				if ($__vars['item']['User']) {
					$__compilerTemp3[] = array(
						'_type' => 'cell',
						'html' => '
										<a href="' . $__templater->func('link', array('users/edit', $__vars['item']['User'], ), true) . '">' . $__templater->escape($__vars['item']['User']['username']) . '</a>
									',
					);
				}
				if (($__vars['item']['status'] == 'invalid')) {
					$__compilerTemp3[] = array(
						'_type' => 'cell',
						'html' => 'Invalid Email',
					);
				} else {
					$__compilerTemp3[] = array(
						'_type' => 'cell',
						'html' => $__templater->escape($__vars['item']['status']),
					);
				}
				$__compilerTemp4 = '';
				if ($__vars['item']['send_date']) {
					$__compilerTemp4 .= '
                                        ' . $__templater->func('date_dynamic', array($__vars['item']['send_date'], array(
					))) . '
                                    ';
				} else {
					$__compilerTemp4 .= '
                                        ' . 'Pending' . '
                                    ';
				}
				$__compilerTemp3[] = array(
					'_type' => 'cell',
					'html' => '
                                    ' . $__compilerTemp4 . '
                                ',
				);
				$__compilerTemp3[] = array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['item']['attempts']),
				);
				if (($__vars['item']['status'] == 'sent')) {
					$__compilerTemp3[] = array(
						'_type' => 'cell',
						'html' => 'sended',
					);
				} else {
					$__compilerTemp3[] = array(
						'href' => $__templater->func('link', array('mailing-lists/resend', $__vars['item'], array('queue_id' => $__vars['item']['queue_id'], ), ), false),
						'_type' => 'action',
						'html' => 'Resend',
					);
				}
				$__compilerTemp2 .= $__templater->dataRow(array(
				), $__compilerTemp3) . '
                        ';
			}
		}
		$__finalCompiled .= $__templater->form('
            
                <div class="block-body">
                    ' . $__templater->dataList('
                        ' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), $__compilerTemp1) . '

                        ' . $__compilerTemp2 . '
                    ', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
                </div>

                <div class="block-footer block-footer--split">
                    <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['queueItems'], $__vars['total'], ), true) . '</span>
                </div>
            ', array(
			'action' => $__templater->func('link', array('mailing-lists/queue', ), false),
			'ajax' => 'true',
			'data-xf-init' => 'select-plus',
			'data-sp-checkbox' => '.dataList-cell--toggle input:checkbox',
			'data-sp-container' => '.dataList-row',
			'data-sp-control' => '.dataList-cell a',
		)) . '
        ';
	} else {
		$__finalCompiled .= '
            <div class="block-body block-row">' . 'No results found.' . '</div>
        ';
	}
	$__finalCompiled .= '
    </div>

    ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'mailing-lists/' . $__vars['mailingList']['mailing_list_id'] . '/queue-list',
		'params' => $__vars['filters'],
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);