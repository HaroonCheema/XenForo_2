<?php
// FROM HASH: 5d9ae10c6881907d77363751d57ab08f
return array(
'macros' => array('simple_list_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'categoryTree' => '!',
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
		foreach ($__vars['children'] AS $__vars['id'] => $__vars['category']) {
			$__finalCompiled .= '
			';
			$__vars['isSelected'] = ($__vars['category']['record']['resource_category_id'] == $__vars['selected']);
			$__finalCompiled .= '

			<div class="responsive-div" style="background-image: url(' . $__templater->escape($__vars['xf']['options']['fs_rm_bg_img']) . '); width: ' . $__templater->escape($__vars['xf']['options']['fs_rm_bg_width']) . '; height: ' . $__templater->escape($__vars['xf']['options']['fs_rm_bg_size']) . ';">
				<a href="' . $__templater->func('link', array('resources/categories', $__vars['category']['record'], ), true) . '" class="categoryList-link' . ($__vars['isSelected'] ? ' is-selected' : '') . '">
					' . $__templater->escape($__vars['category']['record']['title']) . '
				</a>
			</div>

		';
		}
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Resources');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

';
	$__templater->includeCss('fs_rm_style_grid_css.less');
	$__finalCompiled .= '
' . '

	';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Resources');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

	' . $__templater->includeTemplate('fs_xfrm_filters', $__vars) . '

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
	), $__vars) . '

	</div>



	' . $__templater->callMacro('metadata_macros', 'canonical_url', array(
		'canonicalUrl' => $__templater->func('link', array('canonical:resources', null, array('page' => (($__vars['page'] > 1) ? $__vars['page'] : null), ), ), false),
	), $__vars) . '

	';
	$__templater->setPageParam('searchConstraints', array('Resources' => array('search_type' => 'resource', ), ));
	$__finalCompiled .= '

	';
	if ($__templater->method($__vars['xf']['visitor'], 'canAddResource', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Add resource' . $__vars['xf']['language']['ellipsis'], array(
			'href' => $__templater->func('link', array('resources/add', ), false),
			'class' => 'button--cta',
			'icon' => 'write',
			'overlay' => 'true',
		), '', array(
		)) . '
	');
	}
	$__finalCompiled .= '

	' . $__templater->widgetPosition('xfrm_overview_above_resources', array()) . '

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
		'link' => 'resources',
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
					'filterPrefix' => true,
					'resource' => $__vars['resource'],
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
		</div>

		<div class="block-outer block-outer--after">
			' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'resources',
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

	';
	return $__finalCompiled;
}
);