<?php
// FROM HASH: 3fc3a22698bd872d21dd4c5f22842fe5
return array(
'macros' => array('header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'isMemberOf', array($__vars['meeting']['join_usergroup_ids'], ))) {
		$__compilerTemp1 .= '
					<div class="p-title-pageAction" style="float:right;">
							' . $__templater->callMacro(null, 'uper_copy_key', array(
			'url' => $__vars['meeting']['z_join_url'],
			'success' => 'Join Url Copy successfully.',
			'targclass' => 'js-joinUrl' . $__vars['meeting']['meeting_id'],
		), $__vars) . '
					</div>
				';
	}
	$__templater->setPageParam('headerHtml', '
		<div class="contentRow contentRow--hideFigureNarrow">
			<div class="contentRow-main">
				<div class="p-title">
					<h1 class="p-title-value">
						
							' . $__templater->escape($__vars['meeting']['topic']) . '
						
					</h1> 
				</div>
				' . $__compilerTemp1 . '
				<div class="p-description">
					<ul class="listInline listInline--bullet">
						<li>
							' . $__templater->fontAwesome('fa-user', array(
		'title' => $__templater->filter('Author', array(array('for_attr', array()),), false),
	)) . ' <span class="u-srOnly">' . 'creater' . '</span>
							' . $__templater->func('username_link', array($__vars['meeting']['User'], false, array(
		'defaultname' => $__vars['meeting']['User']['username'],
		'class' => 'u-concealed',
	))) . ' </li>
						<li>
							' . $__templater->fontAwesome('fa-clock', array(
		'title' => $__templater->filter('Creation date', array(array('for_attr', array()),), false),
	)) . ' <span class="u-srOnly">' . 'creation_date' . '</span>
							<a href="' . $__templater->func('link', array('meetings', $__vars['meeting'], ), true) . '" class="u-concealed">
								' . $__templater->func('date_dynamic', array($__vars['meeting']['created_date'], array(
	))) . '
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'tabs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
		'selected' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
		<div class="tabs tabs--standalone">
			<div class="hScroller" data-xf-init="h-scroller">
				<span class="hScroller-scroll">
					<a class="tabs-tab ' . (($__vars['selected'] == 'overview') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('meetings/view', $__vars['meeting'], ), true) . '">' . 'Overview' . '</a>
					<a class="tabs-tab ' . (($__vars['selected'] == 'discussion') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('threads', $__vars['meeting']['Thread'], ), true) . '">' . 'Discussion' . '</a>
					<a class="tabs-tab ' . (($__vars['selected'] == 'joiner') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('meetings/joiners', $__vars['meeting'], ), true) . '">' . 'Users ' . '</a>
				</span>
			</div>
		</div>
';
	return $__finalCompiled;
}
),
'leftTime' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
		<div id="meeting-counter-' . $__templater->escape($__vars['meeting']['meeting_id']) . '"> <span class="label label--accent label--small label--counter" id="days-meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
									 ' . 'DD' . '
								</span> <span class="label label--accent label--small label--counter" id="hours-meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
									 ' . 'HH' . '
								</span> <span class="label  label--accent label--small label--counter" id="minutes-meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
									' . 'MM' . '
								</span> <span class="label label--accent label--small label--counter" id="seconds-meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
									 ' . 'SS' . '
								</span> 
	</div>
';
	return $__finalCompiled;
}
),
'meetingInfo' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if (($__vars['meeting']['start_time'] < $__vars['xf']['time']) AND ($__templater->method($__vars['meeting'], 'getMeetingEnd', array()) > $__vars['xf']['time'])) {
		$__compilerTemp1 .= ' 
						<dl class="pairs pairs--justified">
							<dt>' . 'Status' . '</dt>
							<dd id="meeting-live-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" class="status_live">' . 'Live' . '</dd>
						</dl>
						<dl class="pairs pairs--justified">
							<dt>' . 'Start' . '</dt>
							<dd id="meeting-start-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . $__templater->func('date_dynamic', array($__vars['meeting']['start_time'], array(
		))) . '</dd>
						</dl>
						<dl class="pairs pairs--justified">
							<dt>' . 'Meeting End' . '</dt>
							<dd id="meeting-end-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . $__templater->func('date_dynamic', array($__templater->method($__vars['meeting'], 'getMeetingEnd', array()), array(
		))) . '</dd>
						</dl>
					';
	} else if ($__vars['meeting']['start_time'] > $__vars['xf']['time']) {
		$__compilerTemp1 .= ' 
						<dl class="pairs pairs--justified">
							<dt>' . 'Status' . '</dt>
							<dd id="meeting-waiting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" class="status_waiting">' . 'Waiting' . '</dd>
						</dl>
						' . $__templater->includeTemplate('zoom_meeting_timer_counter_js', $__vars) . '
						<dl class="pairs pairs--justified meeting-counter-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
							<dt>' . 'Left Time' . '</dt>
							<dd>
								' . $__templater->callMacro('zoom_meeting_macro', 'leftTime', array(
			'meeting' => $__vars['meeting'],
		), $__vars) . '
							</dd>
						</dl>
					';
	} else if ($__vars['meeting']['start_time'] < $__vars['xf']['time']) {
		$__compilerTemp1 .= ' 
						<dl class="pairs pairs--justified">
							<dt >' . 'Status' . '</dt>
							<dd class="status_closed">' . 'Closed' . '</dd>
						</dl>
						<dl class="pairs pairs--justified">
							<dt>' . 'Meeting End' . '</dt>
							<dd>' . $__templater->func('date_dynamic', array($__templater->method($__vars['meeting'], 'getMeetingEnd', array()), array(
		))) . '</dd>
						</dl>
						
					';
	}
	$__templater->modifySidebarHtml('meetingInfo', '
		<div class="block">
			<div class="block-container">
				<h3 class="block-minorHeader">' . 'Meeting Info' . '</h3>
				
				<div class="block-body block-row block-row--minor">
					' . $__compilerTemp1 . '
					<dl class="pairs pairs--justified">
						<dt>' . 'Duration' . '</dt> 
						<dd>
							' . '' . $__templater->escape($__vars['meeting']['duration']) . ' mints' . '
						</dd>
					</dl>
				</div>
				
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'meetingJoin' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->modifySidebarHtml('meetingJoin', '
		<div class="block">
			<div class="block-container">
				<h3 class="block-minorHeader">' . 'Meeting Join' . '</h3>

				<div class="block-body block-row block-row--minor">
					<dl class="pairs pairs--justified"><dt>' . 'Join Url' . '</dt> <dd>
							' . $__templater->callMacro(null, 'copy_key', array(
		'url' => $__vars['meeting']['z_join_url'],
		'success' => 'Join Url Copy successfully.',
		'targclass' => 'js-join-copyUrl' . $__vars['meeting']['meeting_id'],
	), $__vars) . '
						</dd></dl>
					</div>
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'simple_meeting' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow">
		<div class="contentRow-main contentRow-main--close">
									<a href="' . $__templater->func('link', array('meetings', $__vars['meeting'], ), true) . '">' . $__templater->escape($__vars['meeting']['topic']) . '</a>
									<div class="contentRow-minor contentRow-minor--smaller">
										<ul class="listInline listInline--bullet">
											<li>' . ($__templater->escape($__vars['meeting']['User']['username']) ?: $__templater->escape($__vars['meeting']['username'])) . '</li>
											<li>' . 'Meeting Time' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('date_dynamic', array($__vars['meeting']['start_time'], array(
	))) . '</li>
										</ul>
									</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'otherMetings' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'otherMeetings' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['otherMeetings'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="resourceBody-sidebar">
				<div class="resourceSidebarGroup">
					<h4 class="resourceSidebarGroup-title">
							 ' . 'Other Meetings' . '
							</h4>
					<ul class="resourceSidebarList">
						';
		if ($__templater->isTraversable($__vars['otherMeetings'])) {
			foreach ($__vars['otherMeetings'] AS $__vars['meeting']) {
				$__compilerTemp1 .= '
							<li>
								' . $__templater->callMacro(null, 'simple_meeting', array(
					'meeting' => $__vars['meeting'],
				), $__vars) . ' 
							</li>
						';
			}
		}
		$__compilerTemp1 .= '
					</ul>
				</div>
			</div>
		';
	}
	$__templater->modifySidebarHtml('otherMetings', '
		' . $__compilerTemp1 . '
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'copy_key' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'url' => '!',
		'success' => '!',
		'targclass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<code class="' . $__templater->escape($__vars['targclass']) . '" style="display:none;">' . $__templater->escape($__vars['url']) . '</code>
	' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.' . $__vars['targclass'],
		'data-success' => $__vars['success'],
		'class' => 'button--link is-hidden',
	), '', array(
	)) . '
';
	return $__finalCompiled;
}
),
'uper_copy_key' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'url' => '!',
		'success' => '!',
		'targclass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<code class="' . $__templater->escape($__vars['targclass']) . '" style="display:none;">' . $__templater->escape($__vars['url']) . '</code>
	' . $__templater->button('Copy Join Url', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.' . $__vars['targclass'],
		'data-success' => $__vars['success'],
		'class' => 'is-hidden button--cta',
	), '', array(
	)) . '
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
' . '
' . '
' . '
' . '
' . '
';
	return $__finalCompiled;
}
);