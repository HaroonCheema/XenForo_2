<?php
// FROM HASH: 541a70daf2c65143d36a6346f1af4e58
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Top performing packages');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped('Here you can see which packages perform the best based on click-through rate.');
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body block-row">
				<div class="inputGroup inputGroup--auto">
					<span>' . 'Order by' . $__vars['xf']['language']['label_separator'] . '
						' . $__templater->formSelect(array(
			'name' => 'order_field',
			'class' => 'input--inline',
			'value' => ($__vars['order']['field'] ?: 'avg_ctr'),
		), array(array(
			'value' => 'title',
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
			'value' => 'avg_ctr',
			'label' => 'Average CTR',
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
			'action' => $__templater->func('link', array('ads-manager/packages/top-performing', ), false),
			'class' => 'block',
		)) . '

	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['packages'])) {
			foreach ($__vars['packages'] AS $__vars['package']) {
				$__compilerTemp1 .= '
							' . $__templater->dataRow(array(
					'href' => $__templater->func('link', array('ads-manager/packages/edit', $__vars['package'], ), false),
					'label' => $__templater->escape($__vars['package']['title']),
					'delete' => $__templater->func('link', array('ads-manager/packages/delete', $__vars['package'], ), false),
					'dir' => 'auto',
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->func('sam_type_phrase', array($__vars['package']['type'], ), true),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['package']['ad_count']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['package']['total_views']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['package']['total_clicks']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('sam_get_ctr', array($__vars['package']['total_clicks'], $__vars['package']['total_views'], ), true) . '%',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['package']['avg_ctr']) . '%',
				),
				array(
					'width' => '5%',
					'class' => 'dataList-cell--separated',
					'_type' => 'cell',
					'html' => '
									' . $__templater->button('
										<i class="fa fa-cog" aria-hidden="true"></i>
									', array(
					'class' => 'button--link menuTrigger',
					'data-xf-click' => 'menu',
					'aria-label' => 'More options',
					'aria-expanded' => 'false',
					'aria-haspopup' => 'true',
				), '', array(
				)) . '
									<div class="menu" data-menu="menu" aria-hidden="true">
										<div class="menu-content">
											<a href="' . $__templater->func('link', array('ads-manager/packages/clone', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Clone' . '</a>
											<a href="' . $__templater->func('link', array('ads-manager/packages/embed', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
											<a href="' . $__templater->func('link', array('ads-manager/packages/export', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
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
			'html' => 'Package',
		),
		array(
			'_type' => 'cell',
			'html' => 'Type',
		),
		array(
			'_type' => 'cell',
			'html' => 'Total ads',
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
		),
		array(
			'_type' => 'cell',
			'html' => 'Average CTR',
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