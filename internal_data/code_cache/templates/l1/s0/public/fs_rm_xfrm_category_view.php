<?php
// FROM HASH: 12ab222966db19b73d817713ea7e5236
return array(
'macros' => array('simple_list_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'categoryTree' => '!',
		'parentCategory' => '!',
		'categoryExtras' => '!',
		'selected' => 0,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['categoryTree'], 'count', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'simple_category_list', array(
			'children' => $__vars['categoryTree'],
			'extras' => $__vars['categoryExtras'],
			'parentCategory' => $__vars['parentCategory'],
			'isActive' => true,
			'selected' => $__vars['selected'],
			'pathToSelected' => ($__vars['selected'] ? $__templater->method($__vars['categoryTree'], 'getPathTo', array($__vars['selected'], )) : array()),
		), $__vars) . '
		';
	} else {
		$__finalCompiled .= '
		<div class="block-row">' . 'N/A' . '</div>
	';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
),
'simple_category_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'selected' => '0',
		'pathToSelected' => array(),
		'parentCategory' => '!',
		'children' => '!',
		'extras' => '!',
		'isActive' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->isTraversable($__vars['children'])) {
		foreach ($__vars['children'] AS $__vars['id'] => $__vars['child']) {
			$__finalCompiled .= '
		' . $__templater->callMacro(null, 'simple_category_list_item', array(
				'selected' => $__vars['selected'],
				'pathToSelected' => $__vars['pathToSelected'],
				'parentCategory' => $__vars['parentCategory'],
				'category' => $__vars['child']['record'],
				'extras' => $__vars['extras'][$__vars['id']],
				'children' => $__vars['child'],
				'childExtras' => $__vars['extras'],
			), $__vars) . '
	';
		}
	}
	$__finalCompiled .= '
	' . '
';
	return $__finalCompiled;
}
),
'simple_category_list_item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'selected' => '!',
		'pathToSelected' => array(),
		'category' => '!',
		'parentCategory' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['isSelected'] = ($__vars['category']['resource_category_id'] == $__vars['selected']);
	$__finalCompiled .= '
	';
	$__vars['hasPathToSelected'] = $__vars['pathToSelected'][$__vars['category']['resource_category_id']];
	$__finalCompiled .= '
	';
	$__vars['isActive'] = ($__vars['isSelected'] OR ($__vars['hasPathToSelected'] AND !$__templater->test($__vars['children'], 'empty', array())));
	$__finalCompiled .= '

	';
	if ($__vars['parentCategory']['resource_category_id'] == $__vars['category']['parent_category_id']) {
		$__finalCompiled .= '
		<div class="responsive-div" style="background-image: url(' . ($__templater->method($__vars['category'], 'getCatImage', array()) ? $__templater->escape($__templater->method($__vars['category'], 'getCatImage', array())) : $__templater->escape($__vars['xf']['options']['fs_rm_bg_img'])) . '); width: ' . $__templater->escape($__vars['xf']['options']['fs_rm_bg_width']) . '; height: ' . $__templater->escape($__vars['xf']['options']['fs_rm_bg_size']) . ';">
			<a href="' . $__templater->func('link', array('resources/categories', $__vars['category'], ), true) . '" class="categoryList-link' . ($__vars['isSelected'] ? ' is-selected' : '') . '">
				' . $__templater->escape($__vars['category']['title']) . '
			</a>
		</div>
	';
	}
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['children'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro(null, 'simple_category_list', array(
			'selected' => $__vars['selected'],
			'pathToSelected' => $__vars['pathToSelected'],
			'children' => $__vars['children'],
			'parentCategory' => $__vars['parentCategory'],
			'extras' => $__vars['childExtras'],
			'isActive' => $__vars['isActive'],
		), $__vars) . '
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['category']['title']));
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->filter($__vars['category']['description'], array(array('raw', array()),), true));
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('fs_rm_cat_style_grid_css.less');
	$__finalCompiled .= '

<style>

	.containerRm {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-around;
	}

	.responsive-div {
		background-size: cover;
		background-position: center;
		margin: 10px;
		display: flex;
		justify-content: center;
		align-items: center;
		color: white;
		font-size: 20px;
		text-align: center;
		background-color: rgba(0, 0, 0, 0.5); /* Fallback color if image doesn\'t load */
	}

	@media (max-width: 768px) {
		.responsive-div {
			width: 100% !important; /* Full width on small screens */
		}
	}

</style>

<div class="containerRm">

	' . $__templater->callMacro(null, 'simple_list_block', array(
		'categoryTree' => $__vars['categoryTree'],
		'categoryExtras' => $__vars['categoryExtras'],
		'parentCategory' => $__vars['category'],
	), $__vars) . '

</div>


' . $__templater->callMacro('metadata_macros', 'canonical_url', array(
		'canonicalUrl' => $__templater->func('link', array('canonical:resources/categories', $__vars['category'], array('page' => (($__vars['page'] > 1) ? $__vars['page'] : null), ), ), false),
	), $__vars) . '

';
	$__templater->breadcrumbs($__templater->method($__vars['category'], 'getBreadcrumbs', array(false, )));
	$__finalCompiled .= '

' . $__templater->callMacro('xfrm_resource_page_macros', 'resource_page_options', array(
		'category' => $__vars['category'],
	), $__vars) . '

';
	if ($__templater->method($__vars['category'], 'canAddResource', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add resource', array(
			'href' => $__templater->func('link', array('resources/categories/add', $__vars['category'], ), false),
			'class' => 'button--cta',
			'icon' => 'write',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	if ($__vars['pendingApproval']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">' . 'Your content has been submitted and will be displayed pending approval by a moderator.' . '</div>
';
	}
	$__finalCompiled .= '

';
	if ($__vars['iconError']) {
		$__finalCompiled .= '
	<div class="blockMessage blockMessage--error">' . 'The new icon could not be applied. Please try again later.' . '</div>
';
	}
	$__finalCompiled .= '

' . $__templater->widgetPosition('xfrm_category_above_resources', array(
		'category' => $__vars['category'],
	)) . '

';
	if ($__vars['canInlineMod']) {
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/inline_mod.js',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

<div class="block" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="resource" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-outer">';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if ($__vars['canInlineMod']) {
		$__compilerTemp2 .= '
							' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
						';
	}
	$__compilerTemp2 .= '
						';
	if ($__templater->method($__vars['category'], 'canWatch', array())) {
		$__compilerTemp2 .= '
							';
		$__compilerTemp3 = '';
		if ($__vars['category']['Watch'][$__vars['xf']['visitor']['user_id']]) {
			$__compilerTemp3 .= 'Unwatch';
		} else {
			$__compilerTemp3 .= 'Watch';
		}
		$__compilerTemp2 .= $__templater->button('
								' . $__compilerTemp3 . '
							', array(
			'href' => $__templater->func('link', array('resources/categories/watch', $__vars['category'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'switch-overlay',
			'data-sk-watch' => 'Watch',
			'data-sk-unwatch' => 'Unwatch',
		), '', array(
		)) . '
						';
	}
	$__compilerTemp2 .= '
					';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
			<div class="block-outer-opposite">
				<div class="buttonGroup">
					' . $__compilerTemp2 . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= trim('

		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'resources/categories',
		'data' => $__vars['category'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

		' . $__compilerTemp1 . '

		') . '</div>

	<div class="block-container">

		<div class="block-body">
			';
	if (!$__templater->test($__vars['resources'], 'empty', array())) {
		$__finalCompiled .= '
				<div class="structItemContainer">

					<div class="structItemContainer-group js-threadList thread-grid">
						';
		if ($__templater->isTraversable($__vars['resources'])) {
			foreach ($__vars['resources'] AS $__vars['resource']) {
				$__finalCompiled .= '
							' . $__templater->callMacro('fs_rm_list_macros', 'resource', array(
					'resource' => $__vars['resource'],
					'category' => $__vars['category'],
				), $__vars) . '
						';
			}
		}
		$__finalCompiled .= '
					</div>

				</div>
				';
	} else if ($__vars['filters']) {
		$__finalCompiled .= '
				<div class="block-row">' . 'There are no resources matching your filters.' . '</div>
				';
	} else {
		$__finalCompiled .= '
				<div class="block-row">' . 'No resources have been created yet.' . '</div>
			';
	}
	$__finalCompiled .= '
		</div>
		' . '
	</div>


	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'resources/categories',
		'data' => $__vars['category'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>

' . '

' . '

';
	return $__finalCompiled;
}
);