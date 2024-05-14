<?php
// FROM HASH: 8ae79915237e85502ac720d288494fa7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['items'])) {
		foreach ($__vars['items'] AS $__vars['itemId'] => $__vars['item']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['itemId'],
				'checked' => 'checked',
				'label' => '<span class="">' . $__templater->escape($__vars['item']['item_title']) . '</span>',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
					' . 'Please confirm that you want to delete the following selected Items' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		
			' . $__templater->formCheckBoxRow(array(
		'name' => 'item_ids',
		'listclass' => 'inputChoices--inline',
	), $__compilerTemp1, array(
		'label' => 'These Items will be deleted',
		'explain' => 'you can deselect from these if you don\'t want to delete them',
	)) . '


		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>

', array(
		'action' => $__templater->func('link', array('bh_item/quick-delete', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);