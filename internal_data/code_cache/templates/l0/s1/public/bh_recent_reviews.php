<?php
// FROM HASH: 1bd4ac6f8446383239fc7820ebc94ca8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Recent Reviews' . ' (' . $__templater->filter($__vars['total'], array(array('number', array()),), true) . ')');
	$__finalCompiled .= '

' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'bh-recent-reviews',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '

<div class="block">
	<div class="block-container">
		' . '
		<div class="block-body block-row block-row--separated">
			<div class="block-body">
				
				
				
				';
	if (!$__templater->test($__vars['itemReviews'], 'empty', array())) {
		$__finalCompiled .= '
							';
		if ($__templater->isTraversable($__vars['itemReviews'])) {
			foreach ($__vars['itemReviews'] AS $__vars['review']) {
				$__finalCompiled .= '
								' . $__templater->callMacro('bh_item_review_macros', 'review_simple', array(
					'review' => $__vars['review'],
					'route' => 'bh-item/review',
					'item' => $__vars['review']['Item'],
				), $__vars) . '
								<br>
							';
			}
		}
		$__finalCompiled .= '

					<div class="block-footer">
						<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['itemReviews'], $__vars['total'], ), true) . '</span>
					</div>
				';
	} else {
		$__finalCompiled .= '
					<div class="blockMessage">' . 'No results found.' . '</div>
				';
	}
	$__finalCompiled .= '
		
			</div>
		</div>
	</div>
</div>
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'bh-recent-reviews',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	)));
	return $__finalCompiled;
}
);