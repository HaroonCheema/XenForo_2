<?php
// FROM HASH: 939655e521ace6c3f8462604e7f4392f
return array(
'macros' => array('tag_view_header' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'activePage' => '!',
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['tag']['tagess_wiki_tagline']) {
		$__finalCompiled .= '
		';
		$__templater->pageParams['pageDescription'] = $__templater->preEscaped('
			' . $__templater->escape($__vars['tag']['tagess_wiki_tagline']) . '
		');
		$__templater->pageParams['pageDescriptionMeta'] = false;
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	' . $__templater->callMacro(null, 'tag_view_pageaction', array(
		'tag' => $__vars['tag'],
	), $__vars) . '

	' . $__templater->callMacro(null, 'tab_view_wiki_above_tabs', array(
		'tag' => $__vars['tag'],
	), $__vars) . '

	' . $__templater->callMacro(null, 'tag_view_synonyms', array(
		'tag' => $__vars['tag'],
	), $__vars) . '

	' . $__templater->callMacro(null, 'tag_view_tabs', array(
		'activePage' => $__vars['activePage'],
		'tag' => $__vars['tag'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'tag_view_synonyms' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['tag']['Synonyms'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__templater->includeCss('avForumsTagEss_macros_tag_view_synonyms.less');
		$__finalCompiled .= '

		<ul class="listInline listInline--bullet listInline--synonyms">
			<li>
				<i class="fa fa-tags" aria-hidden="true" title="' . $__templater->filter('Synonyms', array(array('for_attr', array()),), true) . '"></i>
				<span class="u-srOnly">' . 'Synonyms' . '</span>

				';
		if ($__templater->isTraversable($__vars['tag']['Synonyms'])) {
			foreach ($__vars['tag']['Synonyms'] AS $__vars['synonym']) {
				$__finalCompiled .= '
					<a href="' . $__templater->func('link', array('tags', $__vars['synonym']['Tag'], ), true) . '" class="tagItem" dir="auto">' . $__templater->escape($__vars['synonym']['Tag']['tag']) . '</a>
				';
			}
		}
		$__finalCompiled .= '
			</li>
		</ul>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'tab_view_wiki_above_tabs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeCss('avForumsTagEss_macros_tab_view_wiki_above_tabs.less');
	$__finalCompiled .= '

	';
	if ($__vars['xf']['options']['tagess_wikidescriptiononpage'] AND $__vars['tag']['tagess_wiki_description']) {
		$__finalCompiled .= '
		<div class="tag-view tag-view--wiki-container">' . $__templater->func('bb_code', array($__vars['tag']['tagess_wiki_description'], 'tag_wiki', $__vars['tag'], ), true) . '</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'tag_view_tabs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'activePage' => '!',
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="tabs tabs--standalone">
		<div class="hScroller" data-xf-init="h-scroller">
			<span class="hScroller-scroll">
				<a class="tabs-tab ' . (($__vars['activePage'] === 'recentContent') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('tags', $__vars['tag'], ), true) . '">' . 'Recent contents' . '</a>

				';
	if ((!$__vars['xf']['options']['tagess_wikidescriptiononpage']) AND $__vars['tag']['tagess_wiki_description']) {
		$__finalCompiled .= '
					<a class="tabs-tab ' . (($__vars['activePage'] === 'viewInformation') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('tags/wiki', $__vars['tag'], ), true) . '">' . 'View information' . '</a>
				';
	}
	$__finalCompiled .= '

				';
	if ($__vars['xf']['options']['tagess_topUsers']) {
		$__finalCompiled .= '
					<a class="tabs-tab ' . (($__vars['activePage'] === 'topUsers') ? 'is-active' : '') . '" href="' . $__templater->func('link', array('tags/top-users', $__vars['tag'], ), true) . '">' . 'Top users' . '</a>
				';
	}
	$__finalCompiled .= '
			</span>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'tag_view_pageaction' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'tag' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['tag'], 'canWatch', array())) {
		$__compilerTemp1 .= '
			' . $__templater->button('
				' . 'Watch tag' . '
			', array(
			'href' => $__templater->func('link', array('tags/watch', $__vars['tag'], ), false),
			'class' => 'button--cta',
			'overlay' => 'true',
			'icon' => 'preview',
		), '', array(
		)) . '
		';
	}
	$__compilerTemp2 = '';
	if ($__templater->method($__vars['tag'], 'canEdit', array())) {
		$__compilerTemp2 .= '
			' . $__templater->button('
				' . 'Edit tag' . '
			', array(
			'href' => $__templater->func('link', array('tags/edit', $__vars['tag'], ), false),
			'class' => 'button--cta',
			'icon' => 'write',
		), '', array(
		)) . '
		';
	}
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '

		' . $__compilerTemp2 . '
	');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'item' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'watchedTag' => '!',
		'forum' => '',
		'forceRead' => false,
		'showWatched' => true,
		'allowInlineMod' => true,
		'chooseName' => '',
		'extraInfo' => '',
		'allowEdit' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__templater->includeCss('structured_list.less');
	$__finalCompiled .= '

	<div class="structItem structItem--thread js-tagListItem-' . $__templater->escape($__vars['watchedTag']['Tag']['tag_url']) . '">
		<div class="structItem-cell structItem-cell--main" data-xf-init="touch-proxy">
			<div class="structItem-title">
				<a href="' . $__templater->func('link', array('tags', $__vars['watchedTag']['Tag'], ), true) . '">' . $__templater->escape($__vars['watchedTag']['Tag']['tag']) . '</a>
			</div>

			<div class="structItem-minor">
				<ul class="structItem-extraInfo">
					';
	if ($__vars['watchedTag']['send_alert']) {
		$__finalCompiled .= '
						<li>' . 'Alert' . '</li>
					';
	}
	$__finalCompiled .= '

					';
	if ($__vars['watchedTag']['send_email']) {
		$__finalCompiled .= '
						<li>' . 'Email' . '</li>
					';
	}
	$__finalCompiled .= '

					<li>
						' . $__templater->formCheckBox(array(
		'standalone' => 'true',
	), array(array(
		'name' => 'tag_ids[]',
		'value' => $__vars['watchedTag']['Tag']['tag_id'],
		'class' => 'js-chooseItem',
		'_type' => 'option',
	))) . '
					</li>
				</ul>
			</div>
		</div>
		<div class="structItem-cell structItem-cell--latest">
			<a href="' . $__templater->func('link', array('threads/latest', $__vars['thread'], ), true) . '" rel="nofollow">' . $__templater->func('date_dynamic', array($__vars['watchedTag']['Tag']['last_use_date'], array(
		'class' => 'structItem-latestDate',
	))) . '</a>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);