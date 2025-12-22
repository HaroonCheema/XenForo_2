<?php
// FROM HASH: 9118ed16fcf83cd76abeed5c315d6658
return array(
'extends' => function($__templater, array $__vars) { return $__vars['templateOverrides']['ewr_porta_thread_type']; },
'extensions' => array('ewr_porta_description' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	<ul class="listInline porta-listInline-right listInline--bullet">
		';
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__finalCompiled .= '
			<li>
				' . $__templater->fontAwesome('fa-hashtag', array(
			)) . '
				<span class="u-srOnly">' . 'Category' . '</span>
				<a href="' . $__templater->func('link', array('ewr-porta/categories', $__vars['category'], ), true) . '" class="u-concealed">
					' . $__templater->escape($__vars['category']['category_name']) . '</a>
			</li>	
		';
		}
	}
	$__finalCompiled .= '
	</ul>
';
	return $__finalCompiled;
},
'pinned_block_classes' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= 'porta-article ' . $__templater->renderExtensionParent($__vars, null, $__extensions);
	return $__finalCompiled;
},
'content_top' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	';
	$__templater->includeCss('EWRporta.less');
	$__finalCompiled .= '
	
	';
	if ($__vars['feature']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'metadata', array(
			'twitterCard' => 'summary_large_image',
			'imageUrl' => $__templater->func('base_url', array($__vars['feature']['image'], ), false),
		), $__vars) . '
	';
	} else if (($__vars['article']['article_icon']['type'] == 'medio') AND $__vars['article']['article_icon']['data']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'metadata', array(
			'twitterCard' => 'summary_large_image',
			'imageUrl' => $__templater->func('base_url', array($__vars['article']['article_icon']['data']['image'], ), false),
		), $__vars) . '
	';
	} else if (($__vars['article']['article_icon']['type'] == 'attach') AND $__vars['pinnedPost']['Attachments'][$__vars['article']['article_icon']['data']]) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'metadata', array(
			'twitterCard' => 'summary_large_image',
			'imageUrl' => $__templater->func('link', array('full:ewr-porta/attachments', $__vars['pinnedPost']['Attachments'][$__vars['article']['article_icon']['data']], ), false),
		), $__vars) . '
	';
	} else if (($__vars['article']['article_icon']['type'] == 'image') AND $__vars['xf']['options']['EWRporta_icon_external']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'metadata', array(
			'twitterCard' => 'summary_large_image',
			'imageUrl' => $__vars['article']['article_icon']['data'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	
	';
	$__templater->modifySidebarHtml('_xfWidgetPositionSidebarcd7b51ad85b2e3b59eabed7e8e7176f0', $__templater->widgetPosition('ewr_porta_article_sidebar', array(
		'thread' => $__vars['thread'],
		'author' => $__vars['author'],
	)), 'replace');
	$__finalCompiled .= '
	
	' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
';
	return $__finalCompiled;
},
'above_messages_below_pinned' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
		$__finalCompiled .= '
	' . $__templater->renderExtensionParent($__vars, null, $__extensions) . '
	
	';
	if ($__templater->method($__vars['thread'], 'showPortaAuthor', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro('EWRporta_author_macros', 'author_block', array(
			'author' => $__vars['thread']['FirstPost']['PortaAuthor'],
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . $__templater->renderExtension('ewr_porta_description', $__vars, $__extensions) . '

' . $__templater->renderExtension('pinned_block_classes', $__vars, $__extensions) . '

' . $__templater->renderExtension('content_top', $__vars, $__extensions) . '

' . $__templater->renderExtension('above_messages_below_pinned', $__vars, $__extensions);
	return $__finalCompiled;
}
);