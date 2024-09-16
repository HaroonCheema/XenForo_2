<?php
// FROM HASH: 695981731e6255f80274bb8644cf4868
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['ratings'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">
				<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
			</h3>
			<div class="block-body js-replyNewMessageContainer">
				';
		if ($__templater->isTraversable($__vars['ratings'])) {
			foreach ($__vars['ratings'] AS $__vars['rating']) {
				$__finalCompiled .= '
					<hr class="formRowSep" />
					<div class="block-row">
						' . $__templater->callMacro('BRATR_rating_macros', 'item_new_ratings', array(
					'rating' => $__vars['rating'],
					'user' => $__templater->method($__vars['rating'], 'getUser', array()),
				), $__vars) . '
					</div>
				';
			}
		}
		$__finalCompiled .= '
			</div>
			';
		if ($__vars['hasMore']) {
			$__finalCompiled .= '
				<div class="block-footer">
					<span class="block-footer-controls">
						' . $__templater->button('View more' . $__vars['xf']['language']['ellipsis'], array(
				'href' => $__vars['link'],
				'rel' => 'nofollow',
			), '', array(
			)) . '
					</span>
				</div>
			';
		}
		$__finalCompiled .= '
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);