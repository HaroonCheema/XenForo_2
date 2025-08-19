<?php
// FROM HASH: a8cf4f337bc72d074fc43f960aac98fa
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Top performing positions');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Here you can see which positions perform the best based on click-through rate. In order to see positions here, ads must have daily statistics enabled.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['positions'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body block-row">
				<div class="inputGroup inputGroup--auto">
					<span>' . 'Order by' . $__vars['xf']['language']['label_separator'] . '
						' . $__templater->formSelect(array(
			'name' => 'order_field',
			'class' => 'input--inline',
			'value' => ($__vars['order']['field'] ?: 'ctr'),
		), array(array(
			'value' => 'p.title',
			'label' => 'Name',
			'_type' => 'option',
		),
		array(
			'value' => 'total_views',
			'label' => $__templater->func('sam_views_impressions_phrase', array(), true),
			'_type' => 'option',
		),
		array(
			'value' => 'total_clicks',
			'label' => 'Clicks',
			'_type' => 'option',
		),
		array(
			'value' => 'ctr',
			'label' => 'CTR',
			'_type' => 'option',
		))) . '

						' . $__templater->formSelect(array(
			'name' => 'order_direction',
			'class' => 'input--inline',
			'value' => ($__vars['order']['direction'] ?: 'desc'),
		), array(array(
			'value' => 'asc',
			'label' => 'Ascending',
			'_type' => 'option',
		),
		array(
			'value' => 'desc',
			'label' => 'Descending',
			'_type' => 'option',
		))) . '

						' . $__templater->button('', array(
			'type' => 'submit',
			'button' => 'Go',
		), '', array(
		)) . '
					</span>
				</div>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/positions/top-performing', ), false),
			'class' => 'block',
		)) . '

	<div class="block">
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'top-performing',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>

		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['positions'])) {
			foreach ($__vars['positions'] AS $__vars['position']) {
				$__compilerTemp1 .= '
							' . $__templater->dataRow(array(
					'href' => $__templater->func('link', array('ads-manager/positions/edit', $__vars['position'], ), false),
					'label' => $__templater->escape($__vars['position']['title']),
					'dir' => 'auto',
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['position']['total_views']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['position']['total_clicks']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['position']['ctr']) . '%',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Position',
		),
		array(
			'_type' => 'cell',
			'html' => $__templater->func('sam_total_views_impressions_phrase', array(), true),
		),
		array(
			'_type' => 'cell',
			'html' => 'Total clicks',
		),
		array(
			'_type' => 'cell',
			'html' => 'CTR',
		))) . '
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No entries have been logged.' . '</div>
';
	}
	return $__finalCompiled;
}
);