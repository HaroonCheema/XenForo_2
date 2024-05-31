<?php
// FROM HASH: 6b0c4942fd67aa0f689e6fb9992dc836
return array(
'macros' => array('review' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'review' => '!',
		'showResource' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'xf/comment.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	<div class="contentRow">

		<div class="contentRow-figure">
			' . $__templater->func('avatar', array($__vars['review']['User'], 'xxs', false, array(
		'defaultname' => $__vars['review']['User']['username'],
	))) . '
		</div>

		<div class="contentRow-main contentRow-main--close">

			<a href="' . $__templater->func('link', array('game-rating', $__vars['review'], ), true) . '">' . $__templater->escape($__vars['review']['Game']['title']) . '</a>

			<div>
				' . $__templater->callMacro('rating_macros', 'stars', array(
		'rating' => $__vars['review']['rating'],
		'class' => 'ratingStars--smaller',
	), $__vars) . '
			</div>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>' . $__templater->escape($__vars['review']['User']['username']) . '</li>
					<li>' . $__templater->func('date_dynamic', array($__vars['review']['rating_date'], array(
	))) . '</li>
				</ul>
			</div>

			<div class="contentRow-minor contentRow-minor--hideLinks">
				' . $__templater->escape($__vars['review']['message']) . '
			</div>

		</div>
	</div>

';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);