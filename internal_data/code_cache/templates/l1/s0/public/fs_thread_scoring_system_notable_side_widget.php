<?php
// FROM HASH: 0c12693b5a28ad7e3e279bd906017d7c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_thread_scoring_system', 'can_view', ))) {
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
			$__vars['isBelow'] = '0';
			$__compilerTemp1 .= '

						';
			$__vars['i'] = 0;
			if ($__templater->isTraversable($__vars['data']['records'])) {
				foreach ($__vars['data']['records'] AS $__vars['key'] => $__vars['value']) {
					$__vars['i']++;
					$__compilerTemp1 .= '
							';
					if (($__vars['isBelow'] < $__vars['xf']['options']['fs_thread_scoring_system_notable_perpage']) AND $__vars['value']['User']) {
						$__compilerTemp1 .= '
								<dl class="pairs pairs--justified">										
									<dt>' . $__templater->func('username_link', array($__vars['value']['User'], true, array(
							'defaultname' => $__vars['value']['User']['username'],
							'itemprop' => 'name',
						))) . '</dt>

									<dd data-xf-init="tooltip" title="' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'] ? ((((('Thread : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'] ? ((((('Reply : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'] ? ((((('Words : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'] ? ((((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'] ? ((((('Solution : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '">' . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['totalPoints'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</dd>

								</dl>

								';
						$__vars['isBelow'] = ($__vars['isBelow'] + 1);
						$__compilerTemp1 .= '

							';
					}
					$__compilerTemp1 .= '

						';
				}
			}
			$__compilerTemp1 .= '
						<div class="memberOverviewBlock-seeMore">
							<a href="' . $__templater->func('link', array('members/all-users-points', ), true) . '">' . 'See more' . $__vars['xf']['language']['ellipsis'] . '</a>
						</div>
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