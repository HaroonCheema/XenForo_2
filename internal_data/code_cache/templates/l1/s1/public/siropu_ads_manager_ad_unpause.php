<?php
// FROM HASH: e907b7f55c94ed6158755465d1fe2f33
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Unpause ad' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['ad']['name']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Are you sure you want to unpause the ad?' . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Unpause',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/unpause', $__vars['ad'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);