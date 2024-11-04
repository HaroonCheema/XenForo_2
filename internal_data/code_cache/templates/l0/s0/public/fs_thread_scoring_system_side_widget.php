<?php
// FROM HASH: 8f930ec49dae81420c86e96d2f9f01c9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_thread_scoring_system', 'can_view', )) AND (!$__templater->func('in_array', array($__vars['thread']['Forum']['node_id'], $__vars['xf']['options']['fs_thread_scoring_system_exc_forms'], ), false))) {
		$__compilerTemp1 .= '
		';
		$__vars['data'] = (($__vars['xf']['options']['fs_thread_scoring_list_format'] == 'percentage') ? $__templater->method($__vars['thread'], 'getPercentageSums', array()) : $__templater->method($__vars['thread'], 'getPointsSums', array()));
		$__compilerTemp1 .= '

		';
		if ($__templater->func('count', array($__vars['data']['records'], ), false)) {
			$__compilerTemp1 .= '

			<div class="block">
				<div class="block-container">

					<h3 class="block-minorHeader">' . 'Thread Score ' . '</h3>
					';
			$__vars['replyPhrase'] = 'Thread Score ';
			$__compilerTemp1 .= '

					<div class="block-body block-row">

						<dl class="pairs pairs--justified">										
							<dt>' . 'Username' . '</dt>
							<dd>' . (($__vars['xf']['options']['fs_thread_scoring_list_format'] == 'percentage') ? 'Total percentage' : 'Total points') . '</dd>
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
								';
					if ($__vars['xf']['options']['fs_thread_scoring_list_format'] == 'percentage') {
						$__compilerTemp1 .= '
									<dd data-xf-init="tooltip" title="' . ($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['thread'] ? ((('Thread : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['thread'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' % ') : ' ') . '
																	  ' . ($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['reply'] ? ((('Reply : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['reply'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' % ') : ' ') . '
																	  ' . ($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['words'] ? ((('Words : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['words'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' % ') : ' ') . '
																	  ' . ($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['reactions'] ? ((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['reactions'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' % ') : ' ') . '
																	  ' . ($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['solution'] ? ((('Solution : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['solution'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' % ') : ' ') . '">' . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['totalPoints'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</dd>

									';
					} else {
						$__compilerTemp1 .= '
									<dd data-xf-init="tooltip" title="' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'] ? ((((('Thread : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['thread'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'] ? ((((('Reply : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reply'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'] ? ((((('Words : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['words'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'] ? ((((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['reactions'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																	  ' . ($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'] ? ((((('Solution : ' . ' ') . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['solution'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '">' . $__templater->func('number', array($__vars['data']['totalCounts'][$__vars['value']['user_id']]['totalPoints'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</dd>

								';
					}
					$__compilerTemp1 .= '

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