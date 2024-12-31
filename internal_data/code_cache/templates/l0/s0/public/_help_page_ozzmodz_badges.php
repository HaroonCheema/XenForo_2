<?php
// FROM HASH: 1eab873bb0b44b4beb9dacecd8fb63fc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('metadata_macros', 'metadata', array(
		'description' => 'Badges are special awards for unique and valuable actions. This page shows a list of all badges.',
	), $__vars) . '

';
	if ($__templater->test($__vars['badgeData']['badges'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No badges have been created yet.' . '</div>
';
	}
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['badgeData']['badgeCategories'])) {
		foreach ($__vars['badgeData']['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
			$__finalCompiled .= '
	';
			$__compilerTemp1 = '';
			if ($__templater->isTraversable($__vars['badgeData']['badges'][$__vars['catId']])) {
				foreach ($__vars['badgeData']['badges'][$__vars['catId']] AS $__vars['badge']) {
					$__compilerTemp1 .= '
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge', array(
						'badge' => $__vars['badge'],
						'counter' => true,
					), $__vars) . '
		';
				}
			}
			$__vars['catContent'] = $__templater->preEscaped(trim('
		' . $__compilerTemp1 . '
	'));
			$__finalCompiled .= '

	';
			if (!$__templater->test($__vars['catContent'], 'empty', array())) {
				$__finalCompiled .= '
		';
				if ($__templater->func('count', array($__vars['badgeData']['badgeCategories'], ), false) == 1) {
					$__finalCompiled .= '
			<div class="block">
				<div class="block-container">
					' . $__templater->escape($__vars['catContent']) . '
				</div>
			</div>
		';
				} else {
					$__finalCompiled .= '
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_category', array(
						'category' => $__vars['category'],
						'content' => $__vars['catContent'],
					), $__vars) . '
		';
				}
				$__finalCompiled .= '
	';
			}
			$__finalCompiled .= '
';
		}
	}
	return $__finalCompiled;
}
);