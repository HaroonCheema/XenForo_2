<?php
// FROM HASH: da985edf36b865fe24992264b262f85b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Brands');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add Brand', array(
		'href' => $__templater->func('link', array('bh_brand/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	';
	if (!$__templater->test($__vars['brands'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'bh_brand',
			'ajax' => $__templater->func('link', array('bh_brand', null, ), false),
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
	';
	}
	$__finalCompiled .= '
	
	<div class="block-container">
		';
	if (!$__templater->test($__vars['brands'], 'empty', array())) {
		$__finalCompiled .= '
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['brands'])) {
			foreach ($__vars['brands'] AS $__vars['brand']) {
				$__compilerTemp1 .= '
							' . $__templater->dataRow(array(
				), array(array(
					'name' => 'brand_ids[]',
					'value' => $__vars['brand']['brand_id'],
					'_type' => 'toggle',
					'html' => '',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['brand_title']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['discussion_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['view_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['rating_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['rating_avg']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['brand']['review_count']),
				),
				array(
					'href' => $__templater->func('link', array('bh_brand/edit', $__vars['brand'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				),
				array(
					'href' => $__templater->func('link', array('bh_brand/delete', $__vars['brand'], ), false),
					'_type' => 'delete',
					'html' => '',
				))) . '
						';
			}
		}
		$__finalCompiled .= $__templater->form('
					
					
				<div class="block-body">

					' . $__templater->dataList('
						' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		),
		array(
			'_type' => 'cell',
			'html' => 'Title',
		),
		array(
			'_type' => 'cell',
			'html' => 'Discussions',
		),
		array(
			'_type' => 'cell',
			'html' => 'Views',
		),
		array(
			'_type' => 'cell',
			'html' => 'Ratings',
		),
		array(
			'_type' => 'cell',
			'html' => 'Rating average',
		),
		array(
			'_type' => 'cell',
			'html' => 'Reviews',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
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
				<div class="block-footer block-footer--split">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['brands'], $__vars['total'], ), true) . '</span>
					<span class="block-footer-select">' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.dataList',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '</span>
					<span class="block-footer-controls">' . $__templater->button('', array(
			'type' => 'submit',
			'name' => 'quickdelete',
			'value' => '1',
			'icon' => 'delete',
		), '', array(
		)) . '</span>
				</div>
			', array(
			'action' => $__templater->func('link', array('bh_brand/quick-delete', ), false),
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
		'link' => 'bh_brand',
		'params' => $__vars['filters'],
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);