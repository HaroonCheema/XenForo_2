<?php
// FROM HASH: 0de82d2f97b17ac5d3925731da811fbe
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li class="block-row block-row--separated" data-author="' . ($__templater->escape($__vars['message']['User']['username']) ?: 'Unknown') . '">
	<div class="contentRow">
		<span class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['message']['User'], 's', false, array(
		'defaultname' => ($__vars['message']['User']['username'] ?: 'Unknown'),
	))) . '
		</span>
		<div class="contentRow-main">
			<h3 class="contentRow-title">
				<a href="' . $__templater->func('link', array('chat/messages/to', $__vars['message'], ), true) . '">
					' . 'Chat message' . '
				</a>
			</h3>

			<div class="contentRow-snippet">' . $__templater->func('bb_code', array($__templater->filter($__vars['message']['message'], array(array('censor', array()),), false), 'chat:message', $__vars['message'], ), true) . '</div>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>' . $__templater->func('username_link', array($__vars['message']['User'], false, array(
	))) . '</li>
					<li>' . $__templater->func('date_dynamic', array($__vars['message']['message_date'], array(
	))) . '</li>
				</ul>
			</div>
		</div>
	</div>
</li>';
	return $__finalCompiled;
}
);