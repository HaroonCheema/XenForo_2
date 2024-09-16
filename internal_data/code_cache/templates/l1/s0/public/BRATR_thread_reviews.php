<?php
// FROM HASH: d710cb7347b07259b5e5f234f01d7891
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread']['Forum'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

';
	if (!$__vars['resource']) {
		$__finalCompiled .= '
	<div class="tabs tabs--standalone">
		<div class="hScroller" data-xf-init="h-scroller">
			<span class="hScroller-scroll">
				<a class="tabs-tab ' . ((!$__vars['selected']) ? 'is-active' : '') . '" href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . 'Discussion' . '</a>
				<a class="tabs-tab ' . (($__vars['selected'] == 'br-reviews') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('threads/br-reviews', $__vars['thread'], ), true) . '">' . 'Discussion Reviews (' . $__templater->filter($__vars['thread']['brivium_review_counter'], array(array('number', array()),), true) . ')' . '</a>
			</span>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	' . $__templater->includeTemplate('xfrm_thread_insert', $__vars) . '
';
	}
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		' . $__templater->callMacro('BRATR_rating_macros', 'review_list', array(
		'reviews' => $__vars['ratings'],
		'linkThread' => false,
	), $__vars) . '

		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['ratings'], $__vars['total'], ), true) . '</span>
		</div>
	</div>
	' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite block-outer block-outer--after',
	))) . '
	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'threads/br-reviews',
		'data' => $__vars['thread'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '	
</div>';
	return $__finalCompiled;
}
);