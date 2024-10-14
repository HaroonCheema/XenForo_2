<?php
// FROM HASH: 18a7af3e7abf8acbcb4db1a89eefd1fb
return array(
'extensions' => array('thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				<div class="structItemContainer">

					';
	if (!$__templater->test($__vars['threads'], 'empty', array()) AND (($__vars['xf']['visitor']['tile_layout'] == 'grid') OR ($__vars['xf']['visitor']['tile_layout'] == 'girdLg'))) {
		$__finalCompiled .= '

						<div class="structItemContainer-group js-threadList ' . (($__vars['xf']['visitor']['tile_layout'] == 'girdLg') ? 'gridLarg' : ' ') . '" >
							';
		if (!$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
								';
			if ($__templater->isTraversable($__vars['threads'])) {
				foreach ($__vars['threads'] AS $__vars['thread']) {
					$__finalCompiled .= '
									' . $__templater->callMacro(null, 'fs_latest_thread_list_macros::item', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
						'thread' => $__vars['thread'],
					)), $__vars) . '
								';
				}
			}
			$__finalCompiled .= '
								';
			if ($__vars['showDateLimitDisabler']) {
				$__finalCompiled .= '
									' . $__templater->callMacro(null, 'date_limit_disabler', array(
					'forum' => $__vars['forum'],
					'page' => $__vars['page'],
					'filters' => $__vars['filters'],
				), $__vars) . '
								';
			}
			$__finalCompiled .= '
							';
		}
		$__finalCompiled .= '
						</div>
						';
	} else if (!$__templater->test($__vars['threads'], 'empty', array()) AND ($__vars['xf']['visitor']['tile_layout'] == 'list')) {
		$__finalCompiled .= '
						';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
							' . $__templater->callMacro(null, 'fs_latest_thread_list_macros::list', $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
					'thread' => $__vars['thread'],
				)), $__vars) . '
						';
			}
		}
		$__finalCompiled .= '
						';
	} else {
		$__finalCompiled .= '
						<div class="block-body block-row">' . 'No results found.' . '</div>
					';
	}
	$__finalCompiled .= '
				</div>
			';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Latest Update');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

';
	$__templater->includeCss('fs_latest_update_list.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('fs_latest_update_list_slider.less');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'vendor/lightslider/lightslider.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'FS/LatestUpdateSlider/slider.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__templater->includeCss('forum_view_latest_content.less');
	$__finalCompiled .= '

<style>
	.gridLarg{
		grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)) !important;
	}
</style>

';
	if ($__templater->func('count', array($__vars['featuredThreads'], ), false)) {
		$__finalCompiled .= '
	<div class="block">

		<div class="block-container">

			<div class="block-body block-row">
				<div class="itemList itemList--slider"
					 data-xf-init="item-slider"
					 data-xf-item-slider=\'{"item":' . $__templater->escape($__vars['xf']['options']['fs_latest_update_on_slider']) . ',"itemWide":3,"itemMedium":2,"itemNarrow":1,"auto":false,"loop":true}\'>

					';
		if ($__templater->isTraversable($__vars['featuredThreads'])) {
			foreach ($__vars['featuredThreads'] AS $__vars['thread']) {
				$__finalCompiled .= '
						<div class="itemList-item itemList-item--slider" style="overflow: unset !important;">
							' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'fs_latest_thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
					'thread' => $__vars['thread'],
				)), $__vars) . '
						</div>
					';
			}
		}
		$__finalCompiled .= '

				</div>
			</div>

		</div>
	</div>
';
	}
	$__finalCompiled .= '

<div class="block " data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">

	<div class="block-outer">';
	$__compilerTemp1 = '';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if ($__vars['xf']['visitor']['user_id']) {
		$__compilerTemp2 .= '
							' . $__templater->button('
								' . $__templater->fontAwesome('fas fa-cog', array(
		)) . '
							', array(
			'href' => $__templater->func('link', array('latest-contents/options', ), false),
			'class' => 'button--link',
			'overlay' => 'true',
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
		'link' => 'latest-contents',
		'data' => $__vars['forum'],
		'params' => $__vars['conditions'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__compilerTemp1 . '
		') . '</div>


	<div class="block-container">

		<div class="block-body">
			' . $__templater->renderExtension('thread_list', $__vars, $__extensions) . '
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'latest-contents',
		'data' => $__vars['forum'],
		'params' => $__vars['conditions'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '

	</div>
</div>
';
	$__templater->modifySidebarHtml('conversationInfo', '
	<div class="block ' . (($__vars['xf']['visitor']['filter_sidebar'] == 'sticky') ? 'sticky-filter' : ' ') . '">
		<div class="block-container">
			' . $__templater->includeTemplate('forum_filters_latest', $__vars) . '
		</div>
	</div>
', 'replace');
	$__finalCompiled .= '

';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarfe322c91013383793fda9cb0d7e31c1f', $__templater->widgetPosition('forum_view_sidebar', array(
		'forum' => $__vars['forum'],
	)), 'replace');
	return $__finalCompiled;
}
);