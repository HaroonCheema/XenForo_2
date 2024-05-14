<?php
// FROM HASH: 32355286829a1078ebcf09f61086ff4b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
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
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_can_assignThreadsToHub', ))) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = array(array(
			'value' => '0',
			'selected' => !$__vars['thread']['item_id'],
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
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => 'item_id',
			'value' => $__vars['thread']['item_id'],
			'data-xf-init' => 'token-input-select',
		), $__compilerTemp1, array(
			'label' => 'Item',
			'explain' => 'Select item to assign this thread. (you can find item quickly by typing the name of item)',
		)) . '
';
	}
	$__finalCompiled .= '

';
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
			s2_no_results: "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), false) . '"
		});	
');
	return $__finalCompiled;
}
);