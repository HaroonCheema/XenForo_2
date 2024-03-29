<?php
// FROM HASH: 10f0c594ce879f920507f306a16d5573
return array(
'macros' => array('item_reviews' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
		'itemReviews' => '!',
		'visitorReview' => '',
		'page' => '!',
		'perPage' => '!',
		'total' => '!',
		'filters' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'bh-item/reviews',
		'data' => $__vars['item'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer',
		'perPage' => $__vars['perPage'],
	))) . '
	<div class="block-body block-row"></div>
	
	';
	if ($__vars['visitorReview']) {
		$__finalCompiled .= '
		<h6 class="block-row block-row--separated">' . 'Your ' . $__templater->escape($__vars['item']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' review' . '</h6><br>
		' . $__templater->callMacro('bh_item_review_macros', 'review_simple', array(
			'review' => $__vars['visitorReview'],
			'item' => $__vars['item'],
		), $__vars) . '
		
		<h6 class="block-row block-row--separated">' . 'Most recent ' . $__templater->escape($__vars['item']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' reviews' . '</h6><br>
	';
	} else {
		$__finalCompiled .= '
		<span class="js-itemReview-' . $__templater->escape($__vars['item']['item_id']) . '-' . $__templater->escape($__vars['xf']['visitor']['user_id']) . '"></span>
	';
	}
	$__finalCompiled .= '
	
	';
	if (!$__templater->test($__vars['itemReviews'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->isTraversable($__vars['itemReviews'])) {
			foreach ($__vars['itemReviews'] AS $__vars['review']) {
				$__finalCompiled .= '
			' . $__templater->callMacro('bh_item_review_macros', 'review_simple', array(
					'review' => $__vars['review'],
					'item' => $__vars['item'],
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

	
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'bh-item/reviews',
		'data' => $__vars['item'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
	
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Reviews');
	$__finalCompiled .= '
';
	$__templater->breadcrumbs($__templater->method($__vars['item'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '


<div class="block">
	' . '
	
	<div class="block-container">
		' . $__templater->callMacro('bh_overview_macros', 'list_filter_bar', array(
		'filters' => $__vars['filters'],
		'baseLinkPath' => 'bh-item/reviews',
		'content' => $__vars['item'],
	), $__vars) . '
		
		' . '
		<div class="block-body block-row block-row--separated">
				
			' . $__templater->callMacro(null, 'item_reviews', array(
		'item' => $__vars['item'],
		'itemReviews' => $__vars['itemReviews'],
		'page' => $__vars['page'],
		'perPage' => $__vars['perPage'],
		'total' => $__vars['total'],
		'filters' => $__vars['filters'],
	), $__vars) . '
		</div>
	</div>
</div>


';
	return $__finalCompiled;
}
);