<?php
// FROM HASH: d5aa1c480d2921eb3cfd166b2022357f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->form('

	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			<span class="u-srOnly" id="ctrl_sort_by">' . 'Sort order' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['conditions']['order'] ?: 'thread_title'),
		'aria-labelledby' => 'ctrl_sort_by',
	), array(array(
		'value' => 'thread_title',
		'label' => 'Thread title',
		'_type' => 'option',
	),
	array(
		'value' => 'credits_spent',
		'label' => 'Credits',
		'_type' => 'option',
	),
	array(
		'value' => 'purchased_at',
		'label' => 'Date',
		'_type' => 'option',
	))) . '
			<span class="inputGroup-splitter"></span>
			<span class="u-srOnly" id="ctrl_sort_direction">' . 'Sort direction' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'direction',
		'value' => ($__vars['conditions']['direction'] ?: 'desc'),
		'aria-labelledby' => 'ctrl_sort_direction',
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
	' . $__templater->formHiddenVal('search', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('thread-credits-log', ), false),
	));
	return $__finalCompiled;
}
);