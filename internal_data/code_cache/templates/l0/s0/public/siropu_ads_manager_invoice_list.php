<?php
// FROM HASH: 07bbffdceae3896e2ca7fed641e0f53d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Your invoices');
	$__finalCompiled .= '

';
	$__templater->inlineCss('
.samMarkedAsPaid
{
	font-size: 10px;
	color: @xf-dimmed;
}
');
	$__finalCompiled .= '

';
	if ($__vars['pendingCount'] > 1) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Pay all invoices', array(
			'href' => $__templater->func('link', array('ads-manager/invoices/mass-pay', ), false),
			'icon' => 'purchase',
			'class' => 'button--cta',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('siropu_ads_manager_wrapper', $__vars);
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['invoices'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['invoices'])) {
			foreach ($__vars['invoices'] AS $__vars['invoice']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if ($__vars['invoice']['complete_date']) {
					$__compilerTemp2 .= '
									' . $__templater->func('date_dynamic', array($__vars['invoice']['complete_date'], array(
					))) . '
								';
				} else {
					$__compilerTemp2 .= '
									--
								';
				}
				$__compilerTemp3 = '';
				if ($__vars['invoice']['marked_as_paid']) {
					$__compilerTemp3 .= '
									<p class="samMarkedAsPaid">' . 'Marked as paid on ' . $__templater->func('date_time', array($__vars['invoice']['marked_as_paid'], ), true) . '' . '</p>
								';
				}
				$__compilerTemp4 = '';
				if ($__templater->method($__vars['invoice'], 'isPending', array())) {
					$__compilerTemp4 .= '
									' . $__templater->button('Pay', array(
						'href' => $__templater->func('link', array('ads-manager/invoices/pay', $__vars['invoice'], ), false),
						'icon' => 'purchase',
					), '', array(
					)) . '
								';
				} else if ($__vars['invoice']['invoice_file']) {
					$__compilerTemp4 .= '
									' . $__templater->button('Download', array(
						'href' => $__templater->func('link', array('ads-manager/invoices/download', $__vars['invoice'], ), false),
						'icon' => 'download',
						'class' => 'button--link',
					), '', array(
					)) . '
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => '#' . $__templater->escape($__vars['invoice']['invoice_id']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->filter($__vars['invoice']['cost_amount'], array(array('currency', array($__vars['invoice']['cost_currency'], )),), true),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['invoice']['create_date'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'width' => '15%',
					'_type' => 'cell',
					'html' => '
								' . $__templater->func('sam_status_phrase', array($__vars['invoice']['status'], 'invoice', ), true) . '
								' . $__compilerTemp3 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp4 . '
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Invoice ID',
		),
		array(
			'_type' => 'cell',
			'html' => 'Amount',
		),
		array(
			'_type' => 'cell',
			'html' => 'Date generated',
		),
		array(
			'_type' => 'cell',
			'html' => 'Date completed',
		),
		array(
			'_type' => 'cell',
			'html' => 'Status',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '

					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'ads-manager/invoices',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	', array(
			'action' => $__templater->func('link', array('ads-manager/invoices', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'You do not have any invoices at this time.' . '</div>
';
	}
	return $__finalCompiled;
}
);