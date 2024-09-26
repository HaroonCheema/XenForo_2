<?php
// FROM HASH: d9fa68e5c9debde5b32e9dc787a67b39
return array(
'extensions' => array('thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				<div class="structItemContainer">


					';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '


						<div class="structItemContainer-group js-threadList">
							';
		if (!$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
								';
			if ($__templater->isTraversable($__vars['threads'])) {
				foreach ($__vars['threads'] AS $__vars['thread']) {
					$__finalCompiled .= '
									' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'fs_latest_thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
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
	$__templater->includeCss('forum_view_latest_content.less');
	$__finalCompiled .= '







<div class="block " data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">



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
	<div class="block">
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