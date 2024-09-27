<?php
// FROM HASH: d270471ccaeb5e88dee24c4a24b9e747
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['prefixesGrouped'], 'empty', array())) {
		$__compilerTemp1 .= '
				' . $__templater->callMacro('prefix_macros', 'select', array(
			'prefixes' => $__vars['prefixesGrouped'],
			'type' => 'resource',
			'selected' => ($__vars['filters']['prefix_id'] ?: 0),
			'name' => 'prefix_id',
			'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
		), $__vars) . '
			';
	}
	$__finalCompiled .= $__templater->form('

	<div class="menu-row menu-row--separated">
		<div class="inputGroup u-inputSpacer">

			' . '
			' . $__templater->formSelect(array(
		'name' => 'type',
		'value' => $__vars['filters']['type'],
	), array(array(
		'value' => '',
		'label' => 'Any',
		'_type' => 'option',
	),
	array(
		'value' => 'free',
		'label' => 'Free',
		'_type' => 'option',
	),
	array(
		'value' => 'paid',
		'label' => 'Paid',
		'_type' => 'option',
	))) . '
			<span class="inputGroup-splitter"></span>

			' . '
			' . $__compilerTemp1 . '
			<span class="inputGroup-splitter"></span>

			' . '
			' . $__templater->formTextBox(array(
		'name' => 'creator',
		'value' => ($__vars['creatorFilter'] ? $__vars['creatorFilter']['username'] : ''),
		'ac' => 'single',
	)) . '
			<span class="inputGroup-splitter"></span>

			' . '
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['filters']['order'] ?: $__vars['xf']['options']['xfrmListDefaultOrder']),
	), array(array(
		'value' => 'last_update',
		'label' => 'Last update',
		'_type' => 'option',
	),
	array(
		'value' => 'resource_date',
		'label' => 'Submission date',
		'_type' => 'option',
	),
	array(
		'value' => 'rating_weighted',
		'label' => 'Rating',
		'_type' => 'option',
	),
	array(
		'value' => 'download_count',
		'label' => 'Downloads',
		'_type' => 'option',
	),
	array(
		'value' => 'title',
		'label' => 'Title',
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

			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</div>
	</div>

	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array(($__vars['category'] ? 'resources/categories/filters' : 'resources/filters'), $__vars['category'], ), false),
	));
	return $__finalCompiled;
}
);