<?php
// FROM HASH: 1b0c660b69cc5d177f3fa1d0a838d783
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Invoices');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add invoice', array(
		'href' => $__templater->func('link', array('ads-manager/invoices/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->formTextBox(array(
		'name' => 'username',
		'value' => $__vars['linkParams']['username'],
		'placeholder' => 'Advertiser' . $__vars['xf']['language']['ellipsis'],
		'type' => 'search',
		'data-xf-init' => 'auto-complete',
		'data-single' => 'true',
		'class' => 'input--inline',
	)) . '
			' . $__templater->formTextBox(array(
		'name' => 'promo_code',
		'value' => $__vars['linkParams']['promo_code'],
		'placeholder' => 'Promo code',
		'type' => 'search',
		'class' => 'input--inline',
	)) . '
			' . $__templater->formSelect(array(
		'name' => 'status',
		'value' => $__vars['linkParams']['status'],
		'class' => 'input--inline',
	), array(array(
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any status' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	),
	array(
		'value' => 'pending',
		'label' => 'Pending',
		'_type' => 'option',
	),
	array(
		'value' => 'completed',
		'label' => 'Completed',
		'_type' => 'option',
	),
	array(
		'value' => 'cancelled',
		'label' => 'Cancelled',
		'_type' => 'option',
	))) . '
			' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'recurring',
		'value' => '1',
		'checked' => $__vars['linkParams']['recurring'],
		'label' => 'Is subscription',
		'_type' => 'option',
	))) . '
			' . $__templater->button('', array(
		'type' => 'submit',
		'icon' => 'search',
	), '', array(
	)) . '
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/invoices', ), false),
		'class' => 'block',
	)) . '

';
	if (!$__templater->test($__vars['invoices'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'invoices',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['invoices'])) {
			foreach ($__vars['invoices'] AS $__vars['invoice']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if (!$__templater->test($__vars['invoice']['child_ids'], 'empty', array())) {
					$__compilerTemp2 .= '
									' . $__templater->fontAwesome('fa fa-list-alt', array(
					)) . '
								';
				}
				$__compilerTemp3 = '';
				if ($__vars['invoice']['recurring']) {
					$__compilerTemp3 .= '
									' . $__templater->fontAwesome('fal fa-sync-alt', array(
						'title' => 'Subscription',
						'data-xf-init' => 'tooltip',
					)) . '
								';
				}
				$__compilerTemp4 = '';
				if ($__vars['invoice']['Ad']) {
					$__compilerTemp4 .= '
									<a href="' . $__templater->func('link', array('ads-manager/ads/details', $__vars['invoice']['Ad'], ), true) . '">' . $__templater->escape($__vars['invoice']['Ad']['name']) . '</a>
								';
				}
				$__compilerTemp5 = '';
				if ($__vars['invoice']['complete_date']) {
					$__compilerTemp5 .= '
									' . $__templater->func('date_dynamic', array($__vars['invoice']['complete_date'], array(
					))) . '
								';
				} else {
					$__compilerTemp5 .= '
									--
								';
				}
				$__compilerTemp6 = '';
				if ($__templater->method($__vars['invoice'], 'isCompleted', array())) {
					$__compilerTemp6 .= '
											<a href="' . $__templater->func('link', array('ads-manager/invoices/upload', $__vars['invoice'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Upload custom invoice' . '</a>
										';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'href' => $__templater->func('link', array('ads-manager/invoices/edit', $__vars['invoice'], ), false),
					'_type' => 'cell',
					'html' => '
								#' . $__templater->escape($__vars['invoice']['invoice_id']) . '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__templater->filter($__vars['invoice']['cost_amount'], array(array('currency', array($__vars['invoice']['cost_currency'], )),), true) . '
								' . $__compilerTemp3 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('username_link', array($__vars['invoice']['User'], true, array(
					'defaultname' => $__vars['invoice']['username'],
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp4 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['invoice']['create_date'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp5 . '
							',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('sam_status_phrase', array($__vars['invoice']['status'], 'invoice', ), true),
				),
				array(
					'width' => '5%',
					'class' => 'dataList-cell--separated',
					'_type' => 'cell',
					'html' => '
								' . $__templater->button('', array(
					'class' => 'button--link button--iconOnly menuTrigger',
					'data-xf-click' => 'menu',
					'aria-label' => 'More options',
					'aria-expanded' => 'false',
					'aria-haspopup' => 'true',
					'fa' => 'fas fa-bars',
				), '', array(
				)) . '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<a href="' . $__templater->func('link', array('ads-manager/invoices/edit', $__vars['invoice'], ), true) . '" class="menu-linkRow">' . 'Edit' . '</a>
										<a href="' . $__templater->func('link', array('ads-manager/invoices/details', $__vars['invoice'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Details' . '</a>
										' . $__compilerTemp6 . '
										<a href="' . $__templater->func('link', array('ads-manager/invoices/delete', $__vars['invoice'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Delete' . '</a>
									</div>
								</div>
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
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
			'html' => 'Advertiser',
		),
		array(
			'_type' => 'cell',
			'html' => 'Ad',
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
			'_type' => 'cell',
			'html' => 'Options',
		))) . '
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['invoices'], $__vars['total'], ), true) . '</span>
				</div>
			</div>
		</div>
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'params' => $__vars['linkParams'],
			'total' => $__vars['total'],
			'link' => 'ads-manager/invoices',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
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