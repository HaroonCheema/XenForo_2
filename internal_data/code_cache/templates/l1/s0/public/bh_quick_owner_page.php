<?php
// FROM HASH: 4908156b816ed4ce2c7a622c346309ae
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Quick Owner-Page');
	$__finalCompiled .= '

';
	$__templater->includeCss('bh_select2.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('select2.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'prod' => 'xf/token_input-compiled.js',
		'dev' => 'vendor/select2/select2.full.js, xf/token_input.js',
	));
	$__finalCompiled .= '

';
	$__templater->inlineCss('
.quickContentBody{display:none;}
');
	$__finalCompiled .= '

	
	<div class="block-container">
		<div class="block-body">
			

			';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['brands'])) {
		foreach ($__vars['brands'] AS $__vars['brand']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['brand']['brand_id'],
				'label' => $__templater->escape($__vars['brand']['brand_title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'brand_id',
		'value' => '',
		'data-xf-init' => 'token-input-select',
	), $__compilerTemp1, array(
		'label' => 'Brand',
		'explain' => 'Select Brand (you can find Brand quickly by typing the name of the brand)',
	)) . '
			
			' . $__templater->formSelectRow(array(
		'name' => 'item_id',
		'value' => '',
		'data-xf-init' => 'token-input-select',
	), array(array(
		'value' => '',
		'label' => 'Select item',
		'_type' => 'option',
	)), array(
		'label' => 'Item',
		'explain' => 'Select Item (you can find Item quickly by typing the name of the item)',
	)) . '
			
		</div>
	</div>

	<!--[after selection]-->
	<div class="clearfix quickContentBody">
		<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
	</div>

';
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
			s2_no_results: "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), false) . '"
		});	
');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'BrandHub/quick_owner_page.js',
	));
	return $__finalCompiled;
}
);