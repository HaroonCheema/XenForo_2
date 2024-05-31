<?php
// FROM HASH: f8b869a6a54b3f8c373765f835f2345d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reviews');
	$__finalCompiled .= '

' . '

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
					' . $__templater->callMacro('fs_rating_review_macros', 'review', array(
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
		'link' => 'package-rating',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '

</div>';
	return $__finalCompiled;
}
);