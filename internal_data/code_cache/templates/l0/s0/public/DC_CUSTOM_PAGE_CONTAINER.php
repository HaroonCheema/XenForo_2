<?php
// FROM HASH: 740c5540baaf9e850f8dd77db0b0b7fc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<!DOCTYPE html>
<html id="XF" lang="' . $__templater->escape($__vars['xf']['language']['language_code']) . '" dir="' . $__templater->escape($__vars['xf']['language']['text_direction']) . '"
	data-app="public"
	data-template="' . $__templater->escape($__vars['template']) . '"
	data-container-key="' . $__templater->escape($__vars['containerKey']) . '"
	data-content-key="' . $__templater->escape($__vars['contentKey']) . '"
	data-logged-in="' . ($__vars['xf']['visitor']['user_id'] ? 'true' : 'false') . '"
	data-cookie-prefix="' . $__templater->escape($__vars['xf']['cookie']['prefix']) . '"
	data-csrf="' . $__templater->filter($__templater->func('csrf_token', array(), false), array(array('escape', array('js', )),), true) . '"
	class="has-no-js ' . ($__vars['template'] ? ('template-' . $__templater->escape($__vars['template'])) : '') . '"
	' . ($__vars['xf']['runJobs'] ? ' data-run-jobs=""' : '') . '>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

	';
	$__vars['siteName'] = $__vars['xf']['options']['boardTitle'];
	$__finalCompiled .= '
	';
	$__vars['h1'] = $__templater->preEscaped($__templater->func('page_h1', array($__vars['siteName'])));
	$__finalCompiled .= '
	';
	$__vars['description'] = $__templater->preEscaped($__templater->func('page_description'));
	$__finalCompiled .= '


	<title>' . $__templater->func('page_title', array('%s | %s', $__vars['xf']['options']['boardTitle'], $__vars['pageNumber'])) . '</title>

	
		' . '

	<link rel="manifest" href="' . $__templater->func('base_url', array('webmanifest.php', ), true) . '">
	';
	if ($__templater->func('property', array('metaThemeColor', ), false)) {
		$__finalCompiled .= '
		<meta name="theme-color" content="' . $__templater->func('parse_less_color', array($__templater->func('property', array('metaThemeColor', ), false), ), true) . '" />
	';
	}
	$__finalCompiled .= '

	<meta name="apple-mobile-web-app-title" content="' . ($__templater->escape($__vars['xf']['options']['boardShortTitle']) ?: $__templater->escape($__vars['xf']['options']['boardTitle'])) . '">
	';
	if ($__templater->func('property', array('publicIconUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="apple-touch-icon" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicIconUrl', true, ), false), ), true) . '">
	';
	} else if ($__templater->func('property', array('publicMetadataLogoUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="apple-touch-icon" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicMetadataLogoUrl', ), false), ), true) . '" />
	';
	}
	$__finalCompiled .= '

	';
	if ($__templater->isTraversable($__vars['head'])) {
		foreach ($__vars['head'] AS $__vars['headTag']) {
			$__finalCompiled .= '
		' . $__templater->escape($__vars['headTag']) . '
	';
		}
	}
	$__finalCompiled .= '

	';
	if ((!$__vars['head']['meta_site_name']) AND !$__templater->test($__vars['siteName'], 'empty', array())) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'site_name', array(
			'siteName' => $__vars['siteName'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_type']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'type', array(
			'type' => 'website',
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_title']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'title', array(
			'title' => ($__templater->func('page_title', array(), false) ?: $__vars['siteName']),
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if ((!$__vars['head']['meta_description']) AND (!$__templater->test($__vars['description'], 'empty', array()) AND $__vars['pageDescriptionMeta'])) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'description', array(
			'description' => $__vars['description'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if (!$__vars['head']['meta_share_url']) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'share_url', array(
			'shareUrl' => $__vars['xf']['fullUri'],
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '
	';
	if ((!$__vars['head']['meta_image_url']) AND $__templater->func('property', array('publicMetadataLogoUrl', ), false)) {
		$__finalCompiled .= '
		' . $__templater->callMacro('metadata_macros', 'image_url', array(
			'imageUrl' => $__templater->func('base_url', array($__templater->func('property', array('publicMetadataLogoUrl', ), false), true, ), false),
			'output' => true,
		), $__vars) . '
	';
	}
	$__finalCompiled .= '

	' . $__templater->callMacro('helper_js_global', 'head', array(
		'app' => 'public',
	), $__vars) . '

	';
	if ($__templater->func('property', array('publicFaviconUrl', ), false)) {
		$__finalCompiled .= '
		<link rel="icon" type="image/png" href="' . $__templater->func('base_url', array($__templater->func('property', array('publicFaviconUrl', ), false), true, ), true) . '" sizes="32x32" />
	';
	}
	$__finalCompiled .= '
	' . $__templater->includeTemplate('google_analytics', $__vars) . '
</head>
	
	
	
	
	
<body data-template="' . $__templater->escape($__vars['template']) . '">
<div class="p-pageWrapper" id="top">
<div class="p-body">
	<div class="p-body-inner">
		<!--XF:EXTRA_OUTPUT-->


		' . $__templater->callMacro('browser_warning_macros', 'javascript', array(), $__vars) . '
		' . $__templater->callMacro('browser_warning_macros', 'browser', array(), $__vars) . '

		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
				';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
						';
	if (!$__vars['noH1']) {
		$__compilerTemp2 .= '
							<h1 class="p-title-value">' . $__templater->escape($__vars['h1']) . '</h1>
						';
	}
	$__compilerTemp2 .= '
						';
	$__compilerTemp3 = '';
	$__compilerTemp3 .= (isset($__templater->pageParams['pageAction']) ? $__templater->pageParams['pageAction'] : '');
	if (strlen(trim($__compilerTemp3)) > 0) {
		$__compilerTemp2 .= '
							<div class="p-title-pageAction">' . $__compilerTemp3 . '</div>
						';
	}
	$__compilerTemp2 .= '
					';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__compilerTemp1 .= '
					<div class="p-title ' . ($__vars['noH1'] ? 'p-title--noH1' : '') . '">
					' . $__compilerTemp2 . '
					</div>
				';
	}
	$__compilerTemp1 .= '

				';
	if (!$__templater->test($__vars['description'], 'empty', array())) {
		$__compilerTemp1 .= '
					<div class="p-description">' . $__templater->escape($__vars['description']) . '</div>
				';
	}
	$__compilerTemp1 .= '
			';
	if (!$__templater->test($__vars['headerHtml'], 'empty', array())) {
		$__finalCompiled .= '
			<div class="p-body-header">
				' . $__templater->filter($__vars['headerHtml'], array(array('raw', array()),), true) . '
			</div>
		';
	} else if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			<div class="p-body-header">
			' . $__compilerTemp1 . '
			</div>
		';
	}
	$__finalCompiled .= '

		<div class="p-body-main">
			<div class="p-body-content">
				<div class="p-body-pageContent">' . $__templater->filter($__vars['content'], array(array('raw', array()),), true) . '</div>
			</div>
		</div>
	</div>
</div>

</div> <!-- closing p-pageWrapper -->
	
	



</body>
</html>';
	return $__finalCompiled;
}
);