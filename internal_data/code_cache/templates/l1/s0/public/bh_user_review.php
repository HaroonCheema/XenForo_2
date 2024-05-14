<?php
// FROM HASH: 3764082904f2178714c231c7c0e3ae84
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block" id="reviews">

	';
	$__vars['username'] = ($__vars['ownerPage'] ? $__vars['ownerPage']['User']['username'] : $__vars['xf']['visitor']['username']);
	$__finalCompiled .= '
		
		
	
	<div class="block-container">
		<div class="block-header">
			<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Review ' . '</h3>
			<div class="p-description">' . 'Read what TractorByNet members think about the ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Subcompact Tractor' . '</div>
		</div>
		<div class="block-body block-row block-row--separated">
			<div class="block-body">
				
				
				<span class="' . ($__vars['itemReview'] ? '' : ((('js-itemReview-' . $__templater->escape($__vars['item']['item_id'])) . '-') . $__templater->escape($__vars['xf']['visitor']['user_id']))) . '">
					';
	if (!$__templater->test($__vars['itemReview'], 'empty', array())) {
		$__finalCompiled .= '
						' . $__templater->callMacro('bh_item_review_macros', 'review_simple', array(
			'review' => $__vars['itemReview'],
			'item' => $__vars['item'],
		), $__vars) . '
						<br>
						<hr class="menu-separator menu-separator--hard" />
					';
	} else {
		$__finalCompiled .= '
						<div class="blockMessage">' . '' . $__templater->escape($__vars['username']) . ' has not posted a review yet.' . '</div>
					';
	}
	$__finalCompiled .= '
				</span>
				
				';
	if (!$__vars['ownerPage']) {
		$__finalCompiled .= '
					<div class="block-footer">
						<a href="' . $__templater->func('link', array('bh-item/rate', $__vars['item'], ), true) . '" class="bh_a button--link button" data-name="' . $__templater->escape($__vars['item']['item_title']) . '" data-xf-click="overlay" data-cache="false"><span class="button-text">' . 'Write a review  >' . '</span></a>
					</div>
				';
	} else if ($__vars['xf']['visitor']['user_id'] == $__vars['ownerPage']['user_id']) {
		$__finalCompiled .= '
					<div class="block-footer">
						<a href="' . $__templater->func('link', array('bh-item/rate', $__vars['item'], ), true) . '" class="bh_a button--link button" data-name="' . $__templater->escape($__vars['item']['item_title']) . '" data-xf-click="overlay" data-cache="false"><span class="button-text">' . 'Write a review  >' . '</span></a>
					</div>
				';
	}
	$__finalCompiled .= '
				
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);