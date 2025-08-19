<?php
// FROM HASH: 5df846f368fc94c16f17326388a6f08c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'selected' => $__vars['option']['option_value']['enabled'],
		'data-hide' => 'true',
		'label' => $__templater->escape($__vars['option']['title']),
		'_dependent' => array('
			<div class="inputGroup inputGroup--auto">
				<div class="inputChoices-spacer">' . 'Ad display order' . $__vars['xf']['language']['label_separator'] . '</div>
				<span class="inputGroup-splitter"></span>
				<div class="inputGroup">
					' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[order]',
		'value' => $__vars['option']['option_value']['order'],
	), array(array(
		'value' => 'random',
		'label' => 'Random',
		'_type' => 'option',
	),
	array(
		'value' => 'dateAsc',
		'label' => 'Ascending by ad creation date',
		'_type' => 'option',
	),
	array(
		'value' => 'dateDesc',
		'label' => 'Descending by ad creation date',
		'_type' => 'option',
	),
	array(
		'value' => 'orderAsc',
		'label' => 'Ascending by ad display order',
		'_type' => 'option',
	),
	array(
		'value' => 'orderDesc',
		'label' => 'Descending by ad display order',
		'_type' => 'option',
	),
	array(
		'value' => 'viewAsc',
		'label' => 'Ascending by ad view count',
		'_type' => 'option',
	),
	array(
		'value' => 'viewDesc',
		'label' => 'Descending by ad view count',
		'_type' => 'option',
	),
	array(
		'value' => 'clickAsc',
		'label' => 'Ascending by ad click count',
		'_type' => 'option',
	),
	array(
		'value' => 'clickDesc',
		'label' => 'Descending by ad click count',
		'_type' => 'option',
	),
	array(
		'value' => 'ctrAsc',
		'label' => 'Ascending by ad CTR (click-through rate)',
		'_type' => 'option',
	),
	array(
		'value' => 'ctrDesc',
		'label' => 'Descending by ad CTR (click-through rate)',
		'_type' => 'option',
	))) . '
				</div>
			</div>
		'),
		'_type' => 'option',
	)), array(
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['option']['explain']),
		'html' => '
		' . $__templater->escape($__vars['listedHtml']) . '
	',
	));
	return $__finalCompiled;
}
);