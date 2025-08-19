<?php
// FROM HASH: dbf529449caece0eb5969f8d5e3fecfb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to deblock the following IP' . $__vars['xf']['language']['label_separator'] . '
				<strong>' . $__templater->escape($__vars['ip']) . '</strong>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/ads/deblock-ip', $__vars['ad'], array('ip' => $__vars['ip'], 'return' => $__vars['return'], ), ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);