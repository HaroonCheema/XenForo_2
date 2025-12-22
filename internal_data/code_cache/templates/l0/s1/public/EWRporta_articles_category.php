<?php
// FROM HASH: 83efd202ac510e2257a67a7c14de6efe
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['category']['category_name']));
	$__finalCompiled .= '
';
	$__templater->pageParams['pageDescription'] = $__templater->preEscaped($__templater->escape($__vars['category']['category_description']));
	$__templater->pageParams['pageDescriptionMeta'] = true;
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'rss_forum', $__templater->preEscaped('<link rel="alternate" type="application/rss+xml"
	title="' . $__templater->filter('RSS feed for ' . $__vars['category']['category_name'] . '', array(array('for_attr', array()),), true) . '"
	href="' . $__templater->func('link', array('ewr-porta/categories/index.rss', $__vars['category'], ), true) . '" />'));
	$__finalCompiled .= '

<div class="porta-articles-above-full">
	' . $__templater->widgetPosition('ewr_porta_articles_above_full', array(
		'page' => $__vars['page'],
		'category' => $__vars['category'],
	)) . '
</div>

<div class="porta-articles-above-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_above_split', array(
		'page' => $__vars['page'],
		'category' => $__vars['category'],
	)) . '
</div>

' . $__templater->callMacro('EWRporta_articles_macros', 'articles_block', array(
		'link' => 'ewr-porta/categories',
		'data' => $__vars['category'],
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
		'category' => $__vars['category'],
	)) . '
</div>

<div class="porta-articles-below-split porta-widgets-split">
	' . $__templater->widgetPosition('ewr_porta_articles_below_split', array(
		'page' => $__vars['page'],
		'category' => $__vars['category'],
	)) . '
</div>

';
	$__templater->modifySideNavHtml('_xfWidgetPositionSideNavb124db82d06319030e9455c0abbbbff3', $__templater->widgetPosition('ewr_porta_articles_sidenav', array(
		'page' => $__vars['page'],
		'category' => $__vars['category'],
	)), 'replace');
	$__finalCompiled .= '
';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebar3eb396f4812f7b3eca77a96732eea425', $__templater->widgetPosition('ewr_porta_articles_sidebar', array(
		'page' => $__vars['page'],
		'category' => $__vars['category'],
	)), 'replace');
	return $__finalCompiled;
}
);