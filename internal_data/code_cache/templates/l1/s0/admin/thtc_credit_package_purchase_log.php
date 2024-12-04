<?php
// FROM HASH: 26cc257767f51d69501b99dd74a33fe3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
    ' . 'Purchase log' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['creditPackage']['title']) . '
');
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['creditPackage']['title'])), $__templater->func('link', array('thtc-credit-package/edit', $__vars['creditPackage'], ), false), array(
	));
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
' . '' . '

' . '' . '
' . $__templater->form('
    <div class="filterBlock">			
        <ul class="listInline">
            <li>
                ' . $__templater->formTextBox(array(
		'name' => 'username',
		'value' => $__vars['username'],
		'ac' => 'single',
		'class' => 'input filterBlock-input',
		'placeholder' => 'Username',
	)) . '
            </li>
            <li>
                ' . $__templater->formSelect(array(
		'name' => 'purchase_type',
		'value' => $__vars['linkFilters']['purchase_type'],
		'class' => 'filterBlock-input',
	), array(array(
		'label' => 'Both',
		'_type' => 'option',
	),
	array(
		'value' => 'credit_purchase',
		'label' => 'Paid',
		'_type' => 'option',
	),
	array(
		'value' => 'manually_granted',
		'label' => 'Manually Granted',
		'_type' => 'option',
	))) . '
            </li>
            <li style="display: inline-block; vertical-align: bottom">
                <div class="inputGroup inputGroup--auto">
                    ' . $__templater->formDateInput(array(
		'placeholder' => 'Start',
		'name' => 'start',
		'value' => ($__vars['linkFilters']['start'] ? $__templater->func('date', array($__vars['linkFilters']['start'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
                    <span class="inputGroup-text">-</span>
                    ' . $__templater->formDateInput(array(
		'name' => 'end',
		'placeholder' => 'End',
		'value' => ($__vars['linkFilters']['end'] ? $__templater->func('date', array($__vars['linkFilters']['end'], 'Y-m-d', ), false) : ''),
		'class' => 'filterBlock-input filterBlock-input--small',
	)) . '
                </div>
            </li>
            <li>
                ' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--small',
		'id' => 'filterButton',
	), '', array(
	)) . '
				' . $__templater->button('
    ' . 'Export' . '
', array(
		'type' => 'button',
		'class' => 'button--small',
		'id' => 'exportButton',
		'fa' => 'fa-file-export',
		'title' => 'Export a CSV list of all Purchases Log that match the current search parameters.',
		'data-xf-init' => '_tooltip',
	), '', array(
	)) . '
            </li>
        </ul>
    </div>
', array(
		'action' => $__templater->func('link', array('thtc-credit-package/purchase-log', $__vars['creditPackage'], array('filter' => 1, ), ), false),
		'method' => 'post',
		'class' => 'block',
		'id' => 'filterForm',
	)) . '

<!-- Export Button -->


');
	$__finalCompiled .= '
<div id="purchaseListContainer">
    ';
	if (!$__templater->test($__vars['purchases'], 'empty', array())) {
		$__finalCompiled .= '
        <div class="block">
            <div class="block-container">
                <div class="block-body">
                    ';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['purchases'])) {
			foreach ($__vars['purchases'] AS $__vars['purchase']) {
				$__compilerTemp1 .= '
                            ';
				$__vars['purchaseRequest'] = $__vars['purchase']['PurchaseRequest'];
				$__compilerTemp1 .= '
                            ' . $__templater->dataRow(array(
				), array(array(
					'class' => 'dataList-cell--min dataList-cell--image dataList-cell--imageSmall',
					'_type' => 'cell',
					'html' => '
                                    ' . $__templater->func('avatar', array($__vars['purchase']['User'], 'xs', false, array(
				))) . '
                                ',
				),
				array(
					'href' => $__templater->func('link', array('users/edit', $__vars['purchase']['User'], ), false),
					'label' => $__templater->func('username_link', array($__vars['purchase']['User'], true, array(
					'notooltip' => 'true',
					'href' => '',
				))),
					'hint' => '
                                        <ul class="listInline listInline--bullet" style="display: inline-block">
                                            <li>' . ($__vars['purchaseRequest'] ? ($__templater->escape($__vars['purchaseRequest']['PaymentProfile']['title']) ?: 'Unknown payment profile') : 'Manually granted') . '</li>
                                            <li>' . $__templater->func('date_dynamic', array($__vars['purchase']['purchased_at'], array(
				))) . '</li>
                                        </ul>
                                    ',
					'_type' => 'main',
					'html' => '',
				),
				array(
					'href' => $__templater->func('link', array('delete-purchase-log/delete-purchase', $__vars['purchase'], ), false),
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
                <div class="block-footer">
                    <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['purchases'], $__vars['total'], ), true) . '</span>
                </div>
            </div>
';
		if (!$__templater->test($__vars['linkFilters'], 'empty', array())) {
			$__finalCompiled .= '
            ' . $__templater->func('page_nav', array(array(
				'page' => $__vars['page'],
				'total' => $__vars['total'],
				'link' => 'thtc-credit-package/purchase-log&filter=1',
				'data' => $__vars['creditPackage'],
				'params' => $__vars['linkFilters'],
				'wrapperclass' => 'block-outer block-outer--after',
				'perPage' => $__vars['perPage'],
			))) . '
';
		} else {
			$__finalCompiled .= '
    ' . $__templater->func('page_nav', array(array(
				'page' => $__vars['page'],
				'total' => $__vars['total'],
				'link' => 'thtc-credit-package/purchase-log',
				'data' => $__vars['creditPackage'],
				'params' => $__vars['linkFilters'],
				'wrapperclass' => 'block-outer block-outer--after',
				'perPage' => $__vars['perPage'],
			))) . '
';
		}
		$__finalCompiled .= '
        </div>
    ';
	} else {
		$__finalCompiled .= '
        <div class="blockMessage">' . 'No entries have been logged.' . '</div>
    ';
	}
	$__finalCompiled .= '
</div>
<script>
    // Store the original filter form action on page load
    var originalFormAction = document.getElementById(\'filterForm\').action;

    // Handle the export button click
    document.getElementById(\'exportButton\').addEventListener(\'click\', function() {
        var form = document.getElementById(\'filterForm\');
        
        // Change the form action to export URL
        form.action = "' . $__templater->func('link', array('thtc-credit-package/purchase-export', $__vars['creditPackage'], ), true) . '";
        
        // Submit the form to trigger the export
        form.submit();
        
        // Reset the form action back to the original (filter) URL
        form.action = originalFormAction;
    });

    // Ensure the filter button uses the original action
    document.getElementById(\'filterButton\').addEventListener(\'click\', function() {
        var form = document.getElementById(\'filterForm\');
        
        // Reset the form action to the original filter URL before submission
        form.action = originalFormAction;
    });
</script>';
	return $__finalCompiled;
}
);