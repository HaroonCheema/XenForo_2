<?php
// FROM HASH: a6c7e6605cebb07b7503ca6c680cdf07
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_thread_scoring_system', 'can_view', ))) {
		$__finalCompiled .= '

	';
		if ($__templater->func('count', array($__vars['data'], ), false)) {
			$__finalCompiled .= '

		';
			$__compilerTemp1 = '';
			$__compilerTemp1 .= '
						';
			$__vars['isBelow'] = '0';
			$__compilerTemp1 .= '

						';
			$__vars['i'] = 0;
			if ($__templater->isTraversable($__vars['data'])) {
				foreach ($__vars['data'] AS $__vars['key'] => $__vars['value']) {
					$__vars['i']++;
					$__compilerTemp1 .= '
							';
					if (($__vars['isBelow'] < $__vars['xf']['options']['fs_thread_scoring_system_notable_perpage']) AND $__vars['value']['User']) {
						$__compilerTemp1 .= '
								<li>
									<div class="contentRow contentRow--alignMiddle">
										<div class="contentRow-figure">
											' . $__templater->func('avatar', array($__vars['value']['User'], 'xs', false, array(
						))) . '
										</div>
										<div class="contentRow-main">
											';
						if ($__vars['value']['total_score']) {
							$__compilerTemp1 .= '
												<div class="contentRow-extra contentRow-extra--large" data-xf-init="tooltip" title="' . ($__vars['value']['threads_score'] ? ((((('Thread : ' . ' ') . $__templater->func('number', array($__vars['value']['threads_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																																	' . ($__vars['value']['reply_score'] ? ((((('Reply : ' . ' ') . $__templater->func('number', array($__vars['value']['reply_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																																	' . ($__vars['value']['worlds_score'] ? ((((('Words : ' . ' ') . $__templater->func('number', array($__vars['value']['worlds_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																																	' . ($__vars['value']['reactions_score'] ? ((((('Reactions : ' . ' ') . $__templater->func('number', array($__vars['value']['reactions_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '
																																	' . ($__vars['value']['solutions_score'] ? ((((('Solution : ' . ' ') . $__templater->func('number', array($__vars['value']['solutions_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true)) . ' (') . 'Points') . ')') : ' ') . '">' . $__templater->func('number', array($__vars['value']['total_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '</div>
											';
						}
						$__compilerTemp1 .= '
											<h3 class="contentRow-title">' . $__templater->func('username_link', array($__vars['value']['User'], true, array(
						))) . '</h3>
										</div>
									</div>
								</li>
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
					';
			if (strlen(trim($__compilerTemp1)) > 0) {
				$__finalCompiled .= '
			<li class="memberOverviewBlock">
				<h3 class="block-textHeader">
					<a href="' . $__templater->func('link', array('members', ), true) . '"
					   class="memberOverViewBlock-title">' . 'Thread Score ' . '</a>
				</h3>
				<ol class="memberOverviewBlock-list">
					' . $__compilerTemp1 . '
				</ol>
				<div class="memberOverviewBlock-seeMore">
					<a href="' . $__templater->func('link', array('members/all-users-points', ), true) . '">' . 'See more' . $__vars['xf']['language']['ellipsis'] . '</a>
				</div>
			</li>
		';
			}
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '

';
	}
	return $__finalCompiled;
}
);