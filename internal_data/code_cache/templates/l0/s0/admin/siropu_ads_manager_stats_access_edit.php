<?php
// FROM HASH: fa93af4bf1e03754ffe581c8880c6387
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['statsAccess'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add stats access');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit stats access' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['statsAccess']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['statsAccess'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ads-manager/stats-access/delete', $__vars['statsAccess'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['ads']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['statsAccess']['title'],
	), array(
		'label' => 'Title',
		'explain' => 'This title will be made public to the advertiser.',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'ad_list',
		'value' => $__vars['statsAccess']['ad_list'],
		'multiple' => 'true',
	), $__compilerTemp1, array(
		'label' => 'Ads',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/stats-access/save', $__vars['statsAccess'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);