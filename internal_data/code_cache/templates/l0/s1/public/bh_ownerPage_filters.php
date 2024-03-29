<?php
// FROM HASH: 197d951d31632d3dc55ecda258c78b53
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['defaultOrder'] = '$xf.options.bh_ownerPageDefaultOrder|split';
	$__finalCompiled .= $__templater->form('
	
	' . '' . '
	
	<!--[brandHub:above_sort_by]-->
	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['filters']['order'] ?: $__vars['defaultOrder']['0']),
	), array(array(
		'value' => 'page_id',
		'label' => 'Page id',
		'_type' => 'option',
	),
	array(
		'value' => 'view_count',
		'label' => 'Views',
		'_type' => 'option',
	),
	array(
		'value' => 'discussion_count',
		'label' => 'Discussions',
		'_type' => 'option',
	),
	array(
		'value' => 'reaction_score',
		'label' => 'Reaction Score',
		'_type' => 'option',
	))) . '
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
		'action' => $__templater->func('link', array($__vars['route'], $__vars['content'], ), false),
	));
	return $__finalCompiled;
}
);