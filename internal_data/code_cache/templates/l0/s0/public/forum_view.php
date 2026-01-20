<?php
// FROM HASH: 426ea89559d91425ccfdf0ce408b4684
return array(
'extensions' => array('structured_data_extra_params' => function($__templater, array $__vars, $__extensions = null)
{
	return array();
},
'structured_data' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	$__vars['ldJson'] = $__templater->method($__vars['forum'], 'getLdStructuredData', array($__vars['threads'], $__vars['page'], $__templater->renderExtension('structured_data_extra_params', $__vars, $__extensions), ));
	$__finalCompiled .= '
		';
	if ($__vars['ldJson']) {
		$__finalCompiled .= '
			<script type="application/ld+json">
				' . $__templater->filter($__vars['ldJson'], array(array('json', array(true, )),array('raw', array()),), true) . '
			</script>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'above_node_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'above_thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'thread_list_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	return '';
},
'filters' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
								' . $__templater->callMacro(null, 'filters', array(
		'forum' => $__vars['forum'],
		'filters' => $__vars['filters'],
		'starterFilter' => $__vars['starterFilter'],
		'threadTypeFilter' => $__vars['threadTypeFilter'],
	), $__vars) . '
							';
	return $__finalCompiled;
},
'thread_list_header' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
			<div class="block-filterBar">
				<div class="filterBar">
					';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
							' . $__templater->renderExtension('filters', $__vars, $__extensions) . '
						';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
						<ul class="filterBar-filters">
						' . $__templater->includeTemplate('altf_auto_reload_configurator', $__vars) . '
						
						' . $__compilerTemp1 . '
						
						' . $__templater->includeTemplate('altf_clear_active_filters', $__vars) . '
						</ul>
					';
	}
	$__finalCompiled .= '
					
					';
	if ($__vars['filter_location'] === 'popup') {
		$__finalCompiled .= '
				<a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . 'Filters' . '</a>
					<div class="menu menu--wide" data-menu="menu" aria-hidden="true"
						data-href="' . $__templater->func('link', array('forums/filters', $__vars['forum'], $__vars['filters'], ), true) . '"
						data-load-target=".js-filterMenuBody">
						<div class="menu-content">
							<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
							<div class="js-filterMenuBody">
								<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
							</div>
						</div>
					</div>
				';
	} else {
		$__finalCompiled .= '
					';
		$__templater->includeCss('altf_active_filter.less');
		$__finalCompiled .= '
					<span class="filterButtonPlaceholder ThreadFilter">.</span>
				';
	}
	$__finalCompiled .= '
				' . $__templater->includeTemplate('altf_filter_icon_replace_filter', $__vars) . '
				</div>
			</div>
		';
	return $__finalCompiled;
},
'thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
				<div class="structItemContainer">
					';
	if ($__templater->test($__vars['forum']['TVForum'], 'empty', array()) OR (!$__vars['forum']['TVForum']['tv_season'])) {
		$__finalCompiled .= '
	';
		if (!$__vars['forum']['Node']['snog_posid']) {
			$__finalCompiled .= '
	' . $__templater->callMacro(null, ($__vars['templateOverrides']['quick_thread_macro'] ?: 'thread_list_macros::quick_thread'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['quick_thread_macro_args'], array(
				'forum' => $__vars['forum'],
				'page' => $__vars['page'],
				'order' => $__vars['sortInfo']['order'],
				'direction' => $__vars['sortInfo']['direction'],
				'prefixes' => $__vars['quickThreadPrefixes'],
			)), $__vars) . '
';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

					';
	if ($__vars['xf']['options']['siropuAdsManagerEnabled'] AND $__templater->method($__vars['xf']['visitor'], 'hasPermission', array('siropuAdsManager', 'createAds', ))) {
		$__finalCompiled .= '
	';
		if (!$__templater->test($__vars['xf']['samThreadAds']['thread'], 'empty', array()) AND $__templater->func('in_array', array($__vars['forum']['node_id'], $__vars['xf']['options']['siropuAdsManagerPromoThreadForums'], ), false)) {
			$__finalCompiled .= '
		' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_thread', array(
				'type' => 'thread',
				'forum' => $__vars['forum'],
			), $__vars) . '
	';
		}
		$__finalCompiled .= '

	';
		if (!$__templater->test($__vars['xf']['samThreadAds']['sticky'], 'empty', array()) AND $__templater->func('in_array', array($__vars['forum']['node_id'], $__vars['xf']['options']['siropuAdsManagerAllowedStickyForums'], ), false)) {
			$__finalCompiled .= '
		' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_thread', array(
				'type' => 'sticky',
				'forum' => $__vars['forum'],
			), $__vars) . '
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
		'position' => 'forum_view_above_stickies',
	), $__vars) . '
';
	if (!$__templater->test($__vars['stickyThreads'], 'empty', array()) OR !$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
						';
		if (!$__templater->test($__vars['stickyThreads'], 'empty', array())) {
			$__finalCompiled .= '
							<div class="structItemContainer-group structItemContainer-group--sticky">
								';
			if ($__templater->isTraversable($__vars['stickyThreads'])) {
				foreach ($__vars['stickyThreads'] AS $__vars['thread']) {
					$__finalCompiled .= '
									' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
						'thread' => $__vars['thread'],
						'forum' => $__vars['forum'],
					)), $__vars) . '
								';
				}
			}
			$__finalCompiled .= '
							</div>

							' . $__templater->callAdsMacro('forum_view_below_stickies', array(
				'forum' => $__vars['forum'],
			), $__vars) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
				'position' => 'forum_view_below_stickies',
			), $__vars) . '
						';
		}
		$__finalCompiled .= '

						<div class="structItemContainer-group js-threadList">
							';
		if (!$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
								';
			if ($__vars['xf']['options']['fs_banned_users_applic_forum'] == $__vars['forum']['node_id']) {
				$__finalCompiled .= '
	';
				if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_ban_watch_profile', 'all_check', ))) {
					$__finalCompiled .= '
		';
					if ($__templater->isTraversable($__vars['threads'])) {
						foreach ($__vars['threads'] AS $__vars['thread']) {
							$__finalCompiled .= '
';
							$__vars['samCounter'] = $__templater->func('number', array($__vars['samCounter'] + 1, ), false);
							$__finalCompiled .= '

';
							$__compilerTemp1 = '';
							$__compilerTemp1 .= '
			' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
								'position' => 'thread_list_above_item_container_' . $__vars['samCounter'],
							), $__vars) . '
		';
							if (strlen(trim($__compilerTemp1)) > 0) {
								$__finalCompiled .= '
	<div class="structItem structItem--thread samUnitWrapper">
		' . $__compilerTemp1 . '
	</div>
';
							}
							$__finalCompiled .= '

			' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
								'thread' => $__vars['thread'],
								'forum' => $__vars['forum'],
							)), $__vars) . '
		';
						}
					}
					$__finalCompiled .= '
		';
				} else {
					$__finalCompiled .= '
		';
					if ($__templater->isTraversable($__vars['threads'])) {
						foreach ($__vars['threads'] AS $__vars['thread']) {
							$__finalCompiled .= '
			';
							if ($__vars['xf']['visitor']['user_id'] == $__vars['thread']['user_id']) {
								$__finalCompiled .= '
				' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
									'thread' => $__vars['thread'],
									'forum' => $__vars['forum'],
								)), $__vars) . '
			';
							}
							$__finalCompiled .= '
		';
						}
					}
					$__finalCompiled .= '
	';
				}
				$__finalCompiled .= '
	';
			} else {
				$__finalCompiled .= '
	';
				if ($__templater->isTraversable($__vars['threads'])) {
					foreach ($__vars['threads'] AS $__vars['thread']) {
						$__finalCompiled .= '
		' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'thread_list_macros::item'), $__templater->combineMacroArgumentAttributes($__vars['templateOverrides']['thread_list_macro_args'], array(
							'thread' => $__vars['thread'],
							'forum' => $__vars['forum'],
						)), $__vars) . '
	
';
						$__compilerTemp2 = '';
						$__compilerTemp2 .= '
			' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
							'position' => 'thread_list_below_item_container_' . $__vars['samCounter'],
						), $__vars) . '
		';
						if (strlen(trim($__compilerTemp2)) > 0) {
							$__finalCompiled .= '
	<div class="structItem structItem--thread samUnitWrapper">
		' . $__compilerTemp2 . '
	</div>
';
						}
						$__finalCompiled .= '
';
					}
				}
				$__finalCompiled .= '
';
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
	} else if ($__vars['filters']) {
		$__finalCompiled .= '
						<div class="structItemContainer-group js-threadList">
							<div class="structItem js-emptyThreadList">
								<div class="structItem-cell">' . 'There are no threads matching your filters.' . '</div>
							</div>
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
						</div>
					';
	} else {
		$__finalCompiled .= '
						<div class="structItemContainer-group js-threadList">
							';
		if ($__vars['showDateLimitDisabler']) {
			$__finalCompiled .= '
								<div class="structItem js-emptyThreadList">
									<div class="structItem-cell">' . 'There are no threads to display.' . '</div>
								</div>
								' . $__templater->callMacro(null, 'date_limit_disabler', array(
				'forum' => $__vars['forum'],
				'page' => $__vars['page'],
				'filters' => $__vars['filters'],
			), $__vars) . '
							';
		} else {
			$__finalCompiled .= '
								<div class="structItem js-emptyThreadList">
									<div class="structItem-cell">' . 'There are no threads in this forum.' . '</div>
								</div>
							';
		}
		$__finalCompiled .= '
						</div>
					';
	}
	$__finalCompiled .= '
				</div>
			';
	return $__finalCompiled;
},
'below_thread_list' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'macros' => array('filters' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'forum' => '!',
		'filters' => '!',
		'starterFilter' => null,
		'threadTypeFilter' => null,
	); },
'extensions' => array('start' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'prefix_id' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['prefix_id']) {
		$__finalCompiled .= '
';
		$__compilerTemp1 = $__vars;
		$__compilerTemp1['prefixType'] = 'thread';
		$__compilerTemp1['baseLinkPath'] = 'forums';
		$__compilerTemp1['container'] = $__vars['forum'];
		$__finalCompiled .= $__templater->includeTemplate('sv_multiprefix_filter', $__compilerTemp1) . '

		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'starter_id' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['starter_id'] AND $__vars['starterFilter']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('starter_id', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Started by' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__vars['starterFilter']['username']) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'thread_type' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['thread_type'] AND $__vars['threadTypeFilter']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('thread_type', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Thread type' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__templater->method($__vars['threadTypeFilter'], 'getTypeTitle', array())) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'last_days' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		';
	if ($__vars['filters']['genre']) {
		$__finalCompiled .= '
	<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('genre', null, )),), false), ), true) . '"
		class="filterBar-filterToggle" data-xf-init="tooltip" title="' . 'Remove this filter' . '">
		<span class="filterBar-filterToggle-label">' . 'Genre' . ':</span>
		' . $__templater->escape($__vars['filters']['genre']) . '</a></li>
';
	}
	$__finalCompiled .= '
';
	if ($__vars['filters']['director']) {
		$__finalCompiled .= '
	<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('director', null, )),), false), ), true) . '"
		class="filterBar-filterToggle" data-xf-init="tooltip" title="' . 'Remove this filter' . '">
		<span class="filterBar-filterToggle-label">' . 'Director' . ':</span>
		' . $__templater->escape($__vars['filters']['director']) . '</a></li>
';
	}
	$__finalCompiled .= '
';
	if ($__vars['filters']['cast']) {
		$__finalCompiled .= '
	<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('cast', null, )),), false), ), true) . '"
		class="filterBar-filterToggle" data-xf-init="tooltip" title="' . 'Remove this filter' . '">
		<span class="filterBar-filterToggle-label">' . 'Cast' . ':</span>
		' . $__templater->escape($__vars['filters']['cast']) . '</a></li>
';
	}
	$__finalCompiled .= '
';
	if ($__vars['filters']['movie_title']) {
		$__finalCompiled .= '
	<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('movie_title', null, )),), false), ), true) . '"
		class="filterBar-filterToggle" data-xf-init="tooltip" title="' . 'Remove this filter' . '">
		<span class="filterBar-filterToggle-label">' . 'Movie title' . ':</span>
		' . $__templater->escape($__vars['filters']['movie_title']) . '</a></li>
';
	}
	$__finalCompiled .= '
' . $__templater->includeTemplate('snog_tv_filter_removal', $__vars) . '
';
	if ($__vars['filters']['last_days'] AND $__vars['dateLimits'][$__vars['filters']['last_days']]) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('last_days', null, )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Last updated' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->escape($__vars['dateLimits'][$__vars['filters']['last_days']]) . '</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'order' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
		' . $__templater->includeTemplate('altf_forum_view_active_filters', $__vars) . '
		';
	if ($__vars['filters']['order']) {
		$__finalCompiled .= '
			<li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array(array('order' => null, 'direction' => null, ), )),), false), ), true) . '"
				class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Return to the default order', array(array('for_attr', array()),), true) . '">
				<span class="filterBar-filterToggle-label">' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '</span>
				' . $__templater->func('phrase_dynamic', array('forum_sort.' . $__vars['filters']['order'], ), true) . '
				' . $__templater->fontAwesome((($__vars['filters']['direction'] == 'asc') ? 'fa-angle-up' : 'fa-angle-down'), array(
		)) . '
				<span class="u-srOnly">';
		if ($__vars['filters']['direction'] == 'asc') {
			$__finalCompiled .= 'Ascending';
		} else {
			$__finalCompiled .= 'Descending';
		}
		$__finalCompiled .= '</span>
			</a></li>
		';
	}
	$__finalCompiled .= '
	';
	return $__finalCompiled;
},
'end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['dateLimits'] = array('-1' => 'Any time', '7' => '' . '7' . ' days', '14' => '' . '14' . ' days', '30' => '' . '30' . ' days', '60' => '' . '2' . ' months', '90' => '' . '3' . ' months', '182' => '' . '6' . ' months', '365' => '1 year', );
	$__finalCompiled .= '

	' . $__templater->renderExtension('start', $__vars, $__extensions) . '

	' . $__templater->renderExtension('prefix_id', $__vars, $__extensions) . '

	' . $__templater->renderExtension('starter_id', $__vars, $__extensions) . '

	' . $__templater->renderExtension('thread_type', $__vars, $__extensions) . '

	' . $__templater->renderExtension('last_days', $__vars, $__extensions) . '

	' . $__templater->renderExtension('order', $__vars, $__extensions) . '

	' . $__templater->renderExtension('end', $__vars, $__extensions) . '
';
	return $__finalCompiled;
}
),
'date_limit_disabler' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'forum' => '!',
		'page' => '!',
		'filters' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="structItem structItem--note">
		<div class="structItem-cell">
			<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('page' => $__vars['page'], 'no_date_limit' => 1, ) + $__vars['filters'], ), true) . '">
				' . 'Show older items' . '
			</a>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['visitor']['is_banned']) {
		$__finalCompiled .= '
	' . $__templater->includeTemplate('fs_ban_forum_view', $__vars) . '
	';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__templater->method($__vars['forum']['Node'], 'getNodeTitle', array())));
		$__templater->pageParams['pageNumber'] = $__vars['page'];
		$__finalCompiled .= '

';
		if ($__vars['forum']['Node']['parent_node_id'] == $__vars['xf']['options']['fs_forum_groups_applicable_forum']) {
			$__finalCompiled .= '
	';
			if ($__vars['forum']['Node']['node_state'] == 'visible') {
				$__finalCompiled .= '
	';
				if (!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND (!$__vars['forum']['TVForum']['tv_parent_id'])) {
					$__finalCompiled .= '
	' . $__templater->includeTemplate('snog_tv_add_season', $__vars) . '
';
				} else {
					$__finalCompiled .= '
	';
					if (!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND $__vars['forum']['TVForum']['tv_parent_id']) {
						$__finalCompiled .= '
	' . $__templater->includeTemplate('snog_tv_add_episode', $__vars) . '
';
					} else {
						$__finalCompiled .= '
	';
						if ($__templater->method($__vars['forum'], 'canCreateThread', array()) OR $__templater->method($__vars['forum'], 'canCreateThreadPreReg', array())) {
							$__compilerTemp1 = '';
							if ((($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])) OR ($__templater->method($__vars['xf']['app']['request'], 'getRoutePath', array()) == 'esperto/'))) {
								$__compilerTemp1 .= '
	' . 'Submit your question' . '
';
							} else {
								$__compilerTemp1 .= '
	';
								if ($__vars['forum']['forum_type_id'] == 'snog_movies_movie') {
									$__compilerTemp1 .= '
	' . 'Post movie' . '
';
								} else {
									$__compilerTemp1 .= '
	';
									if ($__templater->func('in_array', array($__vars['forum']['node_id'], $__vars['xf']['options']['TvThreads_forum'], ), false) AND (!$__vars['xf']['options']['TvThreads_mix'])) {
										$__compilerTemp1 .= '
	' . 'Post a new TV show' . '
';
									} else {
										$__compilerTemp1 .= '
';
										if ($__vars['forum']['Node']['snog_posid'] AND $__vars['forum']['Node']['snog_label']) {
											$__compilerTemp1 .= '
	' . $__templater->escape($__vars['forum']['Node']['snog_label']) . '
';
										} else {
											$__compilerTemp1 .= '
	' . 'Post thread' . '
';
										}
										$__compilerTemp1 .= '	
';
									}
									$__compilerTemp1 .= '
	
';
								}
								$__compilerTemp1 .= '

';
							}
							$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . $__compilerTemp1 . '
	', array(
								'href' => ($__vars['forum']['Node']['snog_posid'] ? $__templater->func('link', array('form/select', array('posid' => $__vars['forum']['Node']['snog_posid'], ), ), false) : $__templater->func('link', array('forums/post-thread', $__vars['forum'], ), false)),
								'class' => 'button--cta',
								'icon' => 'write',
							), '', array(
							)) . '
');
						}
						$__finalCompiled .= '
';
					}
					$__finalCompiled .= '
';
				}
				$__finalCompiled .= '
	';
			}
			$__finalCompiled .= '
';
		} else {
			$__finalCompiled .= '
	';
			if (!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND (!$__vars['forum']['TVForum']['tv_parent_id'])) {
				$__finalCompiled .= '
	' . $__templater->includeTemplate('snog_tv_add_season', $__vars) . '
';
			} else {
				$__finalCompiled .= '
	';
				if (!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND $__vars['forum']['TVForum']['tv_parent_id']) {
					$__finalCompiled .= '
	' . $__templater->includeTemplate('snog_tv_add_episode', $__vars) . '
';
				} else {
					$__finalCompiled .= '
	';
					if ($__templater->method($__vars['forum'], 'canCreateThread', array()) OR $__templater->method($__vars['forum'], 'canCreateThreadPreReg', array())) {
						$__compilerTemp2 = '';
						if ((($__vars['xf']['reply']['containerKey'] == ('node-' . $__vars['xf']['options']['fs_questionAnswerForum'])) OR ($__templater->method($__vars['xf']['app']['request'], 'getRoutePath', array()) == 'esperto/'))) {
							$__compilerTemp2 .= '
	' . 'Submit your question' . '
';
						} else {
							$__compilerTemp2 .= '
	';
							if ($__vars['forum']['forum_type_id'] == 'snog_movies_movie') {
								$__compilerTemp2 .= '
	' . 'Post movie' . '
';
							} else {
								$__compilerTemp2 .= '
	';
								if ($__templater->func('in_array', array($__vars['forum']['node_id'], $__vars['xf']['options']['TvThreads_forum'], ), false) AND (!$__vars['xf']['options']['TvThreads_mix'])) {
									$__compilerTemp2 .= '
	' . 'Post a new TV show' . '
';
								} else {
									$__compilerTemp2 .= '
';
									if ($__vars['forum']['Node']['snog_posid'] AND $__vars['forum']['Node']['snog_label']) {
										$__compilerTemp2 .= '
	' . $__templater->escape($__vars['forum']['Node']['snog_label']) . '
';
									} else {
										$__compilerTemp2 .= '
	' . 'Post thread' . '
';
									}
									$__compilerTemp2 .= '	
';
								}
								$__compilerTemp2 .= '
	
';
							}
							$__compilerTemp2 .= '

';
						}
						$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . $__compilerTemp2 . '
	', array(
							'href' => ($__vars['forum']['Node']['snog_posid'] ? $__templater->func('link', array('form/select', array('posid' => $__vars['forum']['Node']['snog_posid'], ), ), false) : $__templater->func('link', array('forums/post-thread', $__vars['forum'], ), false)),
							'class' => 'button--cta',
							'icon' => 'write',
						), '', array(
						)) . '
');
					}
					$__finalCompiled .= '
';
				}
				$__finalCompiled .= '
';
			}
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '

';
		if ($__templater->test($__vars['forum']['TVForum'], 'empty', array())) {
			$__finalCompiled .= '
	';
			$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->filter($__vars['forum']['Node']['description'], array(array('raw', array()),), true));
			$__templater->pageParams['pageDescriptionMeta'] = true;
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '

';
		$__templater->includeCss('structured_list.less');
		$__finalCompiled .= '

';
		if (!$__templater->method($__vars['forum'], 'isSearchEngineIndexable', array())) {
			$__finalCompiled .= '
	';
			$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '

';
		$__templater->setPageParam('ldJsonHtml', '
	' . '' . '
	' . $__templater->renderExtension('structured_data', $__vars, $__extensions) . '
');
		$__finalCompiled .= '

' . $__templater->callMacro('metadata_macros', 'canonical_url', array(
			'canonicalUrl' => $__templater->func('link', array('canonical:forums', $__vars['forum'], $__vars['canonicalFilters'] + array('page' => $__vars['page'], ), ), false),
		), $__vars) . '

';
		$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('<link rel="alternate" type="application/rss+xml" title="' . $__templater->filter('RSS feed for ' . $__vars['forum']['title'] . '', array(array('for_attr', array()),), true) . '" href="' . $__templater->func('link', array('forums/index.rss', $__vars['forum'], ), true) . '" />'));
		$__finalCompiled .= '

' . $__templater->callMacro('forum_macros', 'forum_page_options', array(
			'forum' => $__vars['forum'],
		), $__vars) . '
';
		$__templater->breadcrumbs($__templater->method($__vars['forum'], 'getBreadcrumbs', array(false, )));
		$__finalCompiled .= '

';
		if ($__vars['pendingApproval']) {
			$__finalCompiled .= '
	<div class="blockMessage blockMessage--important">' . 'Your content has been submitted and will be displayed pending approval by a moderator.' . '</div>
';
		}
		$__finalCompiled .= '

' . $__templater->renderExtension('above_node_list', $__vars, $__extensions) . '

';
		if ($__vars['nodeTree']) {
			$__finalCompiled .= '
	' . $__templater->callAdsMacro('forum_view_above_node_list', array(
				'forum' => $__vars['forum'],
			), $__vars) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
				'position' => 'forum_view_above_node_list',
			), $__vars) . '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
			if ($__vars['forum']['node_id'] == $__vars['xf']['options']['fs_forum_groups_applicable_forum']) {
				$__finalCompiled .= '
';
				$__templater->includeCss('fs_forum_gorups_group_list.less');
				$__finalCompiled .= '
';
				$__templater->includeCss('fs_forum_gorups_style.less');
				$__finalCompiled .= '
';
				$__templater->includeCss('fs_forum_gorups_grid_card.less');
				$__finalCompiled .= '

			<div class="block groupListBlock" data-xf-init="inline-mod"
         data-type="tl_group"
         data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
		
					<div class="groupList h-dFlex h-dFlex--wrap gridCardList--flex--' . $__templater->escape($__vars['xf']['options']['fs_forum_gorups_per_row']) . '-col" data-xf-init="tl_groups_list">
				';
				if ($__templater->isTraversable($__vars['nodeTree'])) {
					foreach ($__vars['nodeTree'] AS $__vars['id'] => $__vars['child']) {
						$__finalCompiled .= '
					' . $__templater->callMacro('fs_forum_groups_forum_view_list', 'fs_forum_groups_forum_view_list_macro', array(
							'subForum' => $__vars['child']['record'],
						), $__vars) . '
				';
					}
				}
				$__finalCompiled .= '
					</div>
				</div>
';
			} else {
				$__finalCompiled .= '
	' . $__templater->callMacro('forum_list', 'node_list', array(
					'children' => $__vars['nodeTree'],
					'extras' => $__vars['nodeExtras'],
					'depth' => '2',
				), $__vars) . '	
';
			}
			$__finalCompiled .= '
			</div>
		</div>
	</div>
	' . $__templater->callAdsMacro('forum_view_below_node_list', array(
				'forum' => $__vars['forum'],
			), $__vars) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
				'position' => 'forum_view_below_node_list',
			), $__vars) . '
';
		}
		$__finalCompiled .= '

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

';
		if ($__vars['forum']['Node']['parent_node_id'] == $__vars['xf']['options']['fs_forum_groups_applicable_forum']) {
			$__finalCompiled .= '
			';
			if (!$__vars['nodeTree']) {
				$__finalCompiled .= '
			  ' . $__templater->callMacro('fs_forum_groups_forum_view_single', 'fs_forum_groups_forum_view_single_macro', array(
					'subForums' => $__vars['forum']['Node'],
				), $__vars) . '
			';
			}
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '

' . $__templater->renderExtension('above_thread_list', $__vars, $__extensions) . '
' . $__templater->callAdsMacro('forum_view_above_thread_list', array(
			'forum' => $__vars['forum'],
		), $__vars) . '
';
		if (!$__templater->test($__vars['forum']['TVForum'], 'empty', array()) AND (!$__vars['forum']['TVForum']['tv_parent_id'])) {
			$__finalCompiled .= '
	';
			if ($__templater->method($__vars['forum'], 'canCreateThread', array())) {
				$__finalCompiled .= '
		' . $__templater->includeTemplate('snog_tv_post_thread', $__vars) . '
	';
			}
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
			'position' => 'forum_view_above_thread_list',
		), $__vars) . '

' . '
' . $__templater->includeTemplate('altf_above_thread_filter_container', $__vars) . '
<div class="block ' . $__templater->escape($__templater->renderExtension('thread_list_block_classes', $__vars, $__extensions)) . '" style="' . ((($__vars['forum']['Node']['parent_node_id'] == $__vars['xf']['options']['fs_forum_groups_applicable_forum']) AND ($__vars['forum']['Node']['node_state'] != 'visible')) ? 'display: none;' : '') . '" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	
	<div class="block-outer">';
		$__compilerTemp3 = '';
		$__compilerTemp4 = '';
		$__compilerTemp4 .= '
					';
		if ($__vars['canInlineMod']) {
			$__compilerTemp4 .= '
						' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
					';
		}
		$__compilerTemp4 .= '
					';
		if ($__vars['xf']['visitor']['user_id']) {
			$__compilerTemp4 .= '
						' . $__templater->button('
							' . 'Mark read' . '
						', array(
				'href' => $__templater->func('link', array('forums/mark-read', $__vars['forum'], array('date' => $__vars['xf']['time'], ), ), false),
				'class' => 'button--link',
				'overlay' => 'true',
			), '', array(
			)) . '
					';
		}
		$__compilerTemp4 .= '
					';
		if ($__templater->method($__vars['forum'], 'canWatch', array())) {
			$__compilerTemp4 .= '
						';
			$__compilerTemp5 = '';
			if ($__vars['forum']['Watch'][$__vars['xf']['visitor']['user_id']]) {
				$__compilerTemp5 .= 'Unwatch';
			} else {
				$__compilerTemp5 .= 'Watch';
			}
			$__compilerTemp4 .= $__templater->button('
							' . $__compilerTemp5 . '
						', array(
				'href' => $__templater->func('link', array('forums/watch', $__vars['forum'], ), false),
				'class' => 'button--link',
				'data-xf-click' => 'switch-overlay',
				'data-sk-watch' => 'Watch',
				'data-sk-unwatch' => 'Unwatch',
			), '', array(
			)) . '
					';
		}
		$__compilerTemp4 .= '
				';
		if (strlen(trim($__compilerTemp4)) > 0) {
			$__compilerTemp3 .= '

';
			if ($__templater->func('in_array', array($__vars['forum']['node_id'], $__vars['xf']['options']['fs_forums'], ), false)) {
				$__compilerTemp3 .= '
    <div class="blockMessage ' . $__templater->escape($__vars['xf']['options']['fs_color']) . ' ';
				if ($__vars['xf']['options']['fs_show_icon'] == 1) {
					$__compilerTemp3 .= 'blockMessage--iconic';
				}
				$__compilerTemp3 .= '">
        ' . $__templater->filter($__vars['xf']['options']['fs_thread_rules'], array(array('raw', array()),), true) . '
    </div>
';
			}
			$__compilerTemp3 .= '
			<div class="block-outer-opposite">
				<div class="buttonGroup">
				' . $__compilerTemp4 . '
				</div>
			</div>
		';
		}
		$__finalCompiled .= trim('
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'forums',
			'data' => $__vars['forum'],
			'params' => $__vars['filters'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
		' . $__compilerTemp3 . '
	') . '</div>

	<div class="block-container">

		' . $__templater->renderExtension('thread_list_header', $__vars, $__extensions) . '

		';
		$__vars['qtPos'] = $__templater->preEscaped(((($__vars['sortInfo']['order'] == 'last_post_date') AND ($__vars['sortInfo']['direction'] == 'asc')) ? 'bottom' : 'top'));
		$__finalCompiled .= '

		<div class="block-body">
			' . $__templater->renderExtension('thread_list', $__vars, $__extensions) . '
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'forums',
			'data' => $__vars['forum'],
			'params' => $__vars['filters'],
			'wrapperclass' => 'block-outer-main',
			'perPage' => $__vars['perPage'],
		))) . '
		' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer-opposite',
		))) . '
		';
		if ((!$__templater->method($__vars['forum'], 'canCreateThread', array())) AND (!$__templater->method($__vars['forum'], 'canCreateThreadPreReg', array()))) {
			$__finalCompiled .= '
			<div class="block-outer-opposite">
				';
			if ($__vars['xf']['visitor']['user_id']) {
				$__finalCompiled .= '
					<span class="button button--wrap is-disabled">
						' . 'You have insufficient privileges to post threads here.' . '
						<!-- this is not interactive so shouldn\'t be a button element -->
					</span>
				';
			} else {
				$__finalCompiled .= '
					' . $__templater->button('
						' . 'You must log in or register to post here.' . '
					', array(
					'href' => $__templater->func('link', array('login', ), false),
					'class' => 'button--link button--wrap',
					'overlay' => 'true',
				), '', array(
				)) . '
				';
			}
			$__finalCompiled .= '
			</div>
		';
		}
		$__finalCompiled .= '
	</div>
</div>

' . $__templater->callAdsMacro('forum_view_below_thread_list', array(
			'forum' => $__vars['forum'],
		), $__vars) . '
' . $__templater->callMacro('siropu_ads_manager_ad_macros', 'ad_unit', array(
			'position' => 'forum_view_below_thread_list',
		), $__vars) . '
' . $__templater->renderExtension('below_thread_list', $__vars, $__extensions) . '

';
		$__templater->modifySidebarHtml('_xfWidgetPositionSidebar4af9e5586cebde792f114aeefbddcc2f', $__templater->widgetPosition('forum_view_sidebar', array(
			'forum' => $__vars['forum'],
		)), 'replace');
		$__finalCompiled .= '

' . '

' . '
';
	}
	return $__finalCompiled;
}
);