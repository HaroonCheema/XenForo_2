<?php
// FROM HASH: 8a61d6ab9b5eb4cb4817d093470d3703
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_thread_scoring_system', 'can_view', ))) {
		$__compilerTemp1 .= '
		';
		$__vars['data'] = $__templater->method($__vars['thread'], 'getPointsSums', array());
		$__compilerTemp1 .= '

		';
		if ($__templater->func('count', array($__vars['data']['records'], ), false)) {
			$__compilerTemp1 .= '

			<div class="block">
				<div class="block-container">

					<h3 class="block-minorHeader">' . 'Thread Score :' . '</h3>
					';
			$__vars['replyPhrase'] = 'Thread Score :';
			$__compilerTemp1 .= '

					<div class="block-body block-row">

						<dl class="pairs pairs--justified">										
							<dt>' . 'Username' . '</dt>
							<dd>' . 'Total points' . '</dd>
						</dl>

						<br/>

						';
			if ($__templater->isTraversable($__vars['data']['records'])) {
				foreach ($__vars['data']['records'] AS $__vars['value']) {
					$__compilerTemp1 .= '

							<dl class="pairs pairs--justified">										
								<dt>' . $__templater->func('username_link', array($__vars['value']['User'], true, array(
						'defaultname' => $__vars['value']['User']['username'],
						'itemprop' => 'name',
					))) . '</dt>
								<dd data-xf-init="tooltip" title="' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'] ? ((((('Thread : ' . ' ') . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'])) . ' (') . 'Points') . ')') : ' ') . '
																  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'] ? ((((('Reply : ' . ' ') . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'])) . ' (') . 'Points') . ')') : ' ') . '
																  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'] ? ((((('Words : ' . ' ') . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'])) . ' (') . 'Points') . ')') : ' ') . '
																  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'] ? ((((('Reactions : ' . ' ') . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'])) . ' (') . 'Points') . ')') : ' ') . '
																  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'] ? ((((('Solution : ' . ' ') . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'])) . ' (') . 'Points') . ')') : ' ') . '">' . $__templater->escape($__vars['data']['totalCounts'][$__vars['value']['user_id']]['totalPoints']) . '</dd>
							</dl>

						';
				}
			}
			$__compilerTemp1 .= '

					</div>
				</div>
			</div>

		';
		}
		$__compilerTemp1 .= '
	';
	}
	$__templater->modifySidebarHtml('conversationInfo', '

	' . $__compilerTemp1 . '

', 'replace');
	return $__finalCompiled;
}
);