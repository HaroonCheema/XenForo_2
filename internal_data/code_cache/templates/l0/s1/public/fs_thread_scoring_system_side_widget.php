<?php
// FROM HASH: 17a4726eead64acb0355ee49bba0b5cf
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
		if ($__templater->func('count', array($__vars['data'], ), false)) {
			$__compilerTemp1 .= '

			<div class="block">
				<div class="block-container">

					<h3 class="block-minorHeader">' . 'Thread Score ' . '</h3>
					';
			$__vars['replyPhrase'] = 'Thread Score ';
			$__compilerTemp1 .= '
					';
			$__vars['afterDot'] = $__vars['xf']['options']['fs_thread_scoring_system_decimals'];
			$__compilerTemp1 .= '

					<div class="block-body block-row">

						<dl class="pairs pairs--justified">										
							<dt>' . 'Username' . '</dt>
							<dd>' . (($__vars['xf']['options']['fs_thread_scoring_list_format'] == 'percentage') ? 'Total percentage' : 'Total points') . '</dd>
						</dl>

						<br/>

						';
			if ($__templater->isTraversable($__vars['data'])) {
				foreach ($__vars['data'] AS $__vars['value']) {
					$__compilerTemp1 .= '

							<dl class="pairs pairs--justified">										
								<dt>' . $__templater->func('username_link', array($__vars['value']['User'], true, array(
						'defaultname' => $__vars['value']['User']['username'],
						'itemprop' => 'name',
					))) . '</dt>
								';
					if ($__vars['xf']['options']['fs_thread_scoring_list_format'] == 'percentage') {
						$__compilerTemp1 .= '
									';
						$__vars['percentageThread'] = (($__vars['value']['thread_points'] != 0) ? 100 : 0);
						$__compilerTemp1 .= '
									';
						$__vars['percentageSolution'] = (($__vars['value']['solution_points'] != 0) ? 100 : 0);
						$__compilerTemp1 .= '

									<dd data-xf-init="tooltip" title="' . ((('Thread : ' . ' ') . $__templater->func('number', array($__vars['percentageThread'], $__vars['afterDot'], ), true)) . ' % ') . '
																	  ' . ((('Reply : ' . ' ') . $__templater->func('number', array($__vars['data']['reply_percentage'], $__vars['afterDot'], ), true)) . ' % ') . '
																	  ' . ((('Words : ' . ' ') . $__templater->func('number', array($__vars['data']['word_percentage'], $__vars['afterDot'], ), true)) . ' % ') . '
																	  ' . ((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['data']['reaction_percentage'], $__vars['afterDot'], ), true)) . ' % ') . '
																	  ' . ((('Solution : ' . ' ') . $__templater->func('number', array($__vars['data']['totalPercentage'][$__vars['value']['user_id']]['solution'], $__vars['afterDot'], ), true)) . ' % ') . '">' . $__templater->func('number', array($__vars['value']['total_percentage'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</dd>

									';
					} else {
						$__compilerTemp1 .= '
									<dd data-xf-init="tooltip" title="' . ((((('Thread : ' . ' ') . $__templater->func('number', array($__vars['value']['thread_points'], $__vars['afterDot'], ), true)) . ' (') . 'Points') . ')') . '
																	  ' . ((((('Reply : ' . ' ') . $__templater->func('number', array($__vars['value']['reply_points'], $__vars['afterDot'], ), true)) . ' (') . 'Points') . ')') . '
																	  ' . ((((('Words : ' . ' ') . $__templater->func('number', array($__vars['value']['word_points'], $__vars['afterDot'], ), true)) . ' (') . 'Points') . ')') . '
																	  ' . ((((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['value']['reaction_points'], $__vars['afterDot'], ), true)) . ' (') . 'Points') . ')') . '
																	  ' . ((((('Solution : ' . ' ') . $__templater->func('number', array($__vars['value']['solution_points'], $__vars['afterDot'], ), true)) . ' (') . 'Points') . ')') . '">' . $__templater->func('number', array($__vars['value']['total_points'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</dd>

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