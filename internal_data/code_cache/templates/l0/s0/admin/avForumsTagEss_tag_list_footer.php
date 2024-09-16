<?php
// FROM HASH: abb8f801d68c889366c94144b80543f5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-footer block-footer--split">
	<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['tags'], $__vars['total'], ), true) . '</span>
	
	<span class="block-footer-select">
		' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'check-all' => '< .block-container',
		'label' => 'Select all',
		'_type' => 'option',
	))) . '
	</span>
	
	<span class="block-footer-controls">
		' . $__templater->formSelect(array(
		'name' => 'state',
		'class' => 'input--inline',
		'style' => 'font-family: \'Font Awesome 5 Pro\',\'FontAwesome\';',
	), array(array(
		'label' => 'With selected' . $__vars['xf']['language']['ellipsis'],
		'_type' => 'option',
	),
	array(
		'value' => 'blacklist_tags',
		'label' => '&#xf05e; ' . 'Blacklist',
		'_type' => 'option',
	),
	array(
		'value' => 'delete',
		'label' => '&#xf1f8; ' . 'Delete',
		'_type' => 'option',
	))) . '
		' . $__templater->button('Go', array(
		'type' => 'submit',
	), '', array(
	)) . '
	</span>
</div>';
	return $__finalCompiled;
}
);