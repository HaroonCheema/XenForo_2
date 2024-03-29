<?php
// FROM HASH: 32b96130d479e0b529c2b15be81523d1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Thread link to BrandHub (Inline moderation)');
	$__finalCompiled .= '

';
	$__templater->includeCss('select2.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('bh_select2.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'prod' => 'xf/token_input-compiled.js',
		'dev' => 'vendor/select2/select2.full.js, xf/token_input.js',
	));
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'selected' => !$__vars['selectedItem'],
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['items'])) {
		foreach ($__vars['items'] AS $__vars['item']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['item']['item_id'],
				'label' => $__templater->escape($__vars['item']['item_title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['threads'])) {
		foreach ($__vars['threads'] AS $__vars['thread']) {
			$__compilerTemp2 .= '
		' . $__templater->formHiddenVal('ids[]', $__vars['thread']['thread_id'], array(
			)) . '
	';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('Are you sure you want to assign the Item specified below to the ' . $__templater->escape($__vars['total']) . ' selected threads?', array(
		'rowtype' => 'confirm',
	)) . '

			' . $__templater->formSelectRow(array(
		'name' => 'item_id',
		'value' => $__vars['selectedItem'],
		'data-xf-init' => 'token-input-select',
	), $__compilerTemp1, array(
		'label' => 'Item',
		'explain' => 'Select item to assign this thread. (you can find item quickly by typing the name of item)',
	)) . '
			
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
	)) . '
	</div>

	' . $__compilerTemp2 . '

	' . $__templater->formHiddenVal('type', 'thread', array(
	)) . '
	' . $__templater->formHiddenVal('action', 'link_to_brand_hub', array(
	)) . '
	' . $__templater->formHiddenVal('confirmed', '1', array(
	)) . '

	' . $__templater->func('redirect_input', array($__vars['redirect'], null, true)) . '
', array(
		'action' => $__templater->func('link', array('inline-mod', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

';
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
			s2_no_results: "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), false) . '"
		});	
');
	return $__finalCompiled;
}
);