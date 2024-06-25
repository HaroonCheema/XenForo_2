<?php
// FROM HASH: d3e3f9c839262b2591f1ac13fe7adff4
return array(
'macros' => array('item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'content' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['content'], 'hasOption', array('nfGift', ))) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
					';
		if ($__templater->method($__vars['content'], 'canGiftTo', array())) {
			$__compilerTemp1 .= '
						<a href="' . $__templater->func('link', array($__vars['content']['giftRoute'], $__vars['content'], ), true) . '" class="actionBar-action actionBar-action--gift" data-xf-click="overlay">' . 'Gift' . '</a>

						';
			if ($__templater->method($__vars['content'], 'canViewGiftsList', array()) AND $__vars['content']['GiftCount']) {
				$__compilerTemp1 .= '
							(<a href="' . $__templater->func('link', array($__vars['content']['giftsRoute'], $__vars['content'], ), true) . '" data-xf-click="overlay">' . (($__vars['content']['GiftCount'] == 1) ? 'Gifted once' : 'Gifted ' . $__templater->escape($__vars['content']['GiftCount']) . ' times') . '</a>)
						';
			}
			$__compilerTemp1 .= '
					';
		} else if ($__templater->method($__vars['content'], 'canViewGiftsList', array()) AND $__vars['content']['GiftCount']) {
			$__compilerTemp1 .= '
						<a href="' . $__templater->func('link', array($__vars['content']['giftsRoute'], $__vars['content'], ), true) . '" class="actionBar-action actionBar-action--gift" data-xf-click="overlay">' . (($__vars['content']['GiftCount'] == 1) ? 'Gifted once' : 'Gifted ' . $__templater->escape($__vars['content']['GiftCount']) . ' times') . '</a>
					';
		}
		$__compilerTemp1 .= '
				';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
			<span class="item">
				' . $__compilerTemp1 . '
			</span>
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'user_control' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__templater->func('callable', array($__vars['user'], 'canGiftTo', ), false) AND $__templater->method($__vars['user'], 'canGiftTo', array())) {
		$__finalCompiled .= '
		' . $__templater->button('Gift', array(
			'href' => $__templater->func('link', array('members/gift', $__vars['user'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'overlay',
		), '', array(
		)) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);