<?php
// FROM HASH: 4e4ac983e07b916f31a63e24b3c5bef9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[advanced_mode]',
		'value' => '1',
		'selected' => $__vars['options']['advanced_mode'],
		'label' => 'Advanced mode',
		'hint' => 'If enabled, the HTML for your page will not be contained within a block.',
		'_type' => 'option',
	)), array(
	)) . '

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

' . $__templater->formTextBoxRow(array(
		'name' => 'options[image_width]',
		'value' => $__vars['options']['image_width'],
	), array(
		'label' => 'trakt_movies_image_width',
	)) . '
	
' . $__templater->formTextBoxRow(array(
		'name' => 'options[image_height]',
		'value' => $__vars['options']['image_height'],
	), array(
		'label' => 'trakt_movies_image_height',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[show_rating]',
		'value' => '1',
		'selected' => $__vars['options']['show_rating'],
		'label' => 'trakt_movies_show_rating',
		'_type' => 'option',
	)), array(
	)) . '

<h3 class="block-formSectionHeader">
	<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
		<span class="block-formSectionHeader-aligner">' . 'trakt_movies_slider_options' . '</span>
	</span>
</h3>

<div class="block-body block-body--collapsible is-active">
	' . $__templater->formNumberBoxRow(array(
		'name' => 'options[slider][items]',
		'value' => $__vars['options']['slider']['items'],
		'min' => '1',
	), array(
		'label' => 'trakt_movies_slider_items',
	)) . '
	
	<hr class="formRowSep" />
	
	' . $__templater->formRow('
		<div class="inputGroup">
			' . $__templater->formNumberBox(array(
		'name' => 'options[slider][itemsWide]',
		'value' => $__vars['options']['slider']['itemsWide'],
		'min' => '1',
	)) . '

			<span class="inputGroup-text">' . 'trakt_movies_breakpoint:' . '</span>
			' . $__templater->formNumberBox(array(
		'name' => 'options[slider][breakpointWide]',
		'value' => $__vars['options']['slider']['breakpointWide'],
		'min' => '1',
	)) . '
			<span class="inputGroup-text">' . 'Pixels' . '</span>
		</div>
	', array(
		'rowtype' => 'input',
		'label' => 'trakt_movies_slider_items_items_wide',
	)) . '

	' . $__templater->formRow('
		<div class="inputGroup">
			' . $__templater->formNumberBox(array(
		'name' => 'options[slider][itemsMedium]',
		'value' => $__vars['options']['slider']['itemsMedium'],
		'min' => '1',
	)) . '

			<span class="inputGroup-text">' . 'trakt_movies_breakpoint:' . '</span>
			' . $__templater->formNumberBox(array(
		'name' => 'options[slider][breakpointMedium]',
		'value' => $__vars['options']['slider']['breakpointMedium'],
		'min' => '1',
	)) . '
			<span class="inputGroup-text">' . 'Pixels' . '</span>
		</div>
	', array(
		'rowtype' => 'input',
		'label' => 'trakt_movies_slider_items_items_medium',
	)) . '
	
	<hr class="formRowSep" />

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
	)) . '
</div>';
	return $__finalCompiled;
}
);