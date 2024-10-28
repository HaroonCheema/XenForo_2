<?php
// FROM HASH: e5cc7ade87138520a0af233d0dc9c6c6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['meeting']['topic']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['meeting']['Category'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '
';
	$__templater->includeCss('general_zoom_meeting.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('meeting_overiew.less');
	$__finalCompiled .= '
' . $__templater->callMacro('zoom_meeting_macro', 'header', array(
		'meeting' => $__vars['meeting'],
	), $__vars) . '

' . $__templater->callMacro('zoom_meeting_macro', 'tabs', array(
		'meeting' => $__vars['meeting'],
		'selected' => 'overview',
	), $__vars) . '


<div class="block">
	<div class="block-container">
		<div class="block-body lbContainer js-resourceBody"
			data-xf-init="lightbox"
			data-lb-id="meeting-' . $__templater->escape($__vars['meeting']['meeting_id']) . '"
			data-lb-caption-desc="' . ($__vars['meeting']['User'] ? $__templater->escape($__vars['meeting']['User']['username']) : $__templater->escape($__vars['meeting']['username'])) . ' &middot; ' . $__templater->func('date_time', array($__vars['meeting']['created_date'], ), true) . '">

			
			<div class="resourceBody">
				<article class="resourceBody-main js-lbContainer">
					
					' . $__templater->func('bb_code', array($__vars['meeting']['Thread']['FirstPost']['message'], 'post', $__vars['meeting']['Thread']['FirstPost'], ), true) . '
					
				</article>
				' . $__templater->includeTemplate('zoom_meeting_timer_counter_js', $__vars) . ' 
				' . $__templater->callMacro('zoom_meeting_macro', 'meetingInfo', array(
		'meeting' => $__vars['meeting'],
	), $__vars) . '
				';
	if ($__templater->method($__vars['xf']['visitor'], 'isMemberOf', array($__vars['meeting']['join_usergroup_ids'], ))) {
		$__finalCompiled .= '
					' . $__templater->callMacro('zoom_meeting_macro', 'meetingJoin', array(
			'meeting' => $__vars['meeting'],
		), $__vars) . '
				';
	}
	$__finalCompiled .= '
				';
	if (!$__templater->test($__vars['otherMeetings'], 'empty', array())) {
		$__finalCompiled .= '
					' . $__templater->callMacro('zoom_meeting_macro', 'otherMetings', array(
			'otherMeetings' => $__vars['otherMeetings'],
		), $__vars) . '
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);