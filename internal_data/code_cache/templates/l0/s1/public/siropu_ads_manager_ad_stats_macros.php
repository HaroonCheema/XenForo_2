<?php
// FROM HASH: 28187b3c8eaa44ec25bd5bb878302c11
return array(
'macros' => array('filter' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'link' => '!',
		'datePresets' => '!',
		'grouping' => true,
		'filters' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = array(array(
		'label' => 'Date presets' . $__vars['xf']['language']['label_separator'],
		'_type' => 'option',
	));
	$__compilerTemp1[] = array(
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
	$__compilerTemp1[$__compilerTemp2]['options'] = $__templater->mergeChoiceOptions($__compilerTemp1[$__compilerTemp2]['options'], $__vars['datePresets']);
	$__compilerTemp1[$__compilerTemp2]['options'][] = array(
		'value' => '1995-01-01',
		'label' => 'All time',
		'_type' => 'option',
	);
	$__compilerTemp3 = '';
	if ($__vars['grouping']) {
		$__compilerTemp3 .= '
						<span class="inputGroup-splitter"></span>
						' . $__templater->formSelect(array(
			'name' => 'grouping',
			'class' => 'input--autoSize',
			'value' => ($__vars['filters']['grouping'] ?: 'daily'),
		), array(array(
			'value' => 'hourly',
			'label' => 'Hourly',
			'_type' => 'option',
		),
		array(
			'value' => 'daily',
			'label' => 'Daily',
			'_type' => 'option',
		),
		array(
			'value' => 'monthly',
			'label' => 'Monthly',
			'_type' => 'option',
		))) . '
					';
	}
	$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body block-row">
				<div class="inputGroup inputGroup--auto">
					' . $__templater->formDateInput(array(
		'name' => 'start',
		'placeholder' => 'Since date...',
		'value' => ($__vars['filters']['start'] ? $__templater->func('date', array($__vars['filters']['start'], 'picker', ), false) : ''),
	)) . '
					<span class="inputGroup-text">-</span>
					' . $__templater->formDateInput(array(
		'name' => 'end',
		'placeholder' => 'Until date...',
		'value' => ($__vars['filters']['end'] ? $__templater->func('date', array($__vars['filters']['end'], 'picker', ), false) : ''),
	)) . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->formSelect(array(
		'name' => 'date_preset',
		'class' => 'input--autoSize',
		'value' => ($__vars['filters']['date_preset'] ? $__templater->func('date', array($__vars['filters']['date_preset'], 'picker', ), false) : ''),
	), $__compilerTemp1) . '
					' . $__compilerTemp3 . '
					<span class="inputGroup-splitter"></span>
					' . $__templater->button('Filter', array(
		'type' => 'submit',
	), '', array(
	)) . '
				</div>
			</div>
		</div>
	', array(
		'action' => $__vars['link'],
		'class' => 'block',
	)) . '
';
	return $__finalCompiled;
}
),
'totals' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ad' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
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
					' . $__templater->dataRow(array(
	), array(array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['ad']['view_count']),
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['ad']['click_count']),
	),
	array(
		'_type' => 'cell',
		'html' => $__templater->escape($__vars['ad']['ctr']) . '%',
	))) . '
				', array(
	)) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);