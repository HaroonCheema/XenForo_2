<?php
// FROM HASH: 623cb310488dfc6bad698eff687edc3c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
	<div class="block-container">
		<h3 class="block-minorHeader">
			<a href="' . $__templater->func('link', array('game-rating/', ), true) . '" rel="nofollow">' . 'Latest Game Reviews' . '</a>
		</h3>
		<ul class="block-body">
			';
	if (!$__templater->test($__vars['reviews'], 'empty', array())) {
		$__finalCompiled .= '
				';
		if ($__templater->isTraversable($__vars['reviews'])) {
			foreach ($__vars['reviews'] AS $__vars['review']) {
				$__finalCompiled .= '
					<li class="block-row">
						' . $__templater->callMacro('fs_game_reviews_all_list_widget_macro', 'review', array(
					'review' => $__vars['review'],
				), $__vars) . '
					</li>
				';
			}
		}
		$__finalCompiled .= '
				';
	} else {
		$__finalCompiled .= '
				<li class="block-row block-row--minor">
					' . 'No results found.' . '
				</li>
			';
	}
	$__finalCompiled .= '
		</ul>
	</div>
</div>';
	return $__finalCompiled;
}
);