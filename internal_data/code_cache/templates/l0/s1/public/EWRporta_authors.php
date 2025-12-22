<?php
// FROM HASH: 3532f4065f2c357c422e27339bdb8594
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Authors');
	$__finalCompiled .= '

';
	$__templater->includeCss('message.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['authors'])) {
		foreach ($__vars['authors'] AS $__vars['author']) {
			$__finalCompiled .= '
	' . $__templater->callMacro('EWRporta_author_macros', 'author_block', array(
				'author' => $__vars['author'],
			), $__vars) . '
';
		}
	}
	$__finalCompiled .= '

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