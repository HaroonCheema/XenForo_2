<?php
// FROM HASH: 93f1930386354a078d2d1690f3e1022c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['brands'])) {
		foreach ($__vars['brands'] AS $__vars['brandId'] => $__vars['brand']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['brandId'],
				'checked' => 'checked',
				'label' => '<span class="">' . $__templater->escape($__vars['brand']['brand_title']) . '</span>',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following selected brands' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		
			' . $__templater->formCheckBoxRow(array(
		'name' => 'brand_ids',
		'listclass' => 'inputChoices--inline',
	), $__compilerTemp1, array(
		'label' => 'These Brands will be deleted',
		'explain' => 'you can deselect from these if you don\'t want to delete them',
	)) . '


		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

', array(
		'action' => $__templater->func('link', array('bh_brand/quick-delete', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);