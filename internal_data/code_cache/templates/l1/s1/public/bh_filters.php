<?php
// FROM HASH: d1dbf49ebc6df1fcb13d772133f49ce1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array();
	if ($__vars['brand']) {
		$__compilerTemp1[] = array(
			'value' => 'item_id',
			'label' => 'Item id',
			'_type' => 'option',
		);
		$__compilerTemp1[] = array(
			'value' => 'item_title',
			'label' => 'Title',
			'_type' => 'option',
		);
	} else {
		$__compilerTemp1[] = array(
			'value' => 'brand_id',
			'label' => 'Brand id',
			'_type' => 'option',
		);
		$__compilerTemp1[] = array(
			'value' => 'brand_title',
			'label' => 'Title',
			'_type' => 'option',
		);
	}
	$__compilerTemp1[] = array(
		'value' => 'discussion_count',
		'label' => 'Discussions',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'view_count',
		'label' => 'Views',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'rating_avg',
		'label' => 'Rating average',
		'_type' => 'option',
	);
	$__compilerTemp1[] = array(
		'value' => 'review_count',
		'label' => 'Reviews',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->form('
	
	<!--[brandHub:above_sort_by]-->
	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['filters']['order'] ?: $__vars['xf']['options']['bh_ListDefaultOrder']),
	), $__compilerTemp1) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formSelect(array(
		'name' => 'direction',
		'value' => ($__vars['filters']['direction'] ?: 'desc'),
	), array(array(
		'value' => 'desc',
		'label' => 'Descending',
		'_type' => 'option',
	),
	array(
		'value' => 'asc',
		'label' => 'Ascending',
		'_type' => 'option',
	))) . '
		</div>
	</div>

	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
	</div>
	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array($__vars['route'], $__vars['brand'], ), false),
	));
	return $__finalCompiled;
}
);