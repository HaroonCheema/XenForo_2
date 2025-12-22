<?php
// FROM HASH: 7bb1d959d472b01e7f9bfcde199db105
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__vars['xf']['options']['EWRporta_header']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['noH1'] = true;
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['EWRporta_title']) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['xf']['options']['EWRporta_title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
' . $__templater->callMacro('metadata_macros', 'description', array(
		'description' => ($__vars['xf']['options']['EWRporta_metadesc'] ? $__vars['xf']['options']['EWRporta_metadesc'] : $__vars['xf']['options']['boardDescription']),
	), $__vars) . '

';
	$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('<link rel="alternate" type="application/rss+xml"
	title="' . $__templater->filter('RSS feed for ' . ($__vars['xf']['options']['EWRporta_title'] ?: $__vars['xf']['options']['boardTitle']) . '', array(array('for_attr', array()),), true) . '"
	href="' . $__templater->func('link', array('ewr-porta/index.rss', '-', ), true) . '" />'));
	$__finalCompiled .= '

<div class="porta-articles-above-full">
	' . $__templater->widgetPosition('ewr_porta_articles_above_full', array(
		'page' => $__vars['page'],
	)) . '
</div>

<div class="porta-articles-above-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_above_split', array(
		'page' => $__vars['page'],
	)) . '
</div>

' . $__templater->callMacro('EWRporta_articles_macros', 'articles_block', array(
		'link' => 'ewr-porta',
		'articles' => $__vars['articles'],
		'catlinks' => $__vars['catlinks'],
		'attachments' => $__vars['attachments'],
		'page' => $__vars['page'],
		'perPage' => $__vars['perPage'],
		'total' => $__vars['total'],
	), $__vars) . '

<div class="porta-articles-below-full">
	' . $__templater->widgetPosition('ewr_porta_articles_below_full', array(
		'page' => $__vars['page'],
	)) . '
</div>

<div class="porta-articles-below-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_below_split', array(
		'page' => $__vars['page'],
	)) . '
</div>

';
	$__templater->modifySideNavHtml('_xfWidgetPositionSideNav1346f146a12942c3946ca89303967aec', $__templater->widgetPosition('ewr_porta_articles_sidenav', array(
		'page' => $__vars['page'],
	)), 'replace');
	$__finalCompiled .= '
';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarcffabbe32de0fd0663a24b66bda67336', $__templater->widgetPosition('ewr_porta_articles_sidebar', array(
		'page' => $__vars['page'],
	)), 'replace');
	return $__finalCompiled;
}
);