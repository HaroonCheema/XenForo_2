<?php
// FROM HASH: bf0c5a3a541117e5aeacdc2adb1a3d3b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['author']['author_name']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->escape($__vars['author']['author_status']));
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('<link rel="alternate" type="application/rss+xml"
	title="' . $__templater->filter('RSS feed for ' . $__vars['author']['author_name'] . '', array(array('for_attr', array()),), true) . '"
	href="' . $__templater->func('link', array('ewr-porta/authors/index.rss', $__vars['author'], ), true) . '" />'));
	$__finalCompiled .= '

<div class="porta-articles-above-full">
	' . $__templater->widgetPosition('ewr_porta_articles_above_full', array(
		'page' => $__vars['page'],
		'author' => $__vars['author'],
	)) . '
</div>

<div class="porta-articles-above-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_above_split', array(
		'page' => $__vars['page'],
		'author' => $__vars['author'],
	)) . '
</div>

' . $__templater->callMacro('EWRporta_author_macros', 'author_block', array(
		'author' => $__vars['author'],
	), $__vars) . '

' . $__templater->callMacro('EWRporta_articles_macros', 'articles_block', array(
		'link' => 'ewr-porta/authors',
		'data' => $__vars['author'],
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
		'author' => $__vars['author'],
	)) . '
</div>

<div class="porta-articles-below-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_below_split', array(
		'page' => $__vars['page'],
		'author' => $__vars['author'],
	)) . '
</div>

';
	$__templater->modifySideNavHtml('_xfWidgetPositionSideNav4f9ac1ef2dcd476a9237588b26a31a10', $__templater->widgetPosition('ewr_porta_articles_sidenav', array(
		'page' => $__vars['page'],
		'author' => $__vars['author'],
	)), 'replace');
	$__finalCompiled .= '
';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarf44bdbc751c382b1c781476760b57d3b', $__templater->widgetPosition('ewr_porta_articles_sidebar', array(
		'page' => $__vars['page'],
		'author' => $__vars['author'],
	)), 'replace');
	return $__finalCompiled;
}
);