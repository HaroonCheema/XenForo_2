<?php
// FROM HASH: 48ee7479f4b6f6061907b021e103162b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Change Media Picture' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['mediaItem']['title']));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['category'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->callMacro('ts_mgm_xfmg_media_add_macros', 'add_form', array(
		'mediaItem' => $__vars['mediaItem'],
		'category' => $__vars['category'],
		'album' => $__vars['album'],
		'canUpload' => $__templater->method($__vars['category'], 'canUploadMedia', array()),
		'canEmbed' => $__templater->method($__vars['category'], 'canEmbedMedia', array()),
		'attachmentData' => $__vars['attachmentData'],
		'allowCreateAlbum' => ($__vars['album'] ? true : false),
	), $__vars);
	return $__finalCompiled;
}
);