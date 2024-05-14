<?php
// FROM HASH: c2c17b3495962c8c6b2d7ae65cdc66ba
return array(
'macros' => array('navigation' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'pageSelected' => '!',
		'total' => '',
		'route' => '',
		'brand' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->func('property', array('findThreadsNavStyle', ), false) == 'tabs') {
		$__finalCompiled .= '
		<div class="tabs tabs--standalone">
			<div class="hScroller" data-xf-init="h-scroller">
				<span class="hScroller-scroll">
					' . $__templater->callMacro(null, 'links', array(
			'pageSelected' => $__vars['pageSelected'],
			'baseClass' => 'tabs-tab',
			'selectedClass' => 'is-active',
			'total' => $__vars['total'],
			'route' => $__vars['route'],
			'brand' => $__vars['brand'],
		), $__vars) . '
				</span>
			</div>
		</div>
	';
	} else {
		$__finalCompiled .= '
		';
		$__templater->modifySideNavHtml(null, '
			<div class="block">
				<div class="block-container">
					<h3 class="block-header">' . 'Brand list' . '</h3>
					<div class="block-body">
						' . $__templater->callMacro(null, 'links', array(
			'pageSelected' => $__vars['pageSelected'],
			'baseClass' => 'blockLink',
			'selectedClass' => 'is-selected',
			'total' => $__vars['total'],
			'route' => $__vars['route'],
			'brand' => $__vars['brand'],
		), $__vars) . '
					</div>
				</div>
			</div>

		', 'replace');
		$__finalCompiled .= '
		';
		$__templater->setPageParam('sideNavTitle', 'bh_item_lists');
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'links' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'pageSelected' => '!',
		'baseClass' => '!',
		'selectedClass' => '!',
		'total' => '',
		'route' => '',
		'brand' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'all') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['brand'], array('type' => 'all', ), ), true) . '" rel="nofollow">' . 'All' . ' (' . $__templater->escape($__vars['total']) . ') </a>
	
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'view_count') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['brand'], array('type' => 'view_count', ), ), true) . '" rel="nofollow">' . 'Most Viewed' . '</a>
	
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'discussion_count') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['brand'], array('type' => 'discussion_count', ), ), true) . '" rel="nofollow">' . 'Most Discussed' . '</a>
	
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'rating_avg') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['brand'], array('type' => 'rating_avg', ), ), true) . '" rel="nofollow">' . 'Highest Rated' . '</a>
	
	<a class="' . $__templater->escape($__vars['baseClass']) . ' ' . (($__vars['pageSelected'] == 'owner_count') ? $__templater->escape($__vars['selectedClass']) : '') . '"
		href="' . $__templater->func('link', array($__vars['route'], $__vars['brand'], array('type' => 'owner_count', ), ), true) . '" rel="nofollow">' . 'Most Owners' . '</a>
';
	return $__finalCompiled;
}
),
'brandRelatedLinks' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'brandObj' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ((($__vars['brandObj']['forums_link'] OR $__vars['brandObj']['website_link']) OR $__vars['brandObj']['for_sale_link']) OR $__vars['brandObj']['intro_link']) {
		$__finalCompiled .= '
	<div class="block">
				<div class="block-container">
					';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
									<div class="block-body">
										';
		$__compilerTemp2 = '';
		if ($__vars['brandObj']['forums_link']) {
			$__compilerTemp2 .= '
												' . $__templater->dataRow(array(
				'if' => '$brandObj.forums_link',
			), array(array(
				'href' => $__vars['brandObj']['forums_link'],
				'target' => '_blank',
				'_type' => 'cell',
				'html' => '' . $__templater->escape($__vars['brandObj']['brand_title']) . ' Forums',
			))) . '
											';
		}
		$__compilerTemp3 = '';
		if ($__vars['brandObj']['website_link']) {
			$__compilerTemp3 .= '
												' . $__templater->dataRow(array(
			), array(array(
				'href' => $__vars['brandObj']['website_link'],
				'target' => '_blank',
				'_type' => 'cell',
				'html' => '' . $__templater->escape($__vars['brandObj']['brand_title']) . ' Website',
			))) . '
											';
		}
		$__compilerTemp4 = '';
		if ($__vars['brandObj']['for_sale_link']) {
			$__compilerTemp4 .= '
												' . $__templater->dataRow(array(
			), array(array(
				'href' => $__vars['brandObj']['for_sale_link'],
				'target' => '_blank',
				'_type' => 'cell',
				'html' => 'Used ' . $__templater->escape($__vars['brandObj']['brand_title']) . ' for sale',
			))) . '
											';
		}
		$__compilerTemp5 = '';
		if ($__vars['brandObj']['intro_link']) {
			$__compilerTemp5 .= '
												' . $__templater->dataRow(array(
			), array(array(
				'href' => $__vars['brandObj']['intro_link'],
				'target' => '_blank',
				'_type' => 'cell',
				'html' => 'Introduction to ' . $__templater->escape($__vars['brandObj']['brand_title']) . '',
			))) . '
											';
		}
		$__compilerTemp1 .= $__templater->dataList('

											' . $__compilerTemp2 . '
											' . $__compilerTemp3 . '
											' . $__compilerTemp4 . '
											' . $__compilerTemp5 . '
										', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
									</div>
								';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
						<h3 class="block-minorHeader">' . ($__vars['brandObj']['brand_title'] ? 'Related ' . $__templater->escape($__vars['brandObj']['brand_title']) . ' Links' : 'Related Links') . '</h3>
		
							<div class="block-body block-row block-row--separated">
								' . $__compilerTemp1 . '
							</div>
					';
		}
		$__finalCompiled .= '
				</div>
			</div>
';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'itemDiscussion' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'discussion' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['discussion'], 'isUnread', array())) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		$__compilerTemp2 = '';
		$__compilerTemp2 .= '
							' . $__templater->func('snippet', array($__vars['discussion']['thread_description'], 120, array('stripBbCode' => true, ), ), true) . '
						';
		if (strlen(trim($__compilerTemp2)) > 0) {
			$__compilerTemp1 .= '
					&#13;
					<div class="p-description">
						' . $__compilerTemp2 . '
					</div>
				';
		}
		$__compilerTemp3 = array(array(
			'style' => 'font-weight:700;',
			'_type' => 'cell',
			'html' => '
				<a href="' . $__templater->func('link', array('threads', $__vars['discussion'], ), true) . '" target="_blank"><i class="fal fa-greater-than"></i>&nbsp;&nbsp;' . $__templater->func('prefix', array('thread', $__vars['discussion'], ), true) . $__templater->escape($__vars['discussion']['title']) . '</a>
				' . $__compilerTemp1 . '
			',
		));
		if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canEditDiscussionDesc', ))) {
			$__compilerTemp3[] = array(
				'href' => $__templater->func('link', array('threads/edit-description', $__vars['discussion'], ), false),
				'overlay' => 'true',
				'_type' => 'action',
				'html' => ($__vars['discussion']['thread_description'] ? 'Edit description' : 'Add description'),
			);
		}
		$__finalCompiled .= $__templater->dataRow(array(
		), $__compilerTemp3) . '
	';
	} else {
		$__finalCompiled .= '
		';
		$__compilerTemp4 = '';
		$__compilerTemp5 = '';
		$__compilerTemp5 .= '
							' . $__templater->func('snippet', array($__vars['discussion']['thread_description'], 120, array('stripBbCode' => true, ), ), true) . '
						';
		if (strlen(trim($__compilerTemp5)) > 0) {
			$__compilerTemp4 .= '
					&#13;
					<div class="p-description">
						' . $__compilerTemp5 . '
					</div>
				';
		}
		$__compilerTemp6 = array(array(
			'_type' => 'cell',
			'html' => '
				<a href="' . $__templater->func('link', array('threads', $__vars['discussion'], ), true) . '" target="_blank"><i class="fal fa-greater-than"></i>&nbsp;&nbsp;' . $__templater->escape($__vars['discussion']['title']) . '</a>
				' . $__compilerTemp4 . '
			',
		));
		if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'bh_canEditDiscussionDesc', ))) {
			$__compilerTemp6[] = array(
				'name' => 'thread_ids[]',
				'value' => $__vars['discussion']['thread_id'],
				'_type' => 'toggle',
				'html' => '',
			);
			$__compilerTemp6[] = array(
				'href' => $__templater->func('link', array('threads/edit-description', $__vars['discussion'], ), false),
				'overlay' => 'true',
				'_type' => 'action',
				'html' => ($__vars['discussion']['thread_description'] ? 'Edit description' : 'Add description'),
			);
		}
		$__finalCompiled .= $__templater->dataRow(array(
		), $__compilerTemp6) . '
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
	$__finalCompiled .= '

' . '



' . '


';
	return $__finalCompiled;
}
);