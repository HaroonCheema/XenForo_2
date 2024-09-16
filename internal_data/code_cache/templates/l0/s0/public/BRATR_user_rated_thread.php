<?php
// FROM HASH: 3bd8e10cc8b6a8af91852fccbd453a02
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('User rated thread' . ' - ' . $__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<ol class="block-body js-briviumReceiveRatings">
			';
	if ($__templater->isTraversable($__vars['ratings'])) {
		foreach ($__vars['ratings'] AS $__vars['rating']) {
			$__finalCompiled .= '
				<li class="block-row block-row--separated' . ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['rating']['user_id'], )) ? ' is-ignored' : '') . '" data-author="' . $__templater->filter($__templater->arrayKey($__templater->method($__vars['rating'], 'getUser', array()), 'username'), array(array('for_attr', array()),), true) . '">
					';
			$__vars['ratingStarHtml'] = $__templater->preEscaped('
						' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
				'rating' => $__vars['rating']['rating'],
			), $__vars) . '
					');
			$__finalCompiled .= '
					' . $__templater->callMacro('member_list_macros', 'item', array(
				'user' => $__templater->method($__vars['rating'], 'getUser', array()),
				'extraData' => $__templater->filter($__vars['ratingStarHtml'], array(array('raw', array()),), false),
			), $__vars) . '
				</li>
			';
		}
	}
	$__finalCompiled .= '
		</ol>

		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['ratings'], $__vars['total'], ), true) . '</span>
		</div>
		
		';
	if ($__vars['loadMore']) {
		$__finalCompiled .= '
			<div class="block-outer-opposite js-briviumLoadMore">
				<span class="block-footer-controls">' . $__templater->button('
					' . 'Load More' . '
				', array(
			'href' => $__templater->func('link', array('threads/br-user-rated', $__vars['thread'], array('page' => $__vars['page'] + 1, ), ), false),
			'data-xf-click' => 'inserter',
			'data-append' => '.js-briviumReceiveRatings',
			'data-replace' => '.js-briviumLoadMore',
		), '', array(
		)) . '</span>
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
	' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite block-outer block-outer--after',
	))) . '
</div>';
	return $__finalCompiled;
}
);