<?php
// FROM HASH: 19c9ba611b27a5f3c800721cf32d09af
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formRadioRow(array(
		'name' => 'options[order]',
		'value' => $__vars['options']['order'],
	), array(array(
		'value' => 'latest',
		'label' => 'trakt_movies_latest_movies',
		'_type' => 'option',
	),
	array(
		'value' => 'rating',
		'label' => 'trakt_movies_most_rated_movies',
		'_type' => 'option',
	),
	array(
		'value' => 'random',
		'label' => 'trakt_movies_random_movies',
		'_type' => 'option',
	),
	array(
		'value' => 'last_post_date',
		'label' => 'Last reply date',
		'_type' => 'option',
	)), array(
		'label' => 'Display order',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'All forums',
		'_type' => 'option',
	));
	$__compilerTemp2 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['treeEntry']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'Forum'),
				'label' => '
			' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
		',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[node_ids][]',
		'value' => ($__vars['options']['node_ids'] ?: ''),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp1, array(
		'label' => 'Forum limit',
		'explain' => 'Only include threads in the selected forums.',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[show_plot]',
		'value' => '1',
		'selected' => $__vars['options']['show_plot'],
		'label' => 'trakt_movies_plot',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_genres]',
		'value' => '1',
		'selected' => $__vars['options']['show_genres'],
		'label' => 'trakt_movies_genre',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_director]',
		'value' => '1',
		'selected' => $__vars['options']['show_director'],
		'label' => 'trakt_movies_director',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_cast]',
		'value' => '1',
		'selected' => $__vars['options']['show_cast'],
		'label' => 'trakt_movies_cast',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_status]',
		'value' => '1',
		'selected' => $__vars['options']['show_status'],
		'label' => 'trakt_movies_status',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_release_date]',
		'value' => '1',
		'selected' => $__vars['options']['show_release_date'],
		'label' => 'trakt_movies_release',
		'_type' => 'option',
	),
	array(
		'name' => 'options[show_runtime]',
		'value' => '1',
		'selected' => $__vars['options']['show_runtime'],
		'label' => 'trakt_movies_runtime',
		'_type' => 'option',
	)), array(
		'label' => 'trakt_movies_slider_widget_shown_elements',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[slider][auto]',
		'value' => '1',
		'selected' => $__vars['options']['slider']['auto'],
		'label' => 'trakt_movies_slider_auto_play',
		'data-hide' => 'true',
		'_dependent' => array('
			' . $__templater->formNumberBox(array(
		'name' => 'options[slider][pause]',
		'value' => $__vars['options']['slider']['pause'],
		'min' => '1',
	)) . '
			<p class="formRow-explain">' . 'trakt_movies_slider_pause' . '</p>
		'),
		'_type' => 'option',
	),
	array(
		'name' => 'options[slider][controls]',
		'value' => '1',
		'selected' => $__vars['options']['slider']['controls'],
		'label' => 'trakt_movies_slider_controls',
		'_type' => 'option',
	),
	array(
		'name' => 'options[slider][pauseOnHover]',
		'selected' => $__vars['options']['slider']['pauseOnHover'],
		'label' => 'trakt_movies_slider_pause_on_hover',
		'_type' => 'option',
	),
	array(
		'name' => 'options[slider][loop]',
		'selected' => $__vars['options']['slider']['loop'],
		'label' => 'trakt_movies_slider_loop_slides',
		'_type' => 'option',
	),
	array(
		'name' => 'options[slider][pager]',
		'selected' => $__vars['options']['slider']['pager'],
		'label' => 'trakt_movies_slider_pager',
		'_type' => 'option',
	)), array(
		'label' => 'trakt_tv_slider_options',
	));
	return $__finalCompiled;
}
);