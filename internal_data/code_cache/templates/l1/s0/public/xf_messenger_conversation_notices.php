<?php
// FROM HASH: f7c809493926c89b6ba906d17b9a39e5
return array(
'macros' => array('row' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'userConv' => '!',
		'conversation' => '!',
		'message' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow">
		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['message']['User'], 'xs', false, array(
		'defaultname' => $__vars['message']['username'],
	))) . '
		</div>
		<div class="contentRow-main contentRow-main--close">
			' . $__templater->func('snippet', array($__vars['message']['message'], 150, array('bbWrapper' => true, 'stripQuote' => true, ), ), true) . '
			
			<div class="contentRow-minor contentRow-minor--smaller">
				' . $__templater->func('date_dynamic', array($__vars['message']['message_date'], array(
	))) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['messages'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('notices.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('xf_messenger_conversation_notices.less');
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'xf/notice.js',
			'min' => '1',
		));
		$__finalCompiled .= '
	';
		$__vars['noticeStyle'] = $__templater->func('property', array('xfmNoticeStyle', ), false);
		$__finalCompiled .= '

	<ol class="listPlain">
		';
		if ($__templater->isTraversable($__vars['messages'])) {
			foreach ($__vars['messages'] AS $__vars['message']) {
				$__finalCompiled .= '
			<li class="notice ' . (($__vars['noticeStyle']['type'] == 'custom') ? $__templater->escape($__vars['noticeStyle']['css_class']) : ('notice--' . $__templater->escape($__vars['noticeStyle']['type']))) . ' notice--convMessage js-notice' . ($__vars['xf']['options']['xfmEnablePopup'] ? ' js-chatPopup js-noticeDismiss' : ' js-locationChanger') . '"
				data-notice-id="' . $__templater->escape($__vars['message']['message_id']) . '"
				data-room-tag="' . $__templater->escape($__vars['message']['conversation_id']) . '"
				data-event-prefix="XFM"
				data-delay-duration="0"
				data-display-duration="' . ($__templater->func('property', array('xfmNoticeDuration', ), false) * 1000) . '"
				data-auto-dismiss=""
				data-href="' . $__templater->func('link', array('conversations/messages', $__vars['message'], ), true) . '"
				data-visibility="">
				<div class="notice-content">
					' . $__templater->callMacro(null, 'row', array(
					'userConv' => $__vars['userConv'],
					'conversation' => $__vars['conversation'],
					'message' => $__vars['message'],
				), $__vars) . '
				</div>
			</li>
		';
			}
		}
		$__finalCompiled .= '
	</ol>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);