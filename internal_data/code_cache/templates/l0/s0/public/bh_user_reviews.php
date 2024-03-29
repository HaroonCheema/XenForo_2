<?php
// FROM HASH: 6a11de4d382323f5c2b36fd3a26d6ed6
return array(
'macros' => array('ratingBar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'number' => '!',
		'percentage' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="side">
		<div>' . $__templater->escape($__vars['number']) . ' <span class="fa fa-star checked ratingStars--smaller"></span></div>
	</div>
	<div class="middle" >
		<div class="bar-container">
			<div class="bar" style="width:' . $__templater->escape($__vars['percentage']) . '%;"></div>
		</div>
	</div>
	<div class="side right">
		<div>' . $__templater->escape($__vars['percentage']) . ' %</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('bh_brandHub_list.less');
	$__finalCompiled .= '

<div class="block" id="reviews">
	<div class="block-container">
		<div class="block-header">
			<h3 class="block-minorHeader">' . 'User Reviews' . ' (' . $__templater->filter($__vars['item']['rating_count'], array(array('number', array()),), true) . ')</h3>
			<div class="p-description">' . 'Read what TractorByNet members think about the ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Subcompact Tractor' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">

				<div class="reviewStarsDiv">
					<strong>' . $__templater->filter($__vars['item']['rating_avg'], array(array('number', array(1, )),), true) . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['item']['rating_avg'],
	), $__vars) . '</strong>  <br/><br/>

					<a href="' . $__templater->func('link', array('bh-item/rate', $__vars['item'], ), true) . '" class="bh_a" data-name="' . $__templater->escape($__vars['item']['item_title']) . '" data-xf-click="overlay">' . 'Write a review  >' . '</a><br />
					<a href="' . $__templater->func('link', array('bh-item/reviews', $__vars['item'], ), true) . '" target="_blank" class="bh_a" data-name="' . $__templater->escape($__vars['item']['item_title']) . '">' . 'View all ' . $__templater->escape($__vars['item']['review_count']) . ' reviews' . '</a>
				</div>
				<div class="ratingBarsDiv">
					';
	$__vars['i'] = 0;
	if ($__templater->isTraversable($__vars['itemRatings'])) {
		foreach ($__vars['itemRatings'] AS $__vars['key'] => $__vars['itemRating']) {
			$__vars['i']++;
			$__finalCompiled .= '		
						' . $__templater->callMacro(null, 'ratingBar', array(
				'number' => $__vars['key'],
				'percentage' => $__vars['itemRating'],
			), $__vars) . '
					';
		}
	}
	$__finalCompiled .= '
				</div>
				<div class="clearfix"></div>
				
			<div class="block-row block-row--separated"></div>
			
				';
	$__templater->includeJs(array(
		'src' => 'BrandHub/brand_hub.js',
	));
	$__finalCompiled .= '
				<div data-xf-init="xb-bh-pagenav">
					<div class="block">
						<div class="block-container">
							' . $__templater->callMacro('bh_overview_macros', 'list_filter_bar', array(
		'filters' => $__vars['filters'],
		'baseLinkPath' => 'bh-item/reviews',
		'content' => $__vars['item'],
	), $__vars) . '
							
							<div class="bloc block-row block-row--separated">
								' . $__templater->callMacro('bh_item_reviews', 'item_reviews', array(
		'item' => $__vars['item'],
		'itemReviews' => $__vars['itemReviews'],
		'visitorReview' => $__vars['visitorReview'],
		'page' => $__vars['page'],
		'perPage' => $__vars['perPage'],
		'total' => $__vars['total'],
		'filters' => $__vars['filters'],
	), $__vars) . '
							</div>
						</div>
					</div>
				</div>
				
				<div class="block-footer">
					' . '
					
					<a href="' . $__templater->func('link', array('bh-item/rate', $__vars['item'], ), true) . '" class="bh_a button--link button" data-name="' . $__templater->escape($__vars['item']['item_title']) . '" data-xf-click="overlay" data-cache="false"><span class="button-text">' . 'Write a review  >' . '</span></a>
				</div>
				
		
		';
	$__templater->modifySidebarHtml(null, '
			<div class="block">
				<div class="block-container">
					' . $__templater->renderWidget('bh_highest_rated_items', array(), array()) . '
				</div>
			</div>
		', 'replace');
	$__finalCompiled .= '
		
		
		';
	$__templater->modifySidebarHtml('', '
			' . $__templater->callMacro('bh_brand_hub_macros', 'brandRelatedLinks', array(
		'brandObj' => $__vars['item']['Brand'],
	), $__vars) . '
		', 'replace');
	$__finalCompiled .= '
		
		</div>
	</div>
</div>


';
	return $__finalCompiled;
}
);