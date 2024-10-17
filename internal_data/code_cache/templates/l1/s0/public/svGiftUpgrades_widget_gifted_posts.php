<?php
// FROM HASH: 8454b68a143417385f01da516fac9cb5
return array(
'macros' => array('item_post' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'snippetLength' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'item_post_simple', array(
		'post' => $__vars['post'],
		'snippetLength' => $__vars['snippetLength'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'item_post_simple' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'post' => '!',
		'snippetLength' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
	<div class="contentRow ' . ($__templater->method($__vars['post'], 'isIgnored', array()) ? ' is-ignored' : '') . ($__templater->method($__vars['post'], 'isUnread', array()) ? ' is-unread' : '') . '" data-author="' . ($__templater->escape($__vars['post']['User']['username']) ?: $__templater->escape($__vars['post']['username'])) . '" data-content="post-' . $__templater->escape($__vars['post']['post_id']) . '">
		<div class="contentRow-main">
			<h3 class="contentRow-title">
				<a href="' . $__templater->func('link', array('threads/post', $__vars['post']['Thread'], array('post_id' => $__vars['post']['post_id'], ), ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['post']['Thread'], ), true) . $__templater->escape($__vars['post']['Thread']['title']) . '</a>
			</h3>
			';
	if ($__vars['snippetLength'] > 0) {
		$__finalCompiled .= '
				<div class="contentRow-snippet">' . $__templater->func('snippet', array($__vars['post']['message'], $__vars['snippetLength'], array('stripQuote' => true, ), ), true) . '</div>
			';
	}
	$__finalCompiled .= '
			<div class="contentRow-minor contentRow-minor--smaller contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>' . 'Posted by' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->func('username_link', array($__vars['post']['User'], false, array(
		'defaultname' => $__vars['post']['username'],
		'class' => 'u-concealed',
	))) . '</li>
					<li>' . $__templater->func('date_dynamic', array($__vars['post']['post_date'], array(
	))) . '</li>
				</ul>				
			</div>
			<div class="contentRow-minor contentRow-minor--smaller contentRow-minor--hideLinks">
				<ul class="listInline listInline--bullet">
					<li>' . 'Forum' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('forums', $__vars['post']['Thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['post']['Thread']['Forum']['title']) . '</a></li>
				</ul>				
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
	if (!$__templater->test($__vars['posts'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>		
		<div class="block-container">
			';
		if ($__vars['style'] == 'full') {
			$__finalCompiled .= '
				<h3 class="block-header">				
					';
			if ($__vars['link']) {
				$__finalCompiled .= '
						<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
					';
			} else {
				$__finalCompiled .= '
						<span>' . $__templater->escape($__vars['title']) . '</span>
					';
			}
			$__finalCompiled .= '
				</h3>
				<div class="block-body">
					<div class="structItemContainer">
						';
			if ($__templater->isTraversable($__vars['posts'])) {
				foreach ($__vars['posts'] AS $__vars['post']) {
					$__finalCompiled .= '
							' . $__templater->callMacro(null, 'item_post', array(
						'post' => $__vars['post'],
						'snippetLength' => $__vars['snippetLength'],
					), $__vars) . '
						';
				}
			}
			$__finalCompiled .= '
					</div>
				</div>
				';
			if ($__vars['hasMore'] AND $__vars['link']) {
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
			';
		} else {
			$__finalCompiled .= '
				<h3 class="block-minorHeader">
					';
			if ($__vars['link']) {
				$__finalCompiled .= '
						<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
					';
			} else {
				$__finalCompiled .= '
						<span>' . $__templater->escape($__vars['title']) . '</span>
					';
			}
			$__finalCompiled .= '
				</h3>
				<ul class="block-body">
					';
			if ($__templater->isTraversable($__vars['posts'])) {
				foreach ($__vars['posts'] AS $__vars['post']) {
					$__finalCompiled .= '
						<li class="block-row">
							' . $__templater->callMacro(null, 'item_post_simple', array(
						'post' => $__vars['post'],
						'snippetLength' => $__vars['snippetLength'],
					), $__vars) . '
						</li>
					';
				}
			}
			$__finalCompiled .= '
				</ul>
			';
		}
		$__finalCompiled .= '
		</div>
	</div>
';
	}
	$__finalCompiled .= '


' . '

';
	return $__finalCompiled;
}
);