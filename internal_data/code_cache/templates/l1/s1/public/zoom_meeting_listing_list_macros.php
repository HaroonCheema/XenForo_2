<?php
// FROM HASH: c0d9a79c19237599f13b32897edd5b16
return array(
'macros' => array('listing' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'meeting' => '!',
		'category' => null,
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('zoom_meeting_list.less');
	$__finalCompiled .= '

	<div class="structItem structItem--resource " id="meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" data-author="' . ($__templater->escape($__vars['meeting']['User']['username']) ?: '') . '">
		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">
			<div class="structItem-title"> <a href="' . $__templater->func('link', array('meetings/view', $__vars['meeting'], ), true) . '" data-tp-primary="on">' . $__templater->escape($__vars['meeting']['topic']) . '</a> </div>
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
					<li>' . $__templater->func('snippet', array($__vars['meeting']['Category']['title'], 50, array('stripBbCode' => true, ), ), true) . '</li>
				</ul>
			</div>
		</div>
		<div class="block-body block-row block-row--minor structItem-cell structItem-cell--resourceMeta">
			    
					';
	if (($__vars['meeting']['start_time'] < $__vars['xf']['time']) AND ($__templater->method($__vars['meeting'], 'getMeetingEnd', array()) > $__vars['xf']['time'])) {
		$__finalCompiled .= ' 
						<dl class="pairs pairs--justified">
							<dt>' . 'Status' . '</dt>
							<dd  id="meeting-live-' . $__templater->escape($__vars['meeting']['meeting_id']) . '" class="status_live">' . 'Live' . '</dd>
						</dl>
						<dl class="pairs pairs--justified">
							<dt>' . 'Meeting End' . '</dt>
							<dd id="meeting-end-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . $__templater->func('date_dynamic', array($__templater->method($__vars['meeting'], 'getMeetingEnd', array()), array(
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
	} else if ($__vars['meeting']['start_time'] > $__vars['xf']['time']) {
		$__finalCompiled .= ' 
						<dl class="pairs pairs--justified">
							<dt>' . 'Status' . '</dt>
							<dd  id="meeting-waiting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '"class="status_waiting">' . 'Waiting' . '</dd>
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
		$__finalCompiled .= ' 
						<dl class="pairs pairs--justified">
							<dt>' . 'Status' . '</dt>
							<dd class="status_closed" id="meeting-closed-' . $__templater->escape($__vars['meeting']['meeting_id']) . '">' . 'Closed' . '</dd>
						</dl>
						<dl class="pairs pairs--justified">
							<dt>' . 'Meeting End' . '</dt>
							<dd>' . $__templater->func('date_dynamic', array($__templater->method($__vars['meeting'], 'getMeetingEnd', array()), array(
		))) . '</dd>
						</dl>
						
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