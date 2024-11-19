<?php
// FROM HASH: 9fab62a5dc489bd735e93b35fa92c03a
return array(
'macros' => array('listing' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="structItem structItem--resource " id="meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" data-author="' . ($__templater->escape($__vars['meeting']['User']['username']) ?: '') . '">
		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">
			<div class="structItem-title"> <a href="#" data-tp-primary="on">' . $__templater->escape($__vars['meeting']['topic']) . '</a> </div>
			<div class="structItem-minor">
				<ul class="structItem-parts">
					<li>
						' . $__templater->func('username_link', array($__vars['meeting']['User'], false, array(
		'defaultname' => $__vars['meeting']['User']['username'],
	))) . '
					</li>
					<li class="structItem-startDate">
						' . $__templater->func('date_dynamic', array($__vars['meeting']['start_time'], array(
	))) . ' </li>
				</ul>
			</div>
		</div>
		<div class="block-body block-row block-row--minor structItem-cell structItem-cell--resourceMeta">

			';
	if ($__vars['meeting']['status'] == 1) {
		$__finalCompiled .= ' 
				<dl class="pairs pairs--justified">
					<dt>' . 'Status' . '</dt>
					<dd  id="meeting-live-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" class="status_live">' . 'Live' . '</dd>
				</dl>
				<dl class="pairs pairs--justified">
					<dt>' . 'Meeting End' . '</dt>
					<dd id="meeting-end-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . $__templater->func('date_dynamic', array($__vars['meeting']['end_time'], array(
		))) . '</dd>
				</dl>
				';
		if ($__templater->method($__vars['meeting'], 'getMeetingUserCount', array())) {
			$__finalCompiled .= ' 
					<dl class="pairs pairs--justified">
						<dt>' . 'Users' . '</dt>
						<dd>' . $__templater->escape($__templater->method($__vars['meeting'], 'getMeetingUserCount', array())) . '</dd>
					</dl>
				';
		}
		$__finalCompiled .= '

				';
	} else if ($__vars['meeting']['status'] == 0) {
		$__finalCompiled .= '
				<dl class="pairs pairs--justified">
					<dt>' . 'Duration' . '</dt> 
					<dd>
						' . '' . $__templater->escape($__vars['meeting']['duration']) . ' mints' . '
					</dd>
				</dl>
				<dl class="pairs pairs--justified">
					<dt>' . 'Status' . '</dt>
					<dd  id="meeting-waiting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '"class="status_waiting">' . 'Waiting' . '</dd>
				</dl>
				' . $__templater->includeTemplate('fs_zoom_meeting_timer_counter_js', $__vars) . '
				<dl class="pairs pairs--justified meeting-counter-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">
					<dt>' . 'Left Time' . '</dt>
					<dd>
						' . $__templater->callMacro('fs_zoom_meeting_macro', 'leftTime', array(
			'meeting' => $__vars['meeting'],
		), $__vars) . '
					</dd>
				</dl>
				';
	} else if ($__vars['meeting']['status'] == 2) {
		$__finalCompiled .= ' 
				<dl class="pairs pairs--justified">
					<dt>' . 'Status' . '</dt>
					<dd class="status_closed" id="meeting-closed-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . 'Closed' . '</dd>
				</dl>
				<dl class="pairs pairs--justified">
					<dt>' . 'Meeting End' . '</dt>
					<dd>' . $__templater->func('date_dynamic', array($__vars['meeting']['end_time'], array(
		))) . '</dd>
				</dl>
				';
		if ($__templater->method($__vars['meeting'], 'getMeetingUserCount', array())) {
			$__finalCompiled .= ' 
					<dl class="pairs pairs--justified">
						<dt>' . 'Users' . '</dt>
						<dd>' . $__templater->escape($__templater->method($__vars['meeting'], 'getMeetingUserCount', array())) . '</dd>
					</dl>
				';
		}
		$__finalCompiled .= '

			';
	}
	$__finalCompiled .= '

		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);