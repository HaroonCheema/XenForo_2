<?php
// FROM HASH: 57b091720c3d20f1dce0543b11d82855
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

			<a href="' . $__templater->func('link', array('account/upgrades', $__vars['review'], ), true) . '">' . $__templater->escape($__vars['review']['Upgrade']['title']) . '</a>

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
				' . (($__templater->func('strlen', array($__vars['review']['message'], ), false) > 70) ? $__templater->func('snippet', array($__vars['review']['message'], 70, array('stripBbCode' => true, ), ), true) : $__templater->escape($__vars['review']['message'])) . '
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