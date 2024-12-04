<?php
// FROM HASH: 5a73cae8bb2e193544e046c662c04a74
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'Purchase access to' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['thread']['title']) . '
');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'You are about to purchase access to the thread "' . $__templater->escape($__vars['thread']['title']) . '" for one credit. You currently have ' . $__templater->escape($__vars['xf']['visitor']['thtc_credits_cache']) . ' credits available.' . '
			', array(
	)) . '
		</div>

		' . $__templater->formSubmitRow(array(
		'icon' => 'purchase',
	), array(
	)) . '
	</div>
', array(
		'class' => 'block',
		'action' => $__templater->func('link', array('threads/thtc-pay', $__vars['thread'], array('page' => $__vars['page'], ), ), false),
	));
	return $__finalCompiled;
}
);