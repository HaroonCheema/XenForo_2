<?php
// FROM HASH: 8cc58e2343b87f0785d80c971524345d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reviews');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Leave Rating', array(
		'href' => $__templater->func('link', array('game-rating/add', ), false),
		'icon' => 'rate',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">

	<div class="block-container">
		<div class="block-body">
			';
	if (!$__templater->test($__vars['reviews'], 'empty', array())) {
		$__finalCompiled .= '
				';
		if ($__templater->isTraversable($__vars['reviews'])) {
			foreach ($__vars['reviews'] AS $__vars['review']) {
				$__finalCompiled .= '
					' . $__templater->callMacro('fs_game_rating_review_macros', 'review', array(
					'review' => $__vars['review'],
				), $__vars) . '
				';
			}
		}
		$__finalCompiled .= '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
						>
				</div>
				';
	} else {
		$__finalCompiled .= '
				<div class="blockMessage">
					' . 'No items have been created yet.' . '
				</div>
			';
	}
	$__finalCompiled .= '
		</div>

	</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'game-rating',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '

</div>';
	return $__finalCompiled;
}
);