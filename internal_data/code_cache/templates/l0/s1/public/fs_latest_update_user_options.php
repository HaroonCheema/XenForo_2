<?php
// FROM HASH: 88f18aaa524f49f0c809a7deac06334d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Options' . ' ');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body js-prefixListenContainer">

			' . $__templater->formRadioRow(array(
		'name' => 'tile_layout',
		'value' => $__vars['xf']['visitor']['tile_layout'],
	), array(array(
		'value' => 'grid',
		'label' => '<i class="fas fa-th" ></i>',
		'_type' => 'option',
	),
	array(
		'value' => 'girdLg',
		'label' => '<i class="fas fa-th-large" ></i>',
		'_type' => 'option',
	),
	array(
		'value' => 'list',
		'label' => '<i class="fas fa-list" ></i>',
		'_type' => 'option',
	)), array(
		'label' => 'Tile layout',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'new_tab',
		'value' => $__vars['xf']['visitor']['new_tab'],
	), array(array(
		'value' => 'yes',
		'label' => 'Yes',
		'_type' => 'option',
	),
	array(
		'value' => 'no',
		'label' => 'No',
		'_type' => 'option',
	)), array(
		'label' => 'Open links in new tab',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'filter_sidebar',
		'value' => $__vars['xf']['visitor']['filter_sidebar'],
	), array(array(
		'value' => 'normal',
		'label' => 'Normal',
		'_type' => 'option',
	),
	array(
		'value' => 'sticky',
		'label' => 'Sticky',
		'_type' => 'option',
	)), array(
		'label' => 'Filter sidebar',
	)) . '

			' . $__templater->formRadioRow(array(
		'name' => 'version_style',
		'value' => $__vars['xf']['visitor']['version_style'],
	), array(array(
		'value' => 'small',
		'label' => 'Small (Prefix)',
		'_type' => 'option',
	),
	array(
		'value' => 'large',
		'label' => 'Large (Title)',
		'_type' => 'option',
	)), array(
		'label' => 'Version style',
	)) . '

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('latest-contents/options', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);