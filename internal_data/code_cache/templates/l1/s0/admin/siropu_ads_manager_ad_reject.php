<?php
// FROM HASH: 026a48e5480dac11f565fb56a0b408a2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reject ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextAreaRow(array(
		'name' => 'reject_reason',
	), array(
		'label' => 'Reject reason',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Reject',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/reject', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);