<?php
// FROM HASH: 47d02b4c8a27a7aad8be1ba7f158b2f5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Zoom Meeting');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->includeCss('fs_general_zoom_meeting.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

';
	if (($__vars['xf']['visitor']['user_id'] == $__vars['meeting']['user_id']) AND ($__vars['meeting']['status'] != 1)) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('
			' . 'Start Meeting' . '
		', array(
			'href' => $__templater->func('link', array('zoom-meeting/start-meeting', $__vars['meeting'], ), false),
			'class' => 'button--cta',
			'rel' => 'nofollow',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['xf']['visitor'], 'isMemberOf', array($__vars['meeting']['join_usergroup_ids'], )) AND (($__vars['meeting']['user_id'] != $__vars['xf']['visitor']['user_id']) AND ($__vars['meeting']['status'] == 1))) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('
			' . 'Join Meeting' . '
		', array(
			'href' => $__templater->func('link', array('zoom-meeting/join-meeting', $__vars['meeting'], ), false),
			'class' => 'button',
			'rel' => 'nofollow',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

<div class="block" data-type="zoom-meeting">

	<div class="block-container">
		<!--Listing View--->
		<div class="block-body">
			';
	if (!$__templater->test($__vars['meeting'], 'empty', array())) {
		$__finalCompiled .= '

				<div class="structItemContainer">
					' . $__templater->callMacro('fs_zoom_meeting_listing_list_macros', 'listing', array(
			'meeting' => $__vars['meeting'],
		), $__vars) . '  
				</div>

				';
	} else {
		$__finalCompiled .= '
				<div class="block-row"> ' . 'No Meeting Found.' . ' </div>
			';
	}
	$__finalCompiled .= '
			';
	if (!$__templater->test($__vars['meeting'], 'empty', array())) {
		$__finalCompiled .= '
			<div class="block-footer"> <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], $__vars['total'], ), true) . '</span
				>
			</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>

	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'zoom-meeting',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>

';
	$__templater->modifySideNavHtml('_xfWidgetPositionSideNav6626ce3798ace72bb11ddaff1177ae73', $__templater->widgetPosition('zoom_overview_sidnav', array()), 'replace');
	return $__finalCompiled;
}
);