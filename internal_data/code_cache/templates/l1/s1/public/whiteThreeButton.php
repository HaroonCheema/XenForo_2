<?php
// FROM HASH: 7a341ba6ce6f31df2deab6e4a76f0bac
return array(
'macros' => array('link' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'content' => '!',
		'confirmUrl' => '!',
		'editText' => 'Remove Bookmark',
		'addText' => 'Bookmark',
		'showText' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
 
	';
	if ($__templater->method($__vars['content'], 'canBookmark', array())) {
		$__finalCompiled .= '

		';
		$__compilerTemp1 = '';
		if ($__templater->method($__vars['content'], 'isBookmarked', array())) {
			$__compilerTemp1 .= $__templater->escape($__vars['editText']);
		} else {
			$__compilerTemp1 .= $__templater->escape($__vars['addText']);
		}
		$__finalCompiled .= $__templater->button(trim('
			<span class="js-bookmarkText">' . $__compilerTemp1 . '</span>
		'), array(
			'href' => $__vars['confirmUrl'],
			'id' => 'white-button',
			'title' => ($__vars['showText'] ? '' : $__templater->filter('Bookmark', array(array('for_attr', array()),), false)),
			'data-xf-click' => 'bookmark-click',
			'data-label' => '.js-bookmarkText',
			'data-sk-bookmarked' => 'addClass:is-bookmarked, ' . $__templater->filter($__vars['editText'], array(array('for_attr', array()),), false),
			'data-sk-bookmarkremoved' => 'removeClass:is-bookmarked, ' . $__templater->filter($__vars['addText'], array(array('for_attr', array()),), false),
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
	$__finalCompiled .= '<div class="tab-white-button">
	

				';
	if ($__vars['alreadySub']) {
		$__finalCompiled .= '
				
					 ' . $__templater->button('Unsubscribe', array(
			'id' => 'white-button',
			'data-xf-click' => 'overlay',
			'href' => $__templater->func('link', array('bh-item/unsub', $__vars['item'], ), false),
		), '', array(
		)) . '
						';
	} else {
		$__finalCompiled .= '
					 ' . $__templater->button('Subscribe', array(
			'id' => 'white-button',
			'href' => $__templater->func('link', array('bh-item/itemsub', $__vars['item'], ), false),
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= '
	
	';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('bh_brand_hub', 'create_bookmark', )) AND $__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '

      	' . $__templater->callMacro(null, 'link', array(
			'content' => $__vars['item'],
			'confirmUrl' => $__templater->func('link', array('bh-item/bookmark', $__vars['item'], ), false),
		), $__vars) . '
	
	';
	}
	$__finalCompiled .= '
	

</div>
';
	return $__finalCompiled;
}
);