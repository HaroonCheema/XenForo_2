<?php
// FROM HASH: d41d8cd98f00b204e9800998ecf8427e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
' . $__templater->includeTemplate('Fs_NodeIcon_icon.less', $__vars) . '

@media (max-width: 424px)
{
	[data-template="fs_tbn_forum_view_type_article"] {
		.articlePreview-image {
			display: none;
		}
	}
}';
	return $__finalCompiled;
}
);