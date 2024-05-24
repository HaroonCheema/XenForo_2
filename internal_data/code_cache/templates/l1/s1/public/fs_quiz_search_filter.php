<?php
// FROM HASH: 31a2fcefd2aec1d285a47ff756171cd9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'selected' => true,
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['cat']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['cat']['category_id'],
				'label' => $__templater->escape($__vars['cat']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="menu-row menu-row--separated">
		' . 'Quiz Status' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'fs_quiz_status',
		'value' => $__vars['conditions']['fs_quiz_status'],
	), array(array(
		'value' => 'all',
		'selected' => true,
		'label' => 'All',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'Active',
		'_type' => 'option',
	),
	array(
		'value' => '0',
		'label' => 'Expired',
		'_type' => 'option',
	))) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'By Category' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'fs_quiz_cat',
		'value' => $__vars['conditions']['fs_quiz_cat'],
	), $__compilerTemp1) . '
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

	' . $__templater->formHiddenVal('search', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('quiz', ), false),
	));
	return $__finalCompiled;
}
);