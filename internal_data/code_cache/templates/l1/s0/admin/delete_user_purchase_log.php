<?php
// FROM HASH: 2bed290558460174676934d5588a5e5f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Deleted User Purchase Log List');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['deletedPurchases'], 'empty', array())) {
		$__finalCompiled .= '
   <div class="block">
      <div class="block-container">
         <div class="block-body">
            ';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['deletedPurchases'])) {
			foreach ($__vars['deletedPurchases'] AS $__vars['deletedPurchase']) {
				$__compilerTemp1 .= '
                  ' . $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['deletedPurchase']['package_name']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['deletedPurchase']['User']['username']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['deletedPurchase']['reason_of_deletion']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('date_dynamic', array($__vars['deletedPurchase']['time'], array(
				))),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->button('
						' . 'Restore' . '
					', array(
					'icon' => 'fa-history',
					'href' => $__templater->func('link', array('delete-purchase-log/confirm-delete', $__vars['deletedPurchase'], ), false),
					'overlay' => 'true',
				), '', array(
				)) . '
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
			'html' => 'Package Name',
		),
		array(
			'_type' => 'cell',
			'html' => 'Purchaser Name',
		),
		array(
			'_type' => 'cell',
			'html' => 'Reason of Deletion',
		),
		array(
			'_type' => 'cell',
			'html' => 'Deleted At',
		),
		array(
			'_type' => 'cell',
			'html' => 'Action',
		))) . '
               ' . $__compilerTemp1 . '
            ', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
         </div>
         <div class="block-footer">
            <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['deletedPurchases'], $__vars['total'], ), true) . '</span>
         </div>
      </div>

      ' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'delete-purchase-log',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
   </div>
   ';
	} else {
		$__finalCompiled .= '
   <div class="blockMessage">There is no Deleted List</div>
';
	}
	return $__finalCompiled;
}
);