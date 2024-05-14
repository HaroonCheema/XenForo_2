<?php
// FROM HASH: eda4e2b0cf838d8d295f71050a9d0603
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('
	<div class="inputPair">
		' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[order]',
		'value' => $__vars['option']['option_value']['order'],
		'class' => 'input--inline',
	), array(array(
		'value' => 'view_count',
		'label' => 'Views',
		'_type' => 'option',
	),
	array(
		'value' => 'reply_count',
		'label' => 'Replies',
		'_type' => 'option',
	),
	array(
		'value' => 'post_date',
		'label' => 'Post date',
		'_type' => 'option',
	))) . '
		' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[direction]',
		'value' => $__vars['option']['option_value']['direction'],
		'class' => 'input--inline',
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
	</div>
', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);