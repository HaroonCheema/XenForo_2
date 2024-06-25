<?php
// FROM HASH: e44eee3a535e35bc2b41321de71c3641
return array(
'macros' => array('search_gifted_content' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['__globals']['nfSupportsGifts']) {
		$__finalCompiled .= '
		';
		$__vars['showGiftCategoriesBlock'] = !$__templater->test($__vars['__globals']['nfGiftCategories'], 'empty', array());
		$__finalCompiled .= '
		<li>
			' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'c[gifts_only]',
			'selected' => $__vars['input']['c']['gifts_only'],
			'label' => 'Search gifted content only',
			'data-xf-init' => ($__vars['showGiftCategoriesBlock'] ? 'disabler' : ''),
			'data-container' => ($__vars['showGiftCategoriesBlock'] ? '.js-nfGiftLimitedInputs' : ''),
			'data-hide' => 'true',
			'_type' => 'option',
		))) . '
		</li>

		';
		if ($__vars['showGiftCategoriesBlock']) {
			$__finalCompiled .= '
			<li class="js-nfGiftLimitedInputs">
				' . $__templater->formCheckBox(array(
				'standalone' => 'true',
			), array(array(
				'name' => 'c[in_gift_categories]',
				'selected' => $__vars['input']['c']['in_gift_categories'],
				'label' => 'In gift categories…' . $__vars['xf']['language']['ellipsis'],
				'data-xf-init' => 'disabler',
				'data-container' => '.js-giftCategoriesContainer',
				'data-hide' => 'true',
				'_type' => 'option',
			))) . '
			</li>

			<li class="js-giftCategoriesContainer">
				';
			$__compilerTemp1 = array();
			if ($__templater->isTraversable($__vars['__globals']['nfGiftCategories'])) {
				foreach ($__vars['__globals']['nfGiftCategories'] AS $__vars['giftCategory']) {
					$__compilerTemp1[] = array(
						'value' => $__vars['giftCategory']['gift_category_id'],
						'label' => $__templater->escape($__vars['giftCategory']['title']),
						'_type' => 'option',
					);
				}
			}
			$__finalCompiled .= $__templater->formSelect(array(
				'name' => 'c[gift_categories]',
				'multiple' => 'multiple',
				'value' => $__vars['input']['c']['gift_categories'],
			), $__compilerTemp1) . '
			</li>
		';
		}
		$__finalCompiled .= '
		
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);