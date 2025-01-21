<?php
// FROM HASH: 13176521ae0d99ebc961f5db1aef1df6
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('af_forumstats_stats.less');
	$__finalCompiled .= '

';
	$__templater->inlineCss('
	.forumStatsContainer .unit-replies .miniCol::after
	{
	content: "' . 'Replies' . '";
	}
	.forumStatsContainer .unit-views .miniCol::after
	{
	content: "' . 'Views' . '";
	}
	.forumStatsContainer .unit-likes .miniCol::after
	{
	content: "' . 'Likes' . '";
	}
	.forumStatsContainer .unit-posts .miniCol::after
	{
	content: "' . 'Posts' . '";
	}
	.forumStatsContainer .unit-threads .miniCol::after
	{
	content: "' . 'Threads' . '";
	}
	.forumStatsContainer .unit-score .miniCol::after
	{
	content: "' . 'Score' . '";
	}

	.forumStats-sidebar
	{
	width: ' . $__vars['xf']['options']['af_forumstats_left_width'] . '%;
	}
	.forumStats-main
	{
	width: ' . $__vars['xf']['options']['af_forumstats_main_width'] . '%;
	}
');
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['af_forumstats_invert_columns']) {
		$__finalCompiled .= '
	';
		$__templater->inlineCss('
		.forumStats-sidebar
		{
		-webkit-box-ordinal-group:3;
		-ms-flex-order:2;
		order:2;
		}
		.forumStats-main
		{
		-webkit-box-ordinal-group:2;
		-ms-flex-order:1;
		order:1;
		}
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

';
	$__templater->inlineJs('
	!function($, window, document)
	{
	"use strict";

	XF.ForumStatsClick = XF.Event.newHandler({
	eventNameSpace: \'XFForumStatsClick\',

	options: {
	container: \'.forumStatsContainer\',
	target: \'.js-forumStatsSidebar\',
	href: null,
	menuTrigger: \'#forumStats-left-menu-trigger\'
	},

	loaderTarget: null,
	container: null,
	href: null,
	loading: false,

	init() {
	const containerSelector = this.options.container;
	const container = containerSelector ? this.target.closest(containerSelector) : this.target;

	this.container = container;

	const targetSelector = this.options.target;
	const target = targetSelector ? XF.findRelativeIf(targetSelector, this.container) : container;

	if (target) {
	this.loaderTarget = target;
	} else {
	console.error(\'No loader target for\', this.target);
	return;
	}

	this.href = this.options.href || this.target.getAttribute(\'href\');

	if (!this.href) {
	console.error(\'No href for\', this.target);
	}
	},

	click(e) {

	e.preventDefault();

	if (this.loading) {
	return;
	}

	this.loading = true;

	const $clicked = $(this.target);
	const animate = $clicked.data(\'animate-replace\');
	$clicked.addClass(\'is-selected\')
	.siblings()
	.removeClass(\'is-selected\');

	$(this.options.menuTrigger).html($clicked.data(\'title\'));

	XF.ajax(\'get\', this.href, null)
	.then(response => {
	const { data } = response;

	if (data.html) {
	if (animate === \'true\' || animate === true) {
	$(\'.js-forumStatsSidebar\').slideUp(500, () => {
	XF.setupHtmlInsert(data.html, html => {
	$(\'.js-forumStatsSidebar\').html(html).fadeIn(500);
	});
	});
	} else {
	XF.setupHtmlInsert(data.html, html => {
	$(\'.js-forumStatsSidebar\').html(html);
	});
	}
	}
	})
	.finally(() => { this.loading = false });
	}
	});

	$(\'.forumStats-left-menu\').on(\'click\', \'[data-menu-closer]\', function(e) {
	var $this = $(this);

	$this.addClass(\'is-selected\').siblings().removeClass(\'is-selected\');
	$(\'#forumStats-left-menu-trigger\').html($this.data(\'title\'));
	});

	var refreshDelay = ' . $__vars['xf']['options']['af_forumstats_refreshTime'] . ';
	var autoRefreshInterval;

	$(function() {
	if ($(\'.forumStatsContainer\').hasClass(\'forumStats-shown\'))
	{
	checkAutoRefresh();
	}
	});

	var checkAutoRefresh = function()
	{
	var checked = $(\'.js-forumStats-autoRefresh\').is(\':checked\');

	if (checked)
	{
	resetAutoRefreshTimer();
	}
	else
	{
	clearAutoRefreshTimer();
	}

	XF.Cookie.set(\'forumstats_autorefresh\', checked ? 1 : 0);
	}

	var clearAutoRefreshTimer = function()
	{
	if (autoRefreshInterval)
	{
	clearInterval(autoRefreshInterval);
	}
	}

	var resetAutoRefreshTimer = function()
	{
	clearAutoRefreshTimer();
	autoRefreshInterval = setInterval(refresh, refreshDelay * 1000);
	}

	var refresh = function() {
	const $tabContainer = $(\'.forumStats-main .tabs\').first();
	const $panes = $(\'.forumStats-main .tabPanes\').children();
	const $activePane = $panes.filter(\'.is-active\');

	if ($activePane.length) {
	const href = $activePane.data(\'href-initial\');

	$(\'.tooltip.tooltip--preview\').hide();

	XF.ajax(\'get\', href, {}, function(data) {
	if (data.html) {
	XF.setupHtmlInsert(data.html, function($html) {
	$activePane.html($html);
	});
	}
	});
	}
	};

	$(\'.refreshNow\').on(\'click\', function(e) {
	e.preventDefault();
	checkAutoRefresh();
	refresh();
	});

	$(\'.js-forumStats-autoRefresh\').on(\'change\', function() {
	checkAutoRefresh();
	});

	$(\'.hideForumStats\').on(\'click\', function(e) {
	e.preventDefault();
	$(\'.forumStatsContainer\').removeClass(\'forumStats-shown\').addClass(\'forumStats-hidden\');
	clearAutoRefreshTimer();
	XF.Cookie.set(\'forumstats_show\', 0);
	});

	$(\'.showForumStats\').on(\'click\', function(e) {
	e.preventDefault();
	$(\'.forumStatsContainer\').removeClass(\'forumStats-hidden\').addClass(\'forumStats-shown\');
	checkAutoRefresh();
	refresh();
	XF.Cookie.set(\'forumstats_show\', 1);
	});

	XF.Event.register(\'click\',\'forum-stats\', \'XF.ForumStatsClick\');
	}
	(jQuery, window, document);
');
	$__finalCompiled .= '

';
	$__vars['showStats'] = (($__templater->method($__vars['xf']['request'], 'getCookie', array('forumstats_show', )) !== false) ? $__templater->method($__vars['xf']['request'], 'getCookie', array('forumstats_show', )) : true);
	$__finalCompiled .= '

<div class="forumStatsContainer ' . ($__vars['showStats'] ? 'forumStats-shown' : 'forumStats-hidden') . ' ' . ($__vars['xf']['options']['af_forumstats_mini_mode']['enabled'] ? 'forumStats-mini' : '') . ' ' . (($__vars['xf']['options']['af_forumstats_mini_mode']['enabled'] AND $__vars['xf']['options']['af_forumstats_mini_mode']['size']) ? ('forumStats-mini-' . $__templater->escape($__vars['xf']['options']['af_forumstats_mini_mode']['size'])) : '') . '">

	';
	if ($__vars['forumStats']['positions']['left'] AND ($__vars['xf']['options']['af_forumstats_left_width'] > 0)) {
		$__finalCompiled .= '
		';
		$__vars['first'] = $__vars['forumStats']['first']['left'];
		$__finalCompiled .= '
		<div class="block forumStats-sidebar forumStats-shown">
			<div class="block-container" style="">
				<div class="tabs--standalone">

					<a class="menuTrigger"
					   id="forumStats-left-menu-trigger"
					   data-xf-click="menu"
					   role="button"
					   tabindex="0"
					   aria-expanded="false"
					   aria-haspopup="true">' . $__templater->escape($__vars['first']['title']) . '</a>

					';
		$__vars['counter'] = '1';
		$__finalCompiled .= '

					<div class="menu forumStats-left-menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content u-jsOnly">
							';
		if ($__templater->isTraversable($__vars['forumStats']['positions']['left'])) {
			foreach ($__vars['forumStats']['positions']['left'] AS $__vars['stat_id'] => $__vars['forumStat']) {
				$__finalCompiled .= '
								<a class="menu-linkRow ' . (($__vars['counter'] == 1) ? 'is-selected' : '') . '" href="' . $__templater->func('link', array('forum-stats/results', $__vars['forumStat'], ), true) . '"
								   data-animate-replace="' . ($__vars['xf']['options']['af_forumstats_left_animate'] ? 'true' : 'false') . '"
								   data-xf-click="forum-stats"
								   rel="nofollow"
								   data-menu-closer="true"
								   data-replace=".js-forumStatsSidebar"
								   data-title="' . $__templater->escape($__vars['forumStat']['title']) . '">
									' . $__templater->escape($__vars['forumStat']['title']) . '
								</a>
								';
				$__vars['counter'] = ($__vars['counter'] + 1);
				$__finalCompiled .= '
							';
			}
		}
		$__finalCompiled .= '
						</div>
					</div>
				</div>

				';
		$__compilerTemp1 = $__vars;
		$__compilerTemp1['forumStat'] = $__vars['first'];
		$__finalCompiled .= $__templater->includeTemplate('af_forumstats_results', $__compilerTemp1) . '

			</div>

		</div>
	';
	}
	$__finalCompiled .= '


	';
	if ($__vars['forumStats']['positions']['main'] AND ($__vars['xf']['options']['af_forumstats_main_width'] > 0)) {
		$__finalCompiled .= '
		';
		$__vars['first'] = $__vars['forumStats']['first']['main'];
		$__finalCompiled .= '
		<div class="forumStats-main forumStats-shown">

			';
		$__vars['counter'] = '1';
		$__finalCompiled .= '

			<div class="tabs tabs--standalone" data-xf-init="tabs" role="tablist" style="margin-bottom: 0;">
				<div class="hScroller" data-xf-init="h-scroller">
					<span class="hScroller-scroll">
						';
		if ($__templater->isTraversable($__vars['forumStats']['positions']['main'])) {
			foreach ($__vars['forumStats']['positions']['main'] AS $__vars['stat_id'] => $__vars['forumStat']) {
				$__finalCompiled .= '
							<a class="tabs-tab forumStats-main-tab ' . (($__vars['counter'] == 1) ? 'is-active' : '') . '" role="tab" tabindex="0" aria-controls="forumstats-' . $__templater->escape($__vars['stat_id']) . '">' . $__templater->escape($__vars['forumStat']['title']) . '</a>
							';
				$__vars['counter'] = ($__vars['counter'] + 1);
				$__finalCompiled .= '
						';
			}
		}
		$__finalCompiled .= '
					</span>
				</div>
			</div>

			';
		$__vars['counter'] = '1';
		$__finalCompiled .= '

			<ul class="tabPanes block-container">
				';
		if ($__templater->isTraversable($__vars['forumStats']['positions']['main'])) {
			foreach ($__vars['forumStats']['positions']['main'] AS $__vars['stat_id'] => $__vars['forumStat']) {
				$__finalCompiled .= '
					';
				if ($__vars['counter'] == 1) {
					$__finalCompiled .= '
						<li class="is-active" role="tabpanel" id="forumstats-' . $__templater->escape($__vars['stat_id']) . '" data-href-initial="' . $__templater->func('link', array('forum-stats/results', $__vars['forumStat'], ), true) . '">
							';
					$__compilerTemp2 = $__vars;
					$__compilerTemp2['forumStat'] = $__vars['first'];
					$__finalCompiled .= $__templater->includeTemplate('af_forumstats_results', $__compilerTemp2) . '
						</li>
						';
				} else {
					$__finalCompiled .= '
						<li class="" role="tabpanel" id="forumstats-' . $__templater->escape($__vars['stat_id']) . '" data-href="' . $__templater->func('link', array('forum-stats/results', $__vars['forumStat'], ), true) . '" data-href-initial="' . $__templater->func('link', array('forum-stats/results', $__vars['forumStat'], ), true) . '">
							<div class="block-body block-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
						</li>
					';
				}
				$__finalCompiled .= '
					';
				$__vars['counter'] = ($__vars['counter'] + 1);
				$__finalCompiled .= '
				';
			}
		}
		$__finalCompiled .= '
			</ul>

		</div>
	';
	}
	$__finalCompiled .= '

	<div class="block-container forumStats-footer">
		<div class="block-footer">
			<div class="forumStats-shown">
				' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'value' => '1',
		'selected' => (($__templater->method($__vars['xf']['request'], 'getCookie', array('forumstats_autorefresh', )) !== false) ? $__templater->method($__vars['xf']['request'], 'getCookie', array('forumstats_autorefresh', )) : true),
		'class' => 'js-forumStats-autoRefresh',
		'label' => 'Auto-refresh' . ' (' . '' . $__templater->func('number', array($__vars['xf']['options']['af_forumstats_refreshTime'], ), true) . 's' . ')',
		'_type' => 'option',
	))) . '
				<a class="hideForumStats">' . $__templater->fontAwesome('fa-minus', array(
	)) . ' ' . 'Hide Stats' . '</a>
				<a class="refreshNow">' . $__templater->fontAwesome('fa-sync', array(
	)) . ' ' . 'Refresh Now' . '</a>
			</div>
			<div class="forumStats-hidden">
				<a class="showForumStats">' . $__templater->fontAwesome('fa-plus', array(
	)) . ' ' . 'Show Stats' . '</a>
			</div>
		</div>
	</div>


</div>';
	return $__finalCompiled;
}
);