<?php
// FROM HASH: 8b4a8e71dabc8f1302467695dda2cde0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Link');
	$__finalCompiled .= '

';
	$__templater->inlineJs('
	$(function()
	{
		setTimeout(function()
		{
			$(\'#accessLink\').select();
		}, 500);
	});
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'value' => $__templater->func('link_type', array('public', 'canonical:ads-manager/statistics', $__vars['statsAccess'], ), false),
		'id' => 'accessLink',
	), array(
		'label' => 'Stats access key link',
		'explain' => 'Send this link to your advertiser to grant statistics access for selected ads.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
	), array(
		'html' => '
				' . $__templater->button('Okay', array(
		'href' => $__templater->func('link', array('ads-manager/tools/stats-access', ), false),
		'icon' => 'confirm',
	), '', array(
	)) . '
				' . $__templater->button('Edit', array(
		'href' => $__templater->func('link', array('ads-manager/stats-access/edit', $__vars['statsAccess'], ), false),
		'icon' => 'edit',
	), '', array(
	)) . '
			',
	)) . '
	</div>
</div>';
	return $__finalCompiled;
}
);