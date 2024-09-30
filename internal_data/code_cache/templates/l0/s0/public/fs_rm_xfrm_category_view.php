<?php
// FROM HASH: 3c622849ea901a7be99448fc6c116e7a
return array(
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
</div>';
	return $__finalCompiled;
}
);