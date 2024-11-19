<?php
// FROM HASH: 8bf2c1beef2e44a6da9c94e5e6425c73
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
	if (($__vars['xf']['visitor']['user_id'] == $__vars['meeting']['user_id']) AND ($__vars['meeting']['status'] != 1)) {
		$__compilerTemp1 .= '
						' . $__templater->button('
							' . 'Start Meeting' . '
						', array(
			'href' => $__templater->func('link', array('meetings/start-meeting', $__vars['meeting'], ), false),
			'class' => 'button--cta',
			'rel' => 'nofollow',
		), '', array(
		)) . '
					';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'isMemberOf', array($__vars['meeting']['join_usergroup_ids'], )) AND (($__vars['meeting']['user_id'] != $__vars['xf']['visitor']['user_id']) AND ($__vars['meeting']['status'] == 1))) {
		$__compilerTemp2 .= '
						' . $__templater->button('
							' . 'Join Meeting' . '
						', array(
			'href' => $__templater->func('link', array('meetings/join-meeting', $__vars['meeting'], ), false),
			'class' => 'button',
			'rel' => 'nofollow',
		), '', array(
		)) . '
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

				<div class="p-title-pageAction" style="float:right;">

					' . $__compilerTemp1 . '

					' . $__compilerTemp2 . '

				</div>

				<div class="p-description">
					<ul class="listInline listInline--bullet">
						<li>
							' . $__templater->fontAwesome('fa-user', array(
		'title' => $__templater->filter('Author', array(array('for_attr', array()),), false),
	)) . ' <span class="u-srOnly">' . 'fs_creater' . '</span>
							' . $__templater->func('username_link', array($__vars['meeting']['User'], false, array(
		'defaultname' => $__vars['meeting']['User']['username'],
		'class' => 'u-concealed',
	))) . ' </li>
						<li>
							' . $__templater->fontAwesome('fa-clock', array(
		'title' => $__templater->filter('Creation date', array(array('for_attr', array()),), false),
	)) . ' <span class="u-srOnly">' . 'fs_creation_date' . '</span>
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
		'success' => 'fs_join_url_copy_successfully',
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
	' . $__templater->button('fs_copy_join_url', array(
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

';
	return $__finalCompiled;
}
);