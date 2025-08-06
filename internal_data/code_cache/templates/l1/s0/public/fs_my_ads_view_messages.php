<?php
// FROM HASH: 8c893215ab5b23d301ce852f6ad1a5c0
return array(
'macros' => array('viewMessages' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'value' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

	<div class="structItem structItem--conversation is-unread js-inlineModContainer" data-author="' . $__templater->escape($__vars['value']['thread']['User']['username']) . '">
		<div class="structItem-cell structItem-cell--icon">
			<div class="structItem-iconContainer">
				' . $__templater->func('avatar', array($__vars['value']['thread']['User'], 's', false, array(
		'defaultname' => $__vars['value']['thread']['User']['username'],
	))) . '
			</div>
		</div>
		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">

			<a href="' . $__templater->func('link', array('threads', $__vars['value']['thread'], ), true) . '" class="structItem-title" data-tp-primary="on">' . $__templater->escape($__vars['value']['thread']['title']) . '</a>

			<div class="structItem-minor">
				' . '

				<ul class="structItem-parts">
					<li>
						<ul class="listInline listInline--comma listInline--selfInline">
							<li>' . $__templater->func('username_link', array($__vars['value']['thread']['User'], false, array(
		'defaultname' => $__vars['value']['thread']['User']['username'],
		'title' => 'Conversation starter',
	))) . '</li>
						</ul>
					</li>
					<li class="structItem-startDate"><a href="' . $__templater->func('link', array('threads', $__vars['value']['thread'], ), true) . '" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['value']['thread']['post_date'], array(
	))) . '</a></li>
				</ul>

			</div>
		</div>
		<div class="structItem-cell structItem-cell--meta">
			<dl class="pairs pairs--justified">
				<dt>' . 'Replies' . '</dt>
				<dd>' . $__templater->filter($__vars['value']['unReadPostsCount'], array(array('number', array()),), true) . '</dd>
			</dl>
			<dl class="pairs pairs--justified structItem-minor">
				<dt>' . 'Participants' . '</dt>
				<dd>' . $__templater->filter($__vars['value']['participants'], array(array('number', array()),), true) . '</dd>
			</dl>
		</div>
		<div class="structItem-cell structItem-cell--latest">
			<a href="' . $__templater->func('link', array('threads', $__vars['value']['thread'], ), true) . '" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['value']['thread']['last_post_date'], array(
		'class' => 'structItem-latestDate',
	))) . '</a>
			<div class="structItem-minor">' . $__templater->func('username_link', array($__vars['value']['thread']['LastPost']['User'], false, array(
	))) . '</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('My ads messages');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

<div class="block" data-xf-init="inline-mod" data-type="conversation" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-outer">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'my-ad/messages',
		'params' => '',
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
	</div>

	<div class="block-container">

		<div class="block-body">
			';
	if (!$__templater->test($__vars['unreadThreads'], 'empty', array())) {
		$__finalCompiled .= '
				<div class="structItemContainer">
					';
		if ($__templater->isTraversable($__vars['unreadThreads'])) {
			foreach ($__vars['unreadThreads'] AS $__vars['value']) {
				$__finalCompiled .= '
						' . $__templater->callMacro(null, 'viewMessages', array(
					'value' => $__vars['value'],
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= '
				</div>
				
				<div class="block-footer">
					<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['unreadThreads'], $__vars['total'], ), true) . '</span>
				</div>
				';
	} else {
		$__finalCompiled .= '
				<div class="block-row">' . 'There are no messages to display.' . '</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'my-ad/messages',
		'params' => '',
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>

';
	return $__finalCompiled;
}
);