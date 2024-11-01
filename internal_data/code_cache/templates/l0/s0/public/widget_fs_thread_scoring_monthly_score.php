<?php
// FROM HASH: dd38c5ed733ebd0c84e8f8767caf8aeb
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
			$__templater->includeCss('member.less');
			$__finalCompiled .= '

		<div class="block">
			<div class="block-container">
				<div class="block-body" style="margin: 10px;">

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
									<li style="margin: 5px 0px;">
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
						<h3 class="block-textHeader">
							<a href="' . $__templater->func('link', array('members/custom-users-points', ), true) . '"
							   class="memberOverViewBlock-title">' . 'Custom thread score' . '</a>
						</h3>
						' . $__compilerTemp1 . '
						<div class="memberOverviewBlock-seeMore">
							<a href="' . $__templater->func('link', array('members/custom-users-points', ), true) . '">' . 'See more' . $__vars['xf']['language']['ellipsis'] . '</a>
						</div>
					';
			}
			$__finalCompiled .= '
				</div>
			</div>
		</div>
	';
		}
		$__finalCompiled .= '

';
	}
	return $__finalCompiled;
}
);