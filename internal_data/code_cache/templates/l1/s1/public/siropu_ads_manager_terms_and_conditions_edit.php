<?php
// FROM HASH: 23cfba64993a3a48c8584a28c4f80ef5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit terms and conditions');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'value' => $__vars['xf']['options']['siropuAdsManagerTermsAndConditions'],
	), array(
		'rowtype' => 'fullWidth noLabel',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/terms-and-conditions/edit', ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);