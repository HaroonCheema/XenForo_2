<?php
// FROM HASH: d9fcdc6997d247d4ee7b554ae56122db
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Receive Ratings');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '
<div class="block-container brivium-receive-ratings">
	';
	if (!$__templater->test($__vars['ratings'], 'empty', array())) {
		$__finalCompiled .= '
		<ol class="block-body js-briviumReceiveRatings">
			';
		if ($__templater->isTraversable($__vars['ratings'])) {
			foreach ($__vars['ratings'] AS $__vars['rating']) {
				$__finalCompiled .= '
				<li class="block-row block-row--separated' . ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['rating']['user_id'], )) ? ' is-ignored' : '') . '">
					' . $__templater->callMacro('BRATR_rating_macros', 'review', array(
					'review' => $__vars['rating'],
					'user' => $__templater->method($__vars['rating'], 'getUser', array()),
					'thread' => $__vars['rating']['Thread'],
				), $__vars) . '
				</li>
			';
			}
		}
		$__finalCompiled .= '
		</ol>

		<div class="block-outer block-outer--after">
			' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer-opposite block-footer',
		))) . '
		</div>
		';
		if ($__vars['loadMore']) {
			$__finalCompiled .= '
			<div class="block-footer js-briviumLoadMore">
				<span class="block-footer-controls">' . $__templater->button('
					' . 'Load More' . '
				', array(
				'href' => $__templater->func('link', array('members/bratr-ratings', $__vars['user'], array('page' => $__vars['page'] + 1, ), ), false),
				'data-xf-click' => 'inserter',
				'data-append' => '.js-briviumReceiveRatings',
				'data-replace' => '.js-briviumLoadMore',
			), '', array(
			)) . '</span>
			</div>
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		<div class="block-body block-row">' . 'No results found.' . '</div>
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);