<?php
// FROM HASH: 1cbcbbd0a7e50f7ace79ee23a7484f55
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['brand'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Brand');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Brand' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['brand']['brand_title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '





';
	$__compilerTemp1 = '';
	if ($__vars['brand']['Description']) {
		$__compilerTemp1 .= '
				' . $__templater->formHiddenVal('descriptionId', $__vars['brand']['Description']['desc_id'], array(
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			
			' . $__templater->formEditorRow(array(
		'name' => 'description',
		'value' => $__vars['brand']['Description']['description'],
		'data-min-height' => '200',
	), array(
		'label' => 'Description',
	)) . '

			' . $__compilerTemp1 . '
			
		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array($__vars['xf']['options']['bh_main_route'] . '/save', $__vars['brand'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);